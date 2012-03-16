<?php
$this->breadcrumbs=array(
	'Способы доставки'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
);
?>

<h1>Добавление способа доставки</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>