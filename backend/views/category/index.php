<?php
$this->breadcrumbs=array(
	'Категории',
);

$this->menu=array(
	array('label'=>'Добавить категорию', 'url'=>array('create')),
);
?>

<h1>Категории</h1>

<?php $this->widget('CTreeView', array(
	'data'=>Category::model()->rooted()->findAll(),
)); ?>