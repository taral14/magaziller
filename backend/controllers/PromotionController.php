<?php
/**
 * User: Taral
 * Date: 21.12.11
 * Time: 14:47
 */

class PromotionController extends Controller
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

    public function actionAutoComplete($term) {
        $criteria=new CDbCriteria;
        if(strpos($term, ',')===false) {
            $criteria->addSearchCondition('t.title', $term);
        } else {
            $terms=array_map("trim", explode(',',$term));
            $criteria->addSearchCondition('t.title', array_pop($terms));
            if(count($terms))
                $criteria->addNotInCondition('t.title', $terms);
        }

        if(array_key_exists('limit',$_GET))
            $criteria->limit=max(1,$_GET['limit']);
        else
            $criteria->limit=5;

        if(array_key_exists('without',$_GET))
            $criteria->compare('t.id', '<>'.$_GET['without']);

        $promotions=Promotion::model()->findAll($criteria);
        $json=array();
        foreach($promotions as $promotion) {
            array_push($json, array(
                'id'=>$promotion->id,
                'value'=>$promotion->title,
                'label'=>$promotion->title,
            ));
        }
        echo function_exists('json_encode')?json_encode($json):CJSON::encode($json);
        Yii::app()->end();
    }

    public function actionCreate()
    {
        $model = new Promotion;

        $this->performAjaxValidation($model);

		if (isset($_POST['Promotion']))
		{
            $model->attributes = $_POST['Promotion'];

            if ($model->save()) {
                Yii::app()->user->setFlash('success', "Акция добавлена");
                $this->redirect(array('update', 'id' => $model->id));
            } else {
                Yii::app()->user->setFlash('error', "Акция не добавлена");
            }
		}
        else if (isset($_GET['Promotion']))
        {
            $model->attributes = $_GET['Promotion'];
        }

		$this->render('create', array(
            'model' => $model,
        ));
	}

    public function actionUpdate($id)
    {
        $model = $this->loadModel($id);

        $this->performAjaxValidation($model);

		if (isset($_POST['Promotion']))
		{
			$model->attributes = $_POST['Promotion'];
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
            Yii::app()->user->setFlash('success', "Акция &quot;{$model->title}&quot; удалена");
            $model->delete();

			if (!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
		}
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }

    public function actionIndex()
    {
        $model = new Promotion('search');
        $model->unsetAttributes();
		if (isset($_GET['Promotion']))
			$model->attributes = $_GET['Promotion'];
		$this->render('index', array(
            'model' => $model,
        ));
	}

    public function loadModel($id)
    {
        $model = Promotion::model()->findByPk((int)$id);
        if ($model === null)
            throw new CHttpException(404, 'The requested page does not exist.');
        return $model;
    }

    protected function performAjaxValidation($model)
    {
		if (isset($_POST['ajax']) && $_POST['ajax']==='promotion-form')
		{
            echo CActiveForm::validate($model);
            Yii::app()->end();
        }
	}
}
