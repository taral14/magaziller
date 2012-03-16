<?php
$this->breadcrumbs=array(
	'Элементы страниц'=>array('scrap/index'),
	$model->scrap->name=>array('scrap/view', 'id'=>$model->scrap_id),
    'Шаблоны'=>array('scrap/update', 'id'=>$model->scrap_id, '#'=>'templates'),
    $model->name,
);

$this->menu=array(
    array('label'=>'Элемент страницы', 'url'=>array('scrap/view', 'id'=>$model->scrap_id)),
	array('label'=>'Каталог шаблонов', 'url'=>array('scrap/update', 'id'=>$model->scrap_id, '#'=>'templates')),
	array('label'=>'Добавить шаблон', 'url'=>array('create', 'scrap_id'=>$model->scrap_id)),
	array('label'=>'Удалить шаблон', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить шаблон?')),
);
?>

<h1>Редактирование шаблона "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>