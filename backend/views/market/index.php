<?php
$this->breadcrumbs=array(
	'Яндекс.Маркет',
);

$this->menu=array(
	array('label'=>'Добавить экспорт', 'url'=>array('create')),
);
?>

<h1>Экспорт товаров в Яндекс.Маркет</h1>

<?php $this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=>$model->search(),
	'columns'=>array(
        array(
            'name' => 'name',
            'value' => '$data->filename',
        ),
        array(
            'name' => 'url',
            'value' => 'Yii::app()->request->hostInfo.$data->url',
        ),
        array(
            'name'=>'status',
            'value'=>'Lookup::item("MarketStatus",$data->status)',
        ),
		array(
			'class'=>'CButtonColumn',
            'viewButtonUrl'=>'$data->url',
		),
	),
)); ?>