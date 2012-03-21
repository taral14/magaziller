<?php
$this->breadcrumbs=array(
	'Скидки'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Каталог скидок', 'url'=>array('index')),
	array('label'=>'Добавить скидку', 'url'=>array('create')),
	array('label'=>'Удалить скидку', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить скидку?')),
);
?>

<h1>Скидка "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>