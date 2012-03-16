<?php
$this->breadcrumbs=array(
	'Прайс-листы'=>array('index'),
	$model->name
);

$this->menu=array(
	array('label'=>'Каталог прайс-листов', 'url'=>array('index')),
	array('label'=>'Добавить прайс-лист', 'url'=>array('create')),
	array('label'=>'Удалить прайс-лист', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены что хотите удалить прайс-лист "'.$model->name.'"?')),
);
?>

<h1>Прайс-лист "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>