<?php
$this->breadcrumbs=array(
	'Мониторинг конкурентов'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Каталог конкурентов', 'url'=>array('index')),
	array('label'=>'Добавить конкурента', 'url'=>array('create')),
	array('label'=>'Удалить конкурента', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить конкурента?')),
);
?>

<h1>Конкурент "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>