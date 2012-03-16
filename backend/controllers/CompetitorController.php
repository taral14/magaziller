<?php
/**
 * User: Taral
 * Date: 23.12.11
 * Time: 14:42
 */

class CompetitorController extends Controller
{
    public $layout = '/layouts/column2';

    public function filters()
    {
        return array(
            'accessControl',
        );
    }

    public function accessRules()
    {
        return array(
            array('allow', 'roles' => array('content')),
            array('deny', 'users' => array('*')),
        );
    }

    public function actionCreate()
    {
        $model = new Competitor;

        $this->performAjaxValidation($model);

		if (isset($_POST['Competitor']))
		{
			$model->attributes = $_POST['Competitor'];
			if ($model->save()) {
                Yii::app()->user->setFlash('success', "Конкурент добавлен");
                $this->redirect(array('update', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', "Конкурент не добавлен");
            }
		}
        else if (isset($_GET['Competitor']))
        {
            $model->attributes = $_GET['Competitor'];
        }

		$this->render('create', array(
            'model' => $model,
        ));
	}

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

		if (isset($_POST['Competitor']))
		{
			$model->attributes = $_POST['Competitor'];
			if ($model->save()) {
                Yii::app()->user->setFlash('success', "Изменения сохранены");
                $this->redirect(array('update', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', "Изменения не сохранены");
            }
		}

		$this->render('update', array(
            'model' => $model,
        ));
	}

    public function actionDelete($id)
    {
        if (Yii::app()->request->isPostRequest) {
            $model = $this->loadModel($id);
            Yii::app()->user->setFlash('success', "Конкурент &quot;{$model->name}&quot; удален");
            $model->delete();

			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex()
    {
        $model = new Competitor('search');
        $model->unsetAttributes();
		if (isset($_GET['Competitor']))
			$model->attributes = $_GET['Competitor'];
		$this->render('index', array(
            'model' => $model,
        ));
	}

    public function loadModel($id)
    {
        $model = Competitor::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

	protected function performAjaxValidation($model)
{
		if (isset($_POST['ajax']) && $_POST['ajax']==='competitor-form')
		{
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
	}
}
