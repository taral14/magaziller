<?php
$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
	'Добавление',
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
);
?>

<h1>Добавление пользователя</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>