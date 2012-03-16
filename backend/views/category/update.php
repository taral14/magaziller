<?php
/*$cs=Yii::app()->clientScript;
print_r($cs->scriptMap);
$cs->registerScript('sortable-filter', "$().");
print_r($cs->corePackages);*/
$this->breadcrumbs=array(
	'Категории'=>array('index'),
	$model->name
);

$this->menu=array(
	array('label'=>'Каталог категорий', 'url'=>array('index')),
	array('label'=>'Добавить категорию', 'url'=>array('create', 'Category[parent_id]'=>$model->parent_id)),
    array('label'=>'Удалить категорию', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить категорию?')),
    array(
        'label'=>'Просмотр',
        'url'=>Yii::app()->frontendUrlManager->createUrl('category/view', array('id'=>$model->id)),
        'linkOptions'=>array('target'=>'_blank'),
        'visible'=>$model->status==Category::STATUS_ENABLED
    ),
);
?>

<h1>Категория "<?php echo $model->name; ?>"</h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>