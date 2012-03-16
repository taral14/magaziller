<?php
$this->breadcrumbs=array(
	'Статьи'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог статей', 'url'=>array('index')),
);
?>

<h1>Добавление статьи</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>