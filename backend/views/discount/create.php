<?php
$this->breadcrumbs=array(
	'Скидки'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог скидок', 'url'=>array('index')),
);
?>

<h1>Добавление скидки</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>