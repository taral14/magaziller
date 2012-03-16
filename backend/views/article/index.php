<?php
$this->breadcrumbs=array(
	'Статьи',
);

$this->menu=array(
	array('label'=>'Добавить статью', 'url'=>array('create')),
);
Yii::app()->clientScript->registerCoreScript('yii')->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiListView.update('article-list', {
		data: $(this).serialize()
	});
	return false;
});
");
$requestUri=CJavaScript::encode(Yii::app()->request->requestUri);
Yii::app()->clientScript->registerCoreScript('yii');
Yii::app()->clientScript->registerScript('delete-item', "
$('.delete-item').live('click', function(){
    if(confirm('Вы уверены, что хотите удалить статью?')) {
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
        array('label'=>'Все статьи', 'url'=>array('article/index'), 'active'=>empty($_GET)),
        array('label'=>'Опубликованные', 'url'=>array('article/index', 'Article'=>array('status'=>Article::STATUS_PUBLISHED))),
        array('label'=>'Черновики', 'url'=>array('article/index', 'Article'=>array('status'=>Article::STATUS_DRAFT))),
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
    'id'=>'article-list',
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
    'sortableAttributes'=>array('title', 'create_time', 'status')
)); ?>
