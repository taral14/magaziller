<?php
class SearchController extends Controller {

    public $layout='//layouts/column2';

    public function actionResult($query=null) {
        $product=new Product('search');
        $product->name=$query;

        $dataProvider=$product->search();

        $dataProvider->setSort(array(
            'defaultOrder'=>Yii::app()->params['product_search_order'],
            'sortVar'=>'sort',
        ));
        $dataProvider->setPagination(array(
            'pageSize'=>Yii::app()->params['product_search_limit'],
        ));

        $this->breadcrumbs=array(
            "Поиск \"{$query}\""
        );
        Yii::app()->seo->setParam('query', $query);

        $this->render('result',array(
            'dataProvider'=>$dataProvider,
            'query'=>$query,
        ));
    }

}