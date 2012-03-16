<?php
/**
 * User: Taral
 * Date: 02.12.11
 * Time: 16:22
 */

class ScrapController extends Controller
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
		$model=new Scrap;

		$this->performAjaxValidation($model);

		if(isset($_POST['Scrap']))
		{
			$model->attributes=$_POST['Scrap'];
			if($model->save()) {
                Yii::app()->user->setFlash('success', "Элемент страницы добавлен");
                $this->redirect(array('update','id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Элемент страницы не добавлен");
            }
		}
        else if(isset($_GET['Scrap']))
        {
            $model->attributes=$_GET['Scrap'];
        }

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST['Scrap']))
		{
			$model->attributes=$_POST['Scrap'];
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

    public function actionView($id) {
        $model=$this->loadModel($id);
        $items=$model->items;
        if(isset($_POST['ScrapItem'])) {
            $valid=true;

            foreach($items as $i=>$item)
            {
                if(isset($_POST['ScrapItem'][$i]))
                    $item->attributes=$_POST['ScrapItem'][$i];

                $fileImage=CUploadedFile::getInstanceByName("ScrapItem[$i][image]");

                if($fileImage)
                    $item->setImageFile($fileImage);

                $behaviors=$item->behaviors();
                $config=$behaviors['ImageUploadBehavior']['images'];

                if($item->template->image_width && $item->template->image_height) {
                    $config['default'][1]=$item->template->image_width;
                    $config['default'][2]=$item->template->image_height;
                    $config['default']['resize']='fill';
                } else if ($item->template->image_width) {
                    $config['default'][1]=$item->template->image_width;
                    $config['default']['resize']='width';
                } else if($item->template->image_height) {
                    $config['default'][2]=$item->template->image_height;
                    $config['default']['resize']='height';
                }

                $item->setImages($config);

                $valid=$item->save() && $valid;
            }

            if($valid) {
                Yii::app()->user->setFlash('success', "Изменения сохранены");
                $this->redirect(array('view', 'id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Изменения не сохранены");
            }
        }

		$this->render('view',array(
			'model'=>$model,
            'items'=>$items,
		));
    }

    public function actionPreview($id) {
        $model=$this->loadModel($id);
		$this->render('preview',array(
			'model'=>$model,
		));
    }

	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
            $model=$this->loadModel($id);
            Yii::app()->user->setFlash('success', "Элемент страницы &quot;{$model->name}&quot; удален");
            $model->delete();

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	public function actionIndex()
	{
        $dataProvider=new CActiveDataProvider('Scrap');
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	public function loadModel($id)
	{
		$model=Scrap::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='scrap-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
