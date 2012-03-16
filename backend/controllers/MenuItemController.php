<?php

class MenuItemController extends Controller
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
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MenuItem;

		// Uncomment the following line if AJAX validation is needed
		$this->performAjaxValidation($model);

		if(isset($_POST['MenuItem']))
        {
			$model->attributes=$_POST['MenuItem'];
			if($model->save()) {
				Yii::app()->user->setFlash('success', "Пункт меню добавлен");
				$this->redirect(array('update','id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Пункт меню не добавлен");
            }
		}
        else if(isset($_GET['MenuItem']))
        {
            $model->attributes=$_GET['MenuItem'];
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

		if(isset($_POST['MenuItem']))
		{
			$model->attributes=$_POST['MenuItem'];
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

    public function actionSaveOrder() {
		if(isset($_POST['MenuItem_id']))
        {
            $menuItems=MenuItem::model()->findAllByAttributes(array('id'=>$_POST['MenuItem_id']));
            foreach($menuItems as $menuItem) {
                $menuItem->position=array_search($menuItem->id, $_POST['MenuItem_id']);
                $menuItem->save();
            }
		}
        else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function actionPosition($id) {
        $model=$this->loadModel($id);
        $this->layout=false;
		$this->render('_position',array(
			'model'=>$model,
            'menuItems'=>$model->children,
		));
    }

    public function actionRemote() {
        if(empty($_POST['MenuItem_id']) || empty($_POST['MenuItem'])) {
            Yii::app()->user->setFlash('error', "Не удалось выполнить указанное действие");
        } else if(isset($_POST['create'])) {
            $model=new MenuItem;
            $model->parent_id=$_POST['MenuItem_id'];
            $model->attributes=$_POST['MenuItem'];
            $model->save(false);
            Yii::app()->user->setFlash('success', "Пункт меню добавлен");
        } else if(isset($_POST['update'])) {
            $model=$this->loadModel($_POST['MenuItem_id']);
            Yii::app()->user->setFlash('success', "Пункт меню &quot;{$model->name}&quot; обновлен");
            $model->attributes=$_POST['MenuItem'];
            $model->save(false);
        } else {
            Yii::app()->user->setFlash('error', "Не удалось выполнить указанное действие");
        }

        $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
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
            Yii::app()->user->setFlash('success', "Пункт меню &quot;{$model->name}&quot; удален");
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
		$this->render('index',array(
            'menuItems'=>MenuItem::model()->findAll('parent_id IS NULL'),
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
		$model=MenuItem::model()->findByPk((int)$id);
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
		if(isset($_POST['ajax']) && $_POST['ajax']==='menu-item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
