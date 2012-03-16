<?php
$this->breadcrumbs=array(
	'Прайс-листы',
);

$this->menu=array(
	array('label'=>'Добавить прайс-лист', 'url'=>array('create')),
	array('label'=>'Пересчитать цены', 'url'=>array('recount')),
);
$requestUri=CJavaScript::encode(Yii::app()->request->requestUri);
Yii::app()->clientScript->registerCoreScript('yii');
Yii::app()->clientScript->registerScript('delete-item', "
$('.delete-item').live('click', function(){
    if(confirm('Вы уверены, что хотите удалить поставщика?')) {
        $.yii.submitForm(this,this.href,{returnUrl:$requestUri});
        return false;
    } else {
        return false;
    }
})
");
?>

<h1>Прайс-листы</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$dataProvider,
	'itemView'=>'_view',
    'sortableAttributes'=>array('name', 'upload_time', 'status'),
)); ?>
