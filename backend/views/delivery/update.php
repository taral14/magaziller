<?php
$this->breadcrumbs=array(
	'Способы доставки'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>"Вы уверены, что хотите удалить способ доставки?")),
);
?>

<h1>Способ доставки "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>