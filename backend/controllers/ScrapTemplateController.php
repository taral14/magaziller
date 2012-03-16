<?php
/**
 * User: Taral
 * Date: 06.12.11
 * Time: 12:42
 */

class ScrapTemplateController extends Controller
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

	public function actionCreate($scrap_id)
	{
		$model=new ScrapTemplate;
        $model->scrap_id=$scrap_id;

		$this->performAjaxValidation($model);

		if(isset($_POST['ScrapTemplate']))
		{
			$model->attributes=$_POST['ScrapTemplate'];
			if($model->save()) {
                Yii::app()->user->setFlash('success', "Шаблон добавлен");
                $this->redirect(isset($_GET['returnUrl'])?$_GET['returnUrl']:array('update','id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Шаблон не добавлен");
            }
		}
        else if(isset($_GET['ScrapTemplate']))
        {
            $model->attributes=$_GET['ScrapTemplate'];
        }

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST['ScrapTemplate']))
		{
			$model->attributes=$_POST['ScrapTemplate'];
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

	public function actionDelete($id)
	{
        $model=$this->loadModel($id);
        $scrap_id=$model->scrap_id;
        Yii::app()->user->setFlash('success', "Шаблон &quot;{$model->name}&quot; удален");
        $model->delete();

        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('scrap/update', 'id'=>$scrap_id, '#'=>'templates'));
	}

	public function loadModel($id)
	{
		$model=ScrapTemplate::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='scrap-template-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
