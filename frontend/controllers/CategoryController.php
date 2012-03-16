<?php
class CategoryController extends Controller {

    public $layout='//layouts/column1';

    public function actionIndex() {

    }

    public function actionView($id) {
		$category=$this->loadModel($id);

		$product=new Product('search');
		$product->unsetAttributes();  // clear any default values
		if(isset($_GET['Product']))
			$product->attributes=$_GET['Product'];
        $product->category_id=$category->id;


        $dataProvider=$product->search();
        $dataProvider->setPagination(array(
            'pageSize'=>Yii::app()->config['product_catalog_limit'],
        ));
        $dataProvider->setSort(array(
            'defaultOrder'=>Yii::app()->config['product_catalog_order'],
            'sortVar'=>'sort',
        ));

        if(!empty($_GET['Product']['brand_id'])) {
            $brand=Brand::model()->findByPk((int)$_GET['Product']['brand_id']);
            $breadcrumbs=array($brand->name, $category->name=>$category->url);
        } else
            $breadcrumbs=array($category->name);
        
        $c=$category;
        while($c=$c->parent)
            $breadcrumbs[$c->name]=$c->url;

        $this->breadcrumbs=array_reverse($breadcrumbs);

        Yii::app()->seo->setParam('name', $category->name);

        $this->render('view',array(
			'category'=>$category,
            'dataProvider'=>$dataProvider,
		));
    }

	public function loadModel($id)
	{
		$model=Category::model()->findByPk((int)$id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}