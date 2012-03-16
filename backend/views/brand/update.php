<?php
$this->breadcrumbs=array(
	'Бренды'=>array('index'),
	$model->name
);

$this->menu=array(
	array('label'=>'Каталог брендов', 'url'=>array('index')),
	array('label'=>'Добавить бренд', 'url'=>array('create')),
    array('label'=>'Удалить бренд', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить бренд?')),
    array(
        'label'=>'Просмотр',
        'url'=>Yii::app()->frontendUrlManager->createUrl('brand/view', array('id'=>$model->id)),
        'linkOptions'=>array('target'=>'_blank'),
    ),
);
?>

<h1>Бренд "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>