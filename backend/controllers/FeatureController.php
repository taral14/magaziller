<?php

class FeatureController extends Controller
{

	public $layout='/layouts/column2';

	public function filters()
	{
		return array(
			'accessControl',
		);
	}

	public function accessRules()
	{
		return array(
			array('allow', 'roles'=>array('content')),
			array('deny', 'users'=>array('*')),
		);
	}

	public function actionCreate()
	{
		$model=new Feature;

		$this->performAjaxValidation($model);

		if(isset($_POST['Feature']))
		{
			$model->attributes=$_POST['Feature'];

			if($model->save()) {
                Yii::app()->user->setFlash('success', "Характеристика добавлена");
				$this->redirect(isset($_GET['returnUrl'])?$_GET['returnUrl']:array('update','id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Характеристика не добавлена");
            }
		} else if(isset($_GET['Feature'])) {
            $model->attributes=$_GET['Feature'];
        }

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST['Feature']))
		{
			$model->attributes=$_POST['Feature'];

			if($model->save()) {
                Yii::app()->user->setFlash('success', "Изменения сохранены");
                $this->redirect(isset($_GET['returnUrl'])?$_GET['returnUrl']:array('update','id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Изменения не сохранены");
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

    public function actionLoadAlowedValues($id) {
        $result=FeatureValue::model()->findValues($id);
        echo function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);
        Yii::app()->end();
    }

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model=$this->loadModel($id);
            Yii::app()->user->setFlash('success', "Характеристика &quot;{$model->name}&quot; удалена");
            $model->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
		$model=new Feature('search');
		$model->unsetAttributes();
		if(isset($_GET['Feature']))
			$model->attributes=$_GET['Feature'];

		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Feature::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='feature-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
