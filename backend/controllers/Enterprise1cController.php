<?php
class Enterprise1cController extends Controller {

    public $layout='/layouts/column2';

    public $menu=array(
        array('label'=>'Основные', 'url'=>array('index')),
        array('label'=>'Характеристики', 'url'=>array('feature')),
    );

   	public function filters()
   	{
   		return array(
   			'accessControl',
   		);
   	}

   	public function accessRules()
   	{
   		return array(
            array('allow',
                 'actions'=>array('exchange'),
                 'users'=>array('*'),
            ),
   			array('allow', 'roles'=>array('content')),
   			array('deny', 'users'=>array('*')),
   		);
   	}

    public function actionIndex() {
        $model=$this->loadConfigModel();

        if(isset($_POST['ajax']) && $_POST['ajax']==='config-form')
        {
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }

        if(isset($_POST['Config']))
       	{
       		$model->attributes=$_POST['Config'];
       		if($model->save()) {
                 Yii::app()->user->setFlash('success', "Изменения сохранены");
                 $this->refresh();
             }
       	}

        $this->breadcrumbs=array(
            'Интеграция с 1С'
        );

        $this->render('index', array(
            'model'=>$model
        ));
    }

    public function actionFeature() {
        $items=Feature::model()->findAll(array('with'=>'pack'));

        if(isset($_POST['Feature']))
        {
            $valid=true;
            foreach($items as $i=>$item)
            {
                if(isset($_POST['Feature'][$i]))
                    $item->attributes=$_POST['Feature'][$i];
                $valid=$item->validate() && $valid;
            }

            if($valid) {
                foreach($items as $item) {
                    $item->save();
                }
                Yii::app()->user->setFlash('success', "Изменения сохранены");
                $this->refresh();
            } else {
                Yii::app()->user->setFlash('error', "Изменения не сохранены");
            }
        }

        $this->breadcrumbs=array(
            'Интеграция с 1С'=>array('index'),
            'Характеристики'
        );

        $this->render('feature', array(
            'items'=>$items
        ));
    }

    public function actionExchange($type, $mode) {
        if($mode=='checkauth') {
            if(
                isset($_SERVER['PHP_AUTH_USER']) &&
                isset($_SERVER['PHP_AUTH_PW']) &&
                $_SERVER['PHP_AUTH_USER']==Yii::app()->config['enterprise_1c_login'] &&
                $_SERVER['PHP_AUTH_PW']==Yii::app()->config['enterprise_1c_password']
            ) {
                Yii::app()->user->setState('1c_auth', true);
                echo "success\n";
                echo session_name()."\n";
                echo session_id() ."\n";
                exit;
            } else {
                echo "failure\n";
                echo "error_authorize";
                exit;
            }
        }

        if(Yii::app()->user->getState('1c_auth')==false) {
            echo "failure\n";
            echo "session_not_valid";
            exit;
        }

        if($mode=='init') {
            echo "zip=no\n";
            echo "file_limit=2000000";
            exit;
        }

        @set_time_limit(0);

        $dump='$_GET = '.CVarDumper::dumpAsString($_GET)."\n";
        $dump.='$_POST = '.CVarDumper::dumpAsString($_POST)."\n";
        $dump.='$_FILES = '.CVarDumper::dumpAsString($_FILES)."\n";
        Yii::log($dump, 'application');

        // передает сайту данные по товарной номенклатуре
        if($type=='catalog' && $mode=='file') {
            echo "failure\n";
            echo "upload_products_test";
            exit;
        }

        // запрашивает с сайта заказы покупателей
        if($type=='sale' && $mode=='query') {
            echo "failure\n";
            echo "sale_orders_test";
            exit;
        }

        // передает сайту данные о результатах обработки ранее полученных заказов
        if($type=='sale' && $mode=='file') {
            echo "failure\n";
            echo "upload_orders_test";
            exit;
        }

        echo "failure\n";
        echo "unknown_error";
        exit;
    }

