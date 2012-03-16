<?php
$this->breadcrumbs=array(
	'Галереи изображений',
);

$this->menu=array(
	array('label'=>'Добавить галерею', 'url'=>array('create')),
);
$requestUri=CJavaScript::encode(Yii::app()->request->requestUri);
Yii::app()->clientScript->registerCoreScript('yii');
Yii::app()->clientScript->registerScript('delete-item', "
$('.delete-item').live('click', function(){
    if(confirm('Вы уверены, что хотите удалить галерею изображений?')) {
        $.yii.submitForm(this,this.href,{returnUrl:$requestUri});
        return false;
    } else {
        return false;
    }
})
");
?>

<h1>Галереи изображений</h1>

<?php foreach(Gallery::model()->findAll() as $gallery) : ?>

<div class="view">

	<b><?php echo $gallery->name; ?></b>
    <b class="clearb"></b>
    <?php echo Yii::t('app', '{n} изображение|{n} изображения|{n} изображений|{n} изображение', $gallery->imagesCount); ?>
    <div class="management">
        <?php echo CHtml::link('Редактировать', array('update', 'id'=>$gallery->id)); ?> |
        <?php echo CHtml::link('Удалить', array('delete','id'=>$data->id), array('class'=>'delete-item'));?>
    </div>

</div>

<?php endforeach; ?>