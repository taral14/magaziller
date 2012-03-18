 <?php
$saveUrl=$this->createUrl($this->route, $_GET);
$cs=Yii::app()->clientScript;
$cs->registerScript('filter-dialog', "
    $('#Filter_attribute').change(function(){
        $.get('typeList', {attribute:this.value}, function(html){
            $('#Filter_type').html(html);
        })
    });
    $('#load-alowed-values').click(function(){
        if($('#Filter_alowed_values').val()!='' && !confirm('Введенные значения заменятся. Продолжить?')) {
            return false;
        }
        $.post('../filter/loadAlowedValues', $('#filter-form').serialize(), function(json){
            var values=$.parseJSON(json);
            if($.isArray(values)) {
                var text=values.join(\"\\n\");
            } else {
                var text='';
                $.each(values, function(index,value){
                    text=text+index+'='+value+\"\\n\";
                })
            }

            $('#Filter_alowed_values').val(text);
        });
        return false;
    })
");
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'filter-form',
	'enableAjaxValidation'=>true,
)); ?>

<?php $this->beginClip('basic'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>50,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'attribute'); ?>
   		<?php echo $form->dropDownList($model,'attribute', $model->getAttributeList(), array('empty'=>'')); ?>
   		<?php echo $form->error($model,'attribute'); ?>
   	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
		<?php echo $form->dropDownList($model,'type', $model->getTypeList(), array('empty'=>'')); ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row">
        <?php echo $form->labelEx($model,'alowed_values', array('style'=>'float:left;')); ?>&nbsp;(<a id="load-alowed-values" href="#">загрузить значения с товаров</a>)
		<?php echo $form->textArea($model,'alowed_values',array('rows'=>3, 'cols'=>50)); ?>
		<?php echo $form->error($model,'alowed_values'); ?>
	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'css_class'); ?>
   		<?php echo $form->textField($model,'css_class',array('size'=>50,'maxlength'=>255)); ?>
   		<?php echo $form->error($model,'css_class'); ?>
   	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>

<?php $this->endClip(); ?>
<?php $this->beginClip('categories'); ?>

    <ul class="in-categories">
        <?php echo $this->renderPartial('_categories', array(
            'model'=>$model,
            'categories'=>Category::model()->rooted()->findAll()
        )); ?>
    </ul>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>

<?php $this->endClip(); ?>

<?php
$this->widget('CTabView', array(
    'tabs'=>array(
        'tab1'=>array(
            'title'=>'Основные',
            'content'=>$this->clips['basic'],
        ),
        'tab2'=>array(
            'title'=>'Использовать в категориях',
            'content'=>$this->clips['categories'],
        ),
    )
));
?>

</div><!-- form -->
<?php $this->endWidget(); ?>