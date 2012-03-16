<?php
$this->breadcrumbs=array(
	'Новости',
);

$this->menu=array(
	array('label'=>'Добавить новость', 'url'=>array('create')),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiListView.update('news-list', {
		data: $(this).serialize()
	});
	return false;
});
");
$requestUri=CJavaScript::encode(Yii::app()->request->requestUri);
Yii::app()->clientScript->registerCoreScript('yii');
Yii::app()->clientScript->registerScript('delete-item', "
$('.delete-item').live('click', function(){
    if(confirm('Вы уверены, что хотите удалить новость?')) {
        $.yii.submitForm(this,this.href,{returnUrl:$requestUri});
        return false;
    } else {
        return false;
    }
})
");
?>

<h3 class="order-status-menu">
<?php
$this->widget('zii.widgets.CMenu', array(
    'items'=>array(
        array('label'=>'Все новости', 'url'=>array('news/index'), 'active'=>empty($_GET)),
        array('label'=>'Опубликованные', 'url'=>array('news/index', 'News'=>array('status'=>News::STATUS_PUBLISHED))),
        array('label'=>'Черновики', 'url'=>array('news/index', 'News'=>array('status'=>News::STATUS_DRAFT))),
        array('label'=>'Архив', 'url'=>array('news/index', 'News'=>array('status'=>News::STATUS_ARCHIVED))),
    ),
));
?>
</h3>
<b class="clearb"></b>
<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.CListView', array(
    'id'=>'news-list',
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
    'sortableAttributes'=>array('title', 'publish_date', 'create_time', 'status')
)); ?>
