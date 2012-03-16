<?php
$this->breadcrumbs=array(
	'Пункты меню'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
);
?>

<h1>Добавление пункта меню</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>