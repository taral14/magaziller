<?php
$this->breadcrumbs=array(
	'Элементы страниц'=>array('index'),
	$model->name=>array('view', 'id'=>$model->id),
    'Редактирование',
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
    array('label'=>'Содержание', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Удалить', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить элемент страницы?')),
);
?>

<h1>Элемент страницы "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>