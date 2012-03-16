<?php
class SiteController extends Controller {

    public $layout='//layouts/column1';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
            array('allow',
                  'actions'=>array('login'),
                  'users'=>array('*'),
            ),
			array('allow', 'roles'=>array('moderator')),
			array('deny', 'users'=>array('*')),
		);
	}

	public function actionIndex()
	{
		$this->render('index', array(
            'menu'=>include Yii::getPathOfAlias('application.config.topMenu').'.php'
        ));
	}

    public function actionElfinder() {
        $this->render('elfinder');
    }

	public function actionLogin()
	{
		$model=new LoginForm;

		// if it is ajax validation request
		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}

		// collect user input data
		if(isset($_POST['LoginForm']))
		{
			$model->attributes=$_POST['LoginForm'];
			// validate user input and redirect to the previous page if valid
			if($model->validate() && $model->login()) {
                Yii::app()->user->setFlash('success', "Вы успешно авторизировались");
				$this->redirect(Yii::app()->user->returnUrl);
            }
		}
        $this->topMenu=array(
            array('label'=>'Войти', 'url'=>array('site/login')),
        );
		// display the login form
		$this->render('login',array('model'=>$model));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}

	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else
	        	$this->render('error', $error);
	    }
	}
    
}