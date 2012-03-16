<?php
$this->breadcrumbs=array(
	'Акции'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Каталог акций', 'url'=>array('index')),
	array('label'=>'Добавить акцию', 'url'=>array('create')),
    array('label'=>'Удалить акцию', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить акцию?')),
);
?>

<h1>Акция "<?php echo $model->title; ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>