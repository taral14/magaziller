<?php
$this->breadcrumbs=array(
	'Фильтры'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
);
?>

<h1>Добавление фильтра</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>