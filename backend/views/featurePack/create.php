<?php
$this->breadcrumbs=array(
	'Группы характеристик'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
);
?>

<h1>Добавление группы характеристик</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>