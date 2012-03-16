<?php
$this->breadcrumbs=array(
	'Бренды'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог брендов', 'url'=>array('index')),
);
?>

<h1>Добавление бренда</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>