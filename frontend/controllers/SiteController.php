<?php

class SiteController extends Controller
{
    public $layout='//layouts/column2';
	/**
	 * Declares class-based actions.
	 */
	public function actions()
	{
		return array(
			// captcha action renders the CAPTCHA image displayed on the contact page
			'captcha'=>array(
				'class'=>'CCaptchaAction',
				'backColor'=>0xFFFFFF,
			),
			// page action renders "static" pages stored under 'protected/views/site/pages'
			// They can be accessed via: index.php?r=site/page&view=FileName
			'page'=>array(
				'class'=>'CViewAction',
			),
		);
	}

	public function actionIndex()
	{
        $this->layout='//layouts/main';
		$this->render('index');
	}

	public function actionError()
	{
	    if($error=Yii::app()->errorHandler->error)
	    {
	    	if(Yii::app()->request->isAjaxRequest)
	    		echo $error['message'];
	    	else {
                $this->breadcrumbs=array('Страницы не существует');
	        	$this->render('error', $error);
            }
	    }
	}

	public function actionContact()
	{
		$contact=new ContactForm;

		if(isset($_POST['ContactForm']))
		{
			$contact->attributes=$_POST['ContactForm'];
			if($contact->validate())
			{
				$headers="From: {$contact->email}\r\nReply-To: {$contact->email}";
				mail(Yii::app()->config['contact_email'],$contact->subject,$contact->body,$headers);
				Yii::app()->user->setFlash('contact','Благодарим вас за обращение к нам. Мы ответим вам как можно скорее.');
				$this->refresh();
			}
		}

        $this->breadcrumbs=array('Контакты');
		$this->render('contact',array('contact'=>$contact));
	}

    public function actionPhone() {

    }

    public function actionCurrency($id) {
        $model=Currency::model()->findByPk((int)$id);
      	if($model===null)
      		throw new CHttpException(404,'The requested page does not exist.');
        Yii::app()->currency->setActive($model->id);
        $this->redirect(isset($_GET['returnUrl']) ? $_GET['returnUrl'] : array('site/index'));
    }

	public function actionLogin()
	{
		$login=new LoginForm;

		if(isset($_POST['ajax']) && $_POST['ajax']==='login-form')
		{
			echo CActiveForm::validate($login);
			Yii::app()->end();
		}

		if(isset($_POST['LoginForm']))
		{
			$login->attributes=$_POST['LoginForm'];

			if($login->validate() && $login->login())
				$this->redirect(Yii::app()->user->returnUrl);
		}

        $this->breadcrumbs=array('Авторизация');
		$this->render('login',array('login'=>$login));
	}

	public function actionLogout()
	{
		Yii::app()->user->logout();
		$this->redirect(Yii::app()->homeUrl);
	}
}