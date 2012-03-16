<?php
$this->breadcrumbs=array(
	'Характеристики'
);

$this->menu=array(
	array('label'=>'List Property', 'url'=>array('index')),
	array('label'=>'Create Property', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('property-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Характеристики</h1>

<?php echo CHtml::link('Расширенный поиск','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'id'=>'property-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'group',
		'name',
        array(
            'name' => 'type',
            'value' => 'Lookup::item(\'PropertyType\', $data->type)',
            'filter'=> Lookup::items('PropertyType')
        ),
        array(
            'name' => 'status',
            'value' => 'Lookup::item(\'PropertyStatus\', $data->status)',
            'filter'=> Lookup::items('PropertyStatus')
        ),
		array(
			'class'=>'CButtonColumn',
            'template'=>'{update} {delete}',
		),
	),
)); ?>
