<?php
$this->breadcrumbs=array(
	'Новости'=>array('index'),
	$model->title,
);

$this->menu=array(
	array('label'=>'Каталог новостей', 'url'=>array('index')),
	array('label'=>'Добавить новость', 'url'=>array('create')),
    array('label'=>'Удалить новость', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить новость?')),
    array(
        'label'=>'Просмотр',
        'url'=>Yii::app()->frontendUrlManager->createUrl('news/view', array('id'=>$model->id)),
        'linkOptions'=>array('target'=>'_blank'),
        'visible'=>$model->status!=News::STATUS_DRAFT
    ),
);
?>

<h1>Новость "<?php echo $model->title; ?>"</h1>

<?php $this->renderPartial('_form', array('model'=>$model)); ?>