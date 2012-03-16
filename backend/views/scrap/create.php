<?php
$this->breadcrumbs=array(
	'Элементы страниц'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
);
?>

<h1>Добавление элемента страницы</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>