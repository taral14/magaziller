<?php
class OrderController extends Controller {

    public $layout='//layouts/column2';

    public function actions()
   	{
   		return array(
   			'LiqPay'=>array(
   				'class'=>'CLiqPayAction',
   			),
   		);
   	}

    public function actionIndex() {
        if(Yii::app()->cart->isEmpty) {
            $this->redirect(array('order/clear'));
        }
        $order=new Order;

        $this->performAjaxValidation($order);

        if(isset($_POST['Order'])) {

            $order->attributes=$_POST['Order'];
            if($order->delivery)
                $order->delivery_price=$order->delivery->priceTo(Yii::app()->cart->cost);
            $order->user_id=Yii::app()->user->id;
            $order->referer=Yii::app()->user->getState('referer');
            $order->ip=Yii::app()->request->userHostAddress;

            if(strstr($order->referer, 'google')!==false)
                preg_match('#.*?[\?\&]q=(.+?)&.*#', $order->referer, $match);
            elseif(strstr($order->referer, 'yandex')!==false)
                preg_match('#.*?[\?\&]text=(.+?)&.*#', $order->referer, $match);

            if(isset($match) && array_key_exists(1, $match))
                $order->search_terms = urldecode($match[1]);

            if($order->save()) {
                foreach(Yii::app()->cart->products as $product) {
                    $order->addProduct($product);
                }
                Yii::app()->cart->clear();
                $this->onOrder(new CEvent($order));
                $this->redirect(array('success', 'key'=>$order->encodeKey));
            }
        }

        $this->breadcrumbs=array(
            'Оформление заказа'
        );

        $this->render('index', array(
            'cart'=>Yii::app()->cart,
            'order'=>$order,
        ));
    }

     public function actionSuccess($key=null) {
         $this->breadcrumbs=array(
             'Ваш заказ оформлен'
         );
         $this->render('success', array(
             'key'=>$key,
         ));
     }

    public function actionClear() {
        $this->breadcrumbs=array(
            'Корзина пуста'
        );
        $this->render('clear');
    }

    public function actionPay($key) {
        $order=$this->loadModelByKey($key);

        if(isset($_POST['Order']['payment_id'])) {
            $order->payment_id=$_POST['Order']['payment_id'];
            $order->save(false);
        }

        $this->breadcrumbs=array(
            'Оплата заказа №'.$order->id
        );
        Yii::app()->seo->metaTitle=Yii::app()->config['shop_name'].' - Оплата заказа №'.$order->id;

        $this->render('pay', array(
            'order'=>$order,
        ));
    }

    public function actionReceipt($key) {
        $this->layout=false;
        $order=$this->loadModelByKey($key);

        Yii::app()->seo->metaTitle=Yii::app()->config['shop_name'].' - Квитанция оплаты заказа №'.$order->id;

        $data=CArray::overwrite(array(
            'recipient'=>'',
            'inn'=>'',
            'account'=>'',
            'bank'=>'',
            'bik'=>'',
            'correspondent_account'=>'',
            'banknote'=>'',
            'pense'=>'',
            'name'=>'',
            'address'=>'',
            'order_id'=>$order->id,
            'cost_banknote'=>Yii::app()->priceFormatter->templateFormat('{banknote}', $order->getCost(), $order->payment->currency_id),
            'cost_pense'=>Yii::app()->priceFormatter->templateFormat('{pense}', $order->getCost(), $order->payment->currency_id),
        ),$order->payment->getHandlerParams(),isset($_POST['Receipt'])?$_POST['Receipt']:array());

        $this->render('receipt', $data);
    }

    public function actionUpdate() {
        if(isset($_POST['Product'])) {
            $products=Yii::app()->cart->products;
            foreach($products as $i=>$product) {
                if(isset($_POST['Product'][$i]['quantity'])) {
                    Yii::app()->cart->update($product, $_POST['Product'][$i]['quantity']);
                } else {
                    Yii::app()->cart->remove($product->id);
                }
            }
        } else {
            Yii::app()->cart->clear();
        }
        $this->redirect(array('order/index'));
    }

    public function actionRemove($id) {
        Yii::app()->cart->remove($id);
        $this->redirect(array('order/index'));
    }

    public function actionPut($id, $quantity=null) {
        $quantity=max((int)$quantity, 1);
		$product=Product::model()->findByPk((int)$id);
		if($product===null)
			throw new CHttpException(404,'The requested page does not exist.');

        Yii::app()->cart->put($product, $quantity);
        $this->renderPartial('_view');
    }

    public function actionSetProductQuantity($product_id, $quantity) {
        $product=Product::model()->findByPk($product_id);
        if($product===null)
      			throw new CHttpException(404,'The requested page does not exist.');
        Yii::app()->cart->update($product, $quantity);
        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('order/index'));
    }

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='order-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

    public function onOrder(CEvent $event) {
        $this->raiseEvent('onOrder', $event);
    }

    public function loadModelByKey($key) {
        $order=Order::model()->findByEncodeKey($key);
        if($order==null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $order;
    }
}
