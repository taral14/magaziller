<?php
$this->breadcrumbs=array(
	'Мониторинг конкурентов'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог конкурентов', 'url'=>array('index')),
);
?>

<h1>Добавление конкурента</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>