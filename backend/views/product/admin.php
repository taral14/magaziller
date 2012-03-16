<?php
$this->breadcrumbs=array(
	'Товары'=>array('index'),
	'Управление',
);

$this->menu=array(
	array('label'=>'Каталог товаров', 'url'=>array('index')),
	array('label'=>'Добавить товар', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('product-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Управление товарами</h1>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'product-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
        array(
            'name' => 'category_id',
            'value' => '$data->category->name',
            'filter'=> false
        ),
        array(
            'name' => 'brand_id',
            'value' => '$data->brand->name',
            'filter'=> CHtml::listData(Brand::model()->findAll(), 'id', 'name')
        ),
		'name',
        array(
            'name' => 'price',
            'value' => 'Yii::app()->priceFormatter->format($data->price, true)',
        ),
        array(
            'name'=>'status',
            'value'=>'Lookup::item("ProductStatus",$data->status)',
            'filter'=>Lookup::items('ProductStatus'),
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
		),
	),
)); ?>
