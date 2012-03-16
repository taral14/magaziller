<?php
class ProductController extends Controller {

    public $layout='//layouts/column2';

    public function actionIndex() {
		$product=new Product('search');
		$product->unsetAttributes();
		if(isset($_GET['Product']))
			$product->attributes=$_GET['Product'];

        $dataProvider=$product->search();
        $dataProvider->setPagination(array(
            'pageSize'=>Yii::app()->config['product_catalog_limit'],
        ));
        $dataProvider->setSort(array(
            'defaultOrder'=>Yii::app()->config['product_catalog_order'],
            'sortVar'=>'sort',
        ));

        $this->breadcrumbs=array(
            'Каталог'
        );
        $this->render('index',array(
            'dataProvider'=>$dataProvider,
		));
    }

    public function actionView($id) {
		$product=$this->loadModel($id);

        $breadcrumbs=array($product->name);
        if($product->brand_id)
            $breadcrumbs[$product->brand->name]=$product->brand->url;

        $c=$product->category;
        do {
            $breadcrumbs[$c->name]=$c->url;
        } while($c=$c->parent);

        $this->breadcrumbs=array_reverse($breadcrumbs);

        Yii::app()->seo->setParams(array(
            'name'=>$product->name,
            'brand'=>$product->brand->name,
            'category'=>$product->category->name,
        ));

        $this->render('view',array(
            'product'=>$product,
		));
    }

	public function loadModel($id)
	{
		$model=Product::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}