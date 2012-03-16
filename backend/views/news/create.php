<?php
$this->breadcrumbs=array(
	'Новости'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог новостей', 'url'=>array('index')),
);
?>

<h1>Добавление новости</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>