<?php
$this->breadcrumbs=array(
	'Товары'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог товаров', 'url'=>array('index')),
	array('label'=>'Управление товарами', 'url'=>array('admin')),
);
?>

<h1>Добавление товара</h1>

<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
)); ?>