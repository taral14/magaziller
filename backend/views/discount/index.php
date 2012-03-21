<?php
$this->breadcrumbs=array(
	'Скидки',
);

$this->menu=array(
	array('label'=>'Добавить скидку', 'url'=>array('create')),
);
Yii::app()->clientScript->registerCoreScript('yii')->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiListView.update('discount-list', {
		data: $(this).serialize()
	});
	return false;
});
");
$requestUri=CJavaScript::encode(Yii::app()->request->requestUri);
Yii::app()->clientScript->registerCoreScript('yii');
Yii::app()->clientScript->registerScript('delete-item', "
$('.delete-item').live('click', function(){
    if(confirm('Вы уверены, что хотите удалить скидку?')) {
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
        array('label'=>'Все скидки', 'url'=>array('discount/index'), 'active'=>empty($_GET)),
        array('label'=>'Активные', 'url'=>array('discount/index', 'Discount'=>array('status'=>Discount::STATUS_ENABLED))),
        array('label'=>'Отключенные', 'url'=>array('discount/index', 'Discount'=>array('status'=>Discount::STATUS_DISABLED))),
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
    'id'=>'discount-list',
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
)); ?>
