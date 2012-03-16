<?php
$this->breadcrumbs=array(
	'Акции'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог акций', 'url'=>array('index')),
);
?>

<h1>Добавление акции</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>