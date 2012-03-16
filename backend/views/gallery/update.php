<?php
$this->breadcrumbs=array(
	'Галереи изображений'=>array('index'),
	$model->name
);

$this->menu=array(
	array('label'=>'Каталог галерей', 'url'=>array('index')),
	array('label'=>'Добавить галерею', 'url'=>array('create')),
    array('label'=>'Удалить галерею', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить галерею?')),
);
?>

<h1>Галерея "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>