<?php
$this->breadcrumbs=array(
	'Прайс-листы'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог прайс-листов', 'url'=>array('index')),
);
?>

<h1>Добавление прайс-листа</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>