    public function actionExport($download=0, $size='new', $amount=50) {
        $config=$this->loadConfigModel();
        header('Content-Type: text/xml; charset=windows-1251');
        if($download)
            header('Content-Disposition: attachment; filename="1c_export.xml"'."\r\n");

        $currency_code=Yii::app()->currency->basic['code'];

        $orders=array();
        switch($size) {
            case 'all':
                $orders=Order::model()->findAll(array('order'=>'create_time DESC'));
                break;
            case 'new':
                $orders=Order::model()->findAll(array(
                    'order'=>'create_time DESC',
                    'condition'=>'create_time>=:time',
                    'params'=>array(':time'=>Yii::app()->config['enterprise_1c_export_orders_time'])
                ));
                break;
            case 'amount':
                $amount=intval($amount);
                $amount or $amount=50;
                $orders=Order::model()->findAll(array(
                    'order'=>'create_time DESC',
                    'limit'=>$amount,
                ));
                break;
        }

        $dom=new DOMDocument('1.0', 'windows-1251');
        $kom_inf=$dom->createElement('КоммерческаяИнформация');
        $kom_inf->setAttribute('ВерсияСхемы', '2.03');
        $kom_inf->setAttribute('ДатаФормирования', date('Y-m-d H:i'));

        foreach($orders as $order) {
            $document=$dom->createElement('Документ');

            $document->appendChild($dom->createElement('Ид', $order->id));
            $document->appendChild($dom->createElement('Номер', $order->id));
            $document->appendChild($dom->createElement('Дата', date('Y-m-d', strtotime($order->create_time))));
            $document->appendChild($dom->createElement('ХозОперация', 'Заказ товара'));
            $document->appendChild($dom->createElement('Роль', 'Продавец'));
            $document->appendChild($dom->createElement('Валюта', $currency_code));
            $document->appendChild($dom->createElement('Курс', 1));
            $document->appendChild($dom->createElement('Сумма', $order->getCost()));
            $document->appendChild($dom->createElement('Время', date('H:i:s', strtotime($order->create_time))));
            $document->appendChild($dom->createElement('Комментарий', $order->comment));

            $dom_products=$dom->createElement('Товары');
            foreach($order->products as $product) {
                $dom_product=$dom->createElement('Товар');
                $dom_product->appendChild($dom->createElement('Ид', $product->enterprise_1c_id));
                $dom_product->appendChild($dom->createElement('Наименование', $product->name));
                $dom_product->appendChild($dom->createElement('БазоваяЕдиница', $product->unit));
                $dom_product->appendChild($dom->createElement('ЦенаЗаЕдиницу', $product->price));
                $dom_product->appendChild($dom->createElement('Количество', $product->getQuantity()));
                $dom_product->appendChild($dom->createElement('Сумма', $product->sumPrice));

                $dom_products->appendChild($dom_product);
            }
            $document->appendChild($dom_products);

            $dom_details=$dom->createElement('ЗначенияРеквизитов');

            foreach(array(
                'Дата оплаты'=>date('Y-m-d H:i:s', $order->payment_time),
                'Метод оплаты'=>$order->payment->name,
                'Отменен'=>($order->status==Order::STATUS_DELETE)?'true':'false',
                'Финальный статус'=>($order->status==Order::STATUS_COMPLETE)?'true':'false',
                'Статус заказа'=>Lookup::item('OrderStatus', $order->status),
                'Заказ оплачен'=>($order->payment_status==Order::PAYMENT_STATUS_SUCCESS)?'true':'false',
            ) as $detail_label=>$detail_value) {
                $dom_detail=$dom->createElement('ЗначениеРеквизита');
                $dom_detail->appendChild($dom->createElement('Наименование', $detail_label) );
                $dom_detail->appendChild($dom->createElement('Значение', $detail_value) );
                $dom_details->appendChild($dom_detail);
            }

            $document->appendChild($dom_details);

            $kom_inf->appendChild($document);
        }

        $dom->appendChild($kom_inf);
        echo $dom->saveXML();
        $config->enterprise_1c_export_orders_time=time();
        $config->save(false);
        die;
    }

    public function loadConfigModel()
   	{
   		$model=Config::model()->findByPk(1);
   		if($model===null)
   			throw new CHttpException(404,'The requested page does not exist.');
   		return $model;
   	}

}