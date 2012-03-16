<?php
class UserController extends Controller {

    public $layout='//layouts/column2';

    public function actionRegister() {
        $user=new User('register');

        $this->performAjaxValidation($user);

        if(isset($_POST['User'])) {
            $user->attributes=$_POST['User'];
            $user->role=User::ROLE_CLIENT;
            $user->status=User::STATUS_ENABLED;
            if($user->save()) {
                $this->onRegister(new CEvent($user));
                Yii::app()->user->setFlash('register','Вы успешно зарегестрировались. Вы можете войти в систему используя свой логин и пароль.');
            }
        }

        $this->breadcrumbs=array('Регистрация');
        $this->render('register', array(
            'user'=>$user
        ));
    }

    public function onRegister(CEvent $event) {
        $this->raiseEvent('onRegister', $event);
    }

	public function loadModel()
	{
		$model=User::model()->findByPk(Yii::app()->user->id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='user-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}