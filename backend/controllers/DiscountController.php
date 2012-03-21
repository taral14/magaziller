<?php
class DiscountController extends Controller
{
    /**
   	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
   	 * using two-column layout. See 'protected/views/layouts/column2.php'.
   	 */
   	public $layout='/layouts/column2';

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
   			array('allow', 'roles'=>array('content')),
   			array('deny', 'users'=>array('*')),
   		);
   	}

    /**
   	 * Creates a new model.
   	 * If creation is successful, the browser will be redirected to the 'view' page.
   	 */
   	public function actionCreate()
   	{
   		$model=new Discount;

   		// Uncomment the following line if AJAX validation is needed
   		$this->performAjaxValidation($model);

   		if(isset($_POST['Discount']))
   		{
   			$model->attributes=$_POST['Discount'];
            if($model->save()) {
                Yii::app()->user->setFlash('success', "Скидка добавлена");
                $this->redirect(array('update','id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Скидка не добавлена");
            }
   		}
        else if(isset($_GET['Discount']))
        {
            $model->attributes=$_GET['Discount'];
        }

   		$this->render('create',array(
   			'model'=>$model,
   		));
   	}

   	/**
   	 * Updates a particular model.
   	 * If update is successful, the browser will be redirected to the 'view' page.
   	 * @param integer $id the ID of the model to be updated
   	 */
   	public function actionUpdate($id)
   	{
   		$model=$this->loadModel($id);

   		// Uncomment the following line if AJAX validation is needed
   		$this->performAjaxValidation($model);

   		if(isset($_POST['Discount']))
   		{
   			$model->attributes=$_POST['Discount'];
            if($model->save()) {
                Yii::app()->user->setFlash('success', "Изменения сохранены");
                $this->refresh();
            } else {
                Yii::app()->user->setFlash('error', "Изменения не сохранены");
            }
   		}

   		$this->render('update',array(
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
            Yii::app()->user->setFlash('success', "Скидка &quot;{$model->name}&quot; удалена");
            $model->delete();

   			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
   			if(!isset($_GET['ajax']))
   				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
   		}
   		else
   			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
   	}

   	/**
   	 * Lists all models.
   	 */
    public function actionIndex()
    {
        $model=new Discount('search');
        $model->unsetAttributes();

        if(isset($_GET['Discount']))
            $model->attributes=$_GET['Discount'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }

   	/**
   	 * Returns the data model based on the primary key given in the GET variable.
   	 * If the data model is not found, an HTTP exception will be raised.
   	 * @param integer the ID of the model to be loaded
   	 */
   	public function loadModel($id)
   	{
   		$model=Discount::model()->findByPk((int)$id);
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
   		if(isset($_POST['ajax']) && $_POST['ajax']==='discount-form')
   		{
   			echo CActiveForm::validate($model);
   			Yii::app()->end();
   		}
   	}
}