<?php
$this->breadcrumbs=array(
	'Пользователи'=>array('index'),
    Lookup::item('UserRole', $model->role)=>array('index', 'role'=>$model->role),
	$model->username
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
    array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array(
        'submit'=>array('delete', 'id'=>$model->id),
        'confirm'=>'Вы уверены, что хотите удалить пользователя?'
    )),
);
?>

<h1>Пользователь "<?php echo $model->username; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>