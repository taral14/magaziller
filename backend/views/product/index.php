<?php
$this->breadcrumbs=array(
	'Товары',
);

$this->menu=array(
	array('label'=>'Добавить товар', 'url'=>array('create')),
	array('label'=>'Управление товарами', 'url'=>array('admin')),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiListView.update('product-list', {
		data: $(this).serialize()
	});
	return false;
});
");
$requestUri=CJavaScript::encode(Yii::app()->request->requestUri);
Yii::app()->clientScript->registerCoreScript('yii');
Yii::app()->clientScript->registerScript('delete-item', "
$('.delete-item').live('click', function(){
    if(confirm('Вы уверены, что хотите удалить товар?')) {
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
        array('label'=>'Все товары', 'url'=>array('product/index'), 'active'=>empty($_GET)),
        array('label'=>'Хиты продаж', 'url'=>array('product/index', 'Product'=>array('hit'=>1))),
        array('label'=>'Витрина', 'url'=>array('product/index', 'Product'=>array('shopwindow'=>1))),
        array('label'=>'Нет на складе', 'url'=>array('product/index', 'Product'=>array('status'=>Product::STATUS_ABSENT))),
        array('label'=>'Отключенные', 'url'=>array('product/index', 'Product'=>array('status'=>Product::STATUS_DISABLED))),
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
    'id'=>'product-list',
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
    'sortableAttributes'=>array('name', 'price', 'hit', 'shopwindow', 'status')
)); ?>
