<?php
$this->breadcrumbs=array(
	'Группы'=>array('index'),
	$model->name
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
	array('label'=>'Добавить группу', 'url'=>array('create')),
    array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array(
        'submit'=>array('delete', 'id'=>$model->id),
        'confirm'=>'Вы уверены, что хотите удалить группу?'
    )),
);
?>

<h1>Группа "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>