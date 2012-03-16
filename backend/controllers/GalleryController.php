<?php
/**
 * User: Taral
 * Date: 20.09.11
 * Time: 14:20
 */

class GalleryController extends Controller
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
		$model=new Gallery;

		$this->performAjaxValidation($model);

		if(isset($_POST['Gallery']))
		{
			$model->attributes=$_POST['Gallery'];
			if($model->save()) {
                Yii::app()->user->setFlash('success', "Галерея добавлена");
                $this->redirect(array('update','id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Галерея не добавлена");
            }
		}
        else if(isset($_GET['Gallery']))
        {
            $model->attributes=$_GET['Gallery'];
        }

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST['Gallery']))
		{
			$model->attributes=$_POST['Gallery'];
			if($model->save()) {
                $fileImages=CUploadedFile::getInstancesByName('GalleryImage[filename]');
                foreach($fileImages as $fileImage) {
                    $image=new GalleryImage();
                    $image->setImageFile($fileImage);

                    $behaviors=$image->behaviors();
                    $config=$behaviors['ImageUploadBehavior']['images'];
                    if($model->small_width && $model->small_height) {
                        $config['small'][1]=$model->small_width;
                        $config['small'][2]=$model->small_height;
                        $config['small']['resize']='normal';
                    } else if ($model->small_width) {
                        $config['small'][1]=$model->small_width;
                        $config['small']['resize']='width';
                    } else if($model->small_height) {
                        $config['small'][2]=$model->small_height;
                        $config['small']['resize']='height';
                    }

                    if($model->large_width && $model->large_height) {
                        $config['large'][1]=$model->large_width;
                        $config['large'][2]=$model->large_height;
                        $config['large']['resize']='normal';
                    } else if ($model->large_width) {
                        $config['large'][1]=$model->large_width;
                        $config['large']['resize']='width';
                    } else if($model->large_height) {
                        $config['large'][2]=$model->large_height;
                        $config['large']['resize']='height';
                    }

                    $image->setImages($config);
                    $model->addImage($image);
                }
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
            Yii::app()->user->setFlash('success', "Галерея &quot;{$model->name}&quot; удалена");
            $model->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
        $model=new Gallery('search');
        $model->unsetAttributes();
		if(isset($_GET['Gallery']))
			$model->attributes=$_GET['Gallery'];
		$this->render('index',array(
			'model'=>$model,
		));
	}

	public function loadModel($id)
	{
		$model=Gallery::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='gallery-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
