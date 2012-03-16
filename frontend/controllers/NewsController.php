<?php
class NewsController extends Controller {

     public $layout='//layouts/column2';

    public function actionView($id) {
        $news=$this->loadModel($id);

        $this->breadcrumbs=array(
            'Новости'=>array('news/index'),
            $news->title
        );

        Yii::app()->seo->setParam('title', $news->title);

        $this->render('view',array(
            'news'=>$news,
		));
    }

    public function actionArchive() {
        $criteria=new CDbCriteria;
        $criteria->compare('status', News::STATUS_PUBLISHED);

        $dataProvider=new CActiveDataProvider('News', array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>Yii::app()->params['news_catalog_limit'],
            ),
            'sort'=>array(
                'defaultOrder'=>'publish_date DESC',
                'sortVar'=>'sort',
            )
        ));

        $this->breadcrumbs=array(
            'Новости'
        );

        $this->render('archive',array(
            'dataProvider'=>$dataProvider,
		));
    }

	public function loadModel($id)
	{
        $criteria=new CDbCriteria;
        $criteria->addInCondition('status', array(News::STATUS_ARCHIVED, News::STATUS_PUBLISHED));
        $criteria->compare('id', (int)$id);
		$model=News::model()->find($criteria);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}
}