<?php
/**
 * User: Taral
 * Date: 17.10.11
 * Time: 20:40
 */

class MarketController extends Controller
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
		$model=new Market;

		$this->performAjaxValidation($model);

		if(isset($_POST['Market']))
		{
			$model->attributes=$_POST['Market'];

            if(!empty($_POST['Categories']))
                $model->categories=Category::model()->findAllByAttributes(array('id'=>$_POST['Categories']));

			if($model->save()) {
                Yii::app()->user->setFlash('success', "Экспорт в торговую площадку добавлен");
                $this->redirect(array('update','id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Экспорт в торговую площадку не добавлен");
            }
		}
        else if(isset($_GET['Market']))
        {
            $model->attributes=$_GET['Market'];
        }

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST['Market']))
		{
			$model->attributes=$_POST['Market'];

            if(empty($_POST['Categories']))
                $model->categories=array();
            else
                $model->categories=Category::model()->findAllByAttributes(array('id'=>$_POST['Categories']));

			if($model->save()) {
                Yii::app()->user->setFlash('success', "Изменения сохранены");
				$this->redirect(array('update','id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Изменения не сохранены");
            }
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			$model=$this->loadModel($id);
            Yii::app()->user->setFlash('success', "Экспорт {$model->name}.xml удален");
            $model->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
        $model=new Market('search');
        $model->unsetAttributes();
		if(isset($_GET['Market']))
			$model->attributes=$_GET['Market'];
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Market::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='market-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
