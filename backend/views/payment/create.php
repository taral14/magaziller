<?php
$this->breadcrumbs=array(
	'Способы оплаты'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
);
?>

<h1>Добавление способа оплаты</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>