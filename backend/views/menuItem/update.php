<?php
$this->breadcrumbs=array(
    'Пункты меню'=>array('index'),
    $model->rooted->name=>array('index', '#'=>'tab'.$model->rooted->id),
	$model->name
);

$this->menu=array(
	array('label'=>'К списку', 'url'=>array('index', '#'=>'tab'.$model->rooted->id)),
	array('label'=>'Добавить', 'url'=>array('create', 'MenuItem[parent_id]'=>$model->parent_id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>"Вы уверены что хотите удалить пункт меню \"$model->name\"?")),
);
?>

<h1>Пункт меню "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>