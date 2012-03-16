<?php
$this->breadcrumbs=array(
	'Элементы страниц'=>array('scrap/index'),
	$model->scrap->name=>array('scrap/view', 'id'=>$model->scrap_id),
    'Шаблоны'=>array('scrap/update', 'id'=>$model->scrap_id, '#'=>'templates'),
    'Добавление',
);

$this->menu=array(
    array('label'=>'Элемент страницы', 'url'=>array('scrap/view', 'id'=>$model->scrap_id)),
	array('label'=>'Каталог шаблонов', 'url'=>array('scrap/update', 'id'=>$model->scrap_id, '#'=>'templates')),
);
?>

<h1>Добавление шаблона</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>