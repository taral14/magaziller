<?php
/**
 * User: Taral
 * Date: 27.10.11
 * Time: 19:14
 */

class FilterController extends Controller
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

    public function actionIndex() {
        $model=new Filter('search');
        $model->unsetAttributes();
        if(isset($_GET['Filter']))
            $model->attributes=$_GET['Filter'];

        $this->render('index',array(
            'model'=>$model,
        ));
    }

	public function actionCreate()
	{
		$model=new Filter;

		$this->performAjaxValidation($model);

		if(isset($_POST['Filter']))
		{
			$model->attributes=$_POST['Filter'];
			if($model->save()) {
                Yii::app()->user->setFlash('success', "Фильтр добавлен");
                $this->redirect(isset($_GET['returnUrl'])?$_GET['returnUrl']:array('update','id'=>$model->id));
            } else {
                Yii::app()->user->setFlash('error', "Фильтр не добавлен");
            }
		}
        else if(isset($_GET['Filter']))
        {
            $model->attributes=$_GET['Filter'];
        }

		$this->render('create',array(
			'model'=>$model,
		));
	}

	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		$this->performAjaxValidation($model);

		if(isset($_POST['Filter']))
		{
			$model->attributes=$_POST['Filter'];
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

    public function actionAttributeList($category_id) {
        $filter=new Filter;
        $filter->category_id=$category_id;

        echo CHtml::tag('option', array('value'=>''),'',true);
        foreach($filter->getAttributeList() as $value=>$name)
            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
    }

    public function actionTypeList($attribute) {
        $filter=new Filter;
        $filter->attribute=$attribute;

        echo CHtml::tag('option', array('value'=>''),'',true);
        foreach($filter->getTypeList() as $value=>$name)
            echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
    }

	public function actionDelete($id)
	{
        $this->loadModel($id)->delete();
        Yii::app()->end();
	}

    public function actionLoadAlowedValues() {
        $filter=new Filter;
        if(isset($_POST['Filter']))
            $filter->attributes=$_POST['Filter'];

        $result=array();
        switch($filter->attribute) {
            case 'brand_id':
                foreach($filter->category->brands as $brand)
                    $result[$brand->id]=$brand->name;
                break;
            case 'status':
                $result=Lookup::items('ProductStatus');
                break;
            default:
                if(preg_match('#^feature([0-9]+)$#', $filter->attribute, $matches)) {
                    $result=FeatureValue::model()->findValues($matches[1]);
                }
        }

        switch($filter->type) {
            case Filter::TYPE_SLIDER:
            case Filter::TYPE_RANGE:
            case Filter::TYPE_RANGE_SLIDER:
                if(count($result))
                    $result=array(min($result),max($result));
        }

        echo function_exists('json_encode') ? json_encode($result) : CJSON::encode($result);
        Yii::app()->end();
    }

    public function actionSaveOrder() {
		if(isset($_POST['Filter_id']))
        {
            $filters=Filter::model()->findAllByAttributes(array('id'=>$_POST['Filter_id']));
            foreach($filters as $filter) {
                $filter->position=array_search($filter->id, $_POST['Filter_id']);
                $filter->save();
            }
		}
        else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

	public function loadModel($id)
	{
		$model=Filter::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='filter-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
