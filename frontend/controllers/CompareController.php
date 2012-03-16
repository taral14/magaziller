<?php
class CompareController extends Controller {

    public $layout='//layouts/column2';

    public function actionIndex() {
        $this->breadcrumbs=array(
            'Сравнение товаров'
        );
        $this->render('index');
    }

    public function actionPut($id) {
        $product=Product::model()->findByPk($id);
        if($product===null)
            throw new CHttpException(404,'The requested page does not exist.');
        Yii::app()->compare->put($product);
        if(Yii::app()->request->getIsAjaxRequest())
            $this->renderPartial('_view');
        else
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

    public function actionRemove($id) {
        Yii::app()->compare->remove($id);

        if(Yii::app()->request->getIsAjaxRequest())
            $this->renderPartial('_view');
        else
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    }

}