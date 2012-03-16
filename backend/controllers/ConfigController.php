<?php
/**
 * User: Taral
 * Date: 30.09.11
 * Time: 21:18
 */

class ConfigController extends Controller
{
	public $layout='/layouts/column2';

    public $menu=array(
        array('label'=>'Основные', 'url'=>array('index', 'section'=>'basic')),
        array('label'=>'SEO информация', 'url'=>array('seo')),
        array('label'=>'Изображения', 'url'=>array('index', 'section'=>'images')),
	    array('label'=>'Контент', 'url'=>array('index', 'section'=>'content')),
        array('label'=>'Страницы', 'url'=>array('index', 'section'=>'pages')),
        array('label'=>'Интеграция', 'url'=>array('index', 'section'=>'integration')),
        array('label'=>'Заказы', 'url'=>array('index', 'section'=>'order')),
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
			array('allow', 'roles'=>array('admin')),
			array('deny', 'users'=>array('*')),
		);
	}

	public function actionIndex($section='basic')
	{
        $exist=false;
        foreach($this->menu as $i=>$item) {
            if($item['url']['section']==$section) {
                $this->breadcrumbs=array(
                    'Настройки'=>$this->createUrl('index'),
                    $item['label']
                );
                $this->menu[$i]['active']=true;
                $exist=true;
            }
        }
        if($exist==false)
            throw new CHttpException(404,'The requested page does not exist.');

        $model=$this->loadModel();

      	$this->performAjaxValidation($model);

      	if(isset($_POST['Config']))
      	{
      		$model->attributes=$_POST['Config'];
      		if($model->save()) {
                Yii::app()->user->setFlash('success', "Изменения сохранены");
      		    $this->redirect(array('index', 'section'=>$section));
            } else {
                Yii::app()->user->setFlash('error', "Изменения не сохранены");
            }
      	}

      	$this->render($section, array(
    	    'model'=>$model,
      	));
	}

    public function actionSeo() {
        $models=SEO::model()->findAll(array(
            'join'=>'JOIN {{lookup}} as t2 ON t2.code=t.route',
            'order'=>'t2.position',
            'condition'=>'entity=0',
        ));
        $this->menu[1]['active']=true;
        if(isset($_POST['SEO'])) {
            $valid=true;
            foreach($models as $i=>$model) {
                if(isset($_POST['SEO'][$i]))
                    $model->attributes=$_POST['SEO'][$i];
                $valid=$model->validate() && $valid;
            }
            if($valid) {
                foreach($models as $i=>$model)
                    $model->save();

                Yii::app()->user->setFlash('success', "Изменения сохранены");
                $this->refresh();
            }
        }

        $this->breadcrumbs=array(
        	'SEO информация'
        );

        $this->render('seo', array(
            'models'=>$models
        ));
    }

	public function loadModel()
	{
		$model=Config::model()->findByPk(1);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='config-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
