<?php
$this->breadcrumbs=array(
	'Галереи изображений'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог галерей', 'url'=>array('index')),
);
?>

<h1>Добавление галереи</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>