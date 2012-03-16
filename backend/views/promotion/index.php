<?php
$this->breadcrumbs=array(
	'Акции',
);

$this->menu=array(
	array('label'=>'Добавить акцию', 'url'=>array('create')),
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
    if(confirm('Вы уверены, что хотите удалить акцию?')) {
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
        array('label'=>'Все акции', 'url'=>array('promotion/index'), 'active'=>empty($_GET)),
        array('label'=>'Активные', 'url'=>array('promotion/index', 'News'=>array('status'=>Promotion::STATUS_ENABLED))),
        array('label'=>'Отключенные', 'url'=>array('promotion/index', 'News'=>array('status'=>Promotion::STATUS_DISABLED))),
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
    'sortableAttributes'=>array('title', 'create_time', 'status')
)); ?>
