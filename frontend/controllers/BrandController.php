<?php
class BrandController extends Controller {

    public $layout='//layouts/column2';

    public function actionIndex() {

    }

    public function actionView($id) {
        $brand=$this->loadModel($id);

        $this->breadcrumbs=array($brand->name);

        Yii::app()->seo->setParam('name', $brand->name);

        $this->render('view', array(
            'brand'=>$brand,
        ));
    }

    public function loadModel($id)
    {
        $model=Brand::model()->findByPk((int)$id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}