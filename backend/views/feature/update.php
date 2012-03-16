<?php
$this->breadcrumbs=array(
	'Характеристики'=>array('index'),
	$model->name
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
);
?>

<h1>Характеристика "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>