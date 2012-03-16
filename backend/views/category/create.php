<?php
$this->breadcrumbs=array(
	'Категории'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог категорий', 'url'=>array('index')),
);
?>

<h1>Добавление категории</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>