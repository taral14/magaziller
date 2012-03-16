<?php
$this->breadcrumbs=array(
	'Мониторинг конкурентов',
);

$this->menu=array(
	array('label'=>'Добавить конкурента', 'url'=>array('create')),
);

$requestUri=CJavaScript::encode(Yii::app()->request->requestUri);
Yii::app()->clientScript->registerCoreScript('yii');
Yii::app()->clientScript->registerScript('delete-item', "
$('.delete-item').live('click', function(){
    if(confirm('Вы уверены, что хотите удалить конкурента?')) {
        $.yii.submitForm(this,this.href,{returnUrl:$requestUri});
        return false;
    } else {
        return false;
    }
})
");
?>

<h1>Мониторинг конкурентов</h1>

<?php $this->widget('zii.widgets.CListView', array(
	'dataProvider'=>$model->search(),
	'itemView'=>'_view',
    'template'=>"{items}\n{pager}",
)); ?>
