<?php
class PriceListRowController extends Controller {

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

    public function actionBind($id, $product_id=null) {
        $model=$this->loadModel($id);
        if($product_id) {
            PriceListRow::model()->updateAll(array('product_id'=>null), 'product_id=:pid AND price_list_id=:plid',
                array(':pid'=>$product_id, ':plid'=>$model->price_list_id)
            );
        }
        $model->product_id=$product_id;
        $model->save();
        Yii::app()->end();
    }

    public function actionUnbind($price_list_id, $product_id) {
        PriceListRow::model()->updateAll(array('product_id'=>null), 'product_id=:pid AND price_list_id=:plid',
            array(':pid'=>$product_id, ':plid'=>$price_list_id)
        );
        Yii::app()->end();
    }

    public function actionUpdateProductPrice() {
        $rows=PriceListRow::model()->findAllMinPrice();
        foreach($rows as $row) {
            $product=Product::model()->findByPk($row->product_id);
            if($product==null)
                continue;
            $product->price=$row->price;
            $product->save();
        }
		Yii::app()->user->setFlash('success', "Цены обновлены");
        $this->redirect(isset($_GET['returnUrl']) ? $_GET['returnUrl'] : array('admin'));
    }

    public function actionAutoComplete($term) {
        $criteria=new CDbCriteria;
        $criteria->addSearchCondition('t.article', $term);

        if(!empty($_GET['price_list_id']))
            $criteria->compare('t.price_list_id', $_GET['price_list_id']);

        $criteria->addCondition('(t.product_id=0 OR t.product_id IS NULL)');
        $criteria->limit=10;
        $rows=PriceListRow::model()->findAll($criteria);
        $array=array();
        foreach($rows as $row) {
            array_push($array, array(
                'id'=>$row->id,
                'value'=>$row->article,
                'label'=>$row->article,
            ));
        }
        echo function_exists('json_encode')?json_encode($array):CJSON::encode($array);
        Yii::app()->end();
    }

	public function loadModel($id)
	{
		$model=PriceListRow::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}