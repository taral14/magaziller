<?php
$this->breadcrumbs=array(
	'Фильтры'=>array('index'),
	$model->name
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
);
?>

<h1>Фильтр "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>