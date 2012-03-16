<?php

class CurrencyController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='/layouts/column1';

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
			array('allow', 'roles'=>array('manager')),
			array('deny', 'users'=>array('*')),
		);
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Currency;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['Currency']))
		{
			$model->attributes=$_POST['Currency'];
			if($model->save()) {
                Yii::app()->user->setFlash('success', "Валюта добавлена");
				$this->redirect(array('index'));
            } else {
                Yii::app()->user->setFlash('error', "Валюта не добавлена");
            }
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'index' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			// we only allow deletion via POST request
			$model=$this->loadModel($id);
            if(Yii::app()->config['currency_default']==$model->id || Yii::app()->config['currency_basic']==$model->id) {
                Yii::app()->user->setFlash('error', "Валюта &quot;{$model->name}&quot; не может быть удалена");
            } else {
                Yii::app()->user->setFlash('success', "Валюта &quot;{$model->name}&quot; удалена");
                $model->delete();
            }

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

    public function actionIndex() {
        $currencies=Currency::model()->findAll();
        if(isset($_POST['Currency'])) {
            $valid=true;
            foreach($currencies as $i=>$currency) {
                if(isset($_POST['Currency'][$i]))
                    $currency->attributes=$_POST['Currency'][$i];
                $valid=$currency->validate() && $valid;
            }
            if($valid) {
                foreach($currencies as $currency)
                    $currency->save();
                Yii::app()->user->setFlash('success', "Изменения сохранены");
            } else {
                Yii::app()->user->setFlash('error', "Изменения не сохранены");
            }
        }
        $this->render('batchUpdate',array(
            'currencies'=>$currencies,
        ));
    }

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=Currency::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='currency-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
