<?php
$this->breadcrumbs=array(
	'Характеристики'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
);
?>

<h1>Добавление характеристики</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>