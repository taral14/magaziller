<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiListView.update('order-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
$requestUri=CJavaScript::encode(Yii::app()->request->requestUri);
Yii::app()->clientScript->registerCoreScript('yii');
Yii::app()->clientScript->registerScript('order-item', "
$('.order-status-delete').live('click', function(){
    if(confirm('Вы уверены, что хотите удалить заказ?')) {
        $.yii.submitForm(this,this.href,{returnUrl:$requestUri});
        return false;
    } else {
        return false;
    }
})
$('.order-status-processing, .order-status-complete').live('click', function(){
    $.yii.submitForm(this,this.href,{returnUrl:$requestUri});
    return false;
})
");

$this->breadcrumbs=array(
    'Заказы'=>array('index'),
    Lookup::item('OrderStatus', $model->status)
);

$this->menu=array(
	//array('label'=>'Добавить заказ', 'url'=>array('create')),
);
?>

<h3 class="order-status-menu">
<?php
$this->widget('zii.widgets.CMenu', array(
    'items'=>array(
        array('label'=>'Новые', 'url'=>array('order/index', 'Order'=>array('status'=>Order::STATUS_NEW))),
        array('label'=>'В обработке', 'url'=>array('order/index', 'Order'=>array('status'=>Order::STATUS_PROCESSING))),
        array('label'=>'Выполненные', 'url'=>array('order/index', 'Order'=>array('status'=>Order::STATUS_COMPLETE))),
        array('label'=>'Нет в наличии', 'url'=>array('order/index', 'Order'=>array('status'=>Order::STATUS_ABSENT))),
        array('label'=>'Удаленные', 'url'=>array('order/index', 'Order'=>array('status'=>Order::STATUS_DELETE)), 'visible'=>Yii::app()->user->role==User::ROLE_ADMIN),
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
</div>
<?php $this->widget('zii.widgets.CListView', array(
    'id'=>'order-grid',
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
    'sortableAttributes'=>array('name', 'email', 'create_time', 'update_time')
)); ?>
