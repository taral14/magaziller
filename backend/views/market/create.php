<?php
$this->breadcrumbs=array(
	'Яндекс.Маркет'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
);
?>

<h1>Добавление экспорта товаров</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>