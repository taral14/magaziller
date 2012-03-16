<?php
$this->breadcrumbs=array(
	'Яндекс.Маркет'=>array('index'),
	$model->filename,
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
	array('label'=>'Добавить экспорт', 'url'=>array('create')),
	array('label'=>'Удалить экспорт', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить экспорт товаров?')),
);
?>

<h1>Экспорт товаров "<a href="<?php echo $model->url; ?>" target="_blank"><?php echo $model->filename; ?></a>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>