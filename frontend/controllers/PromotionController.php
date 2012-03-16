<?php
class PromotionController extends Controller {

    public $layout='//layouts/column2';

    public function actionIndex() {

    }

    public function actionView($id) {
        $promotion=$this->loadModel($id);

        $this->breadcrumbs=array(
            $promotion->title
        );
        Yii::app()->seo->setParam('title', $promotion->title);

        $this->render('view', array(
            'promotion'=>$promotion,
        ));
    }

    public function loadModel($id)
    {
        $model=Promotion::model()->findByPk((int)$id);
        if($model===null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
}