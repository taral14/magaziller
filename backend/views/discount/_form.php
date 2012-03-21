<?php
    Yii::app()->clientScript->registerScript('handler', "
        $('#Discount_handler').change(function(){
            $('.handler-params').hide().find('input,select').attr('disabled','disabled');
            $('#handler-'+$(this).val()).show().find('input,select').removeAttr('disabled');
        }).change();
    ");
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'discount-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'rate'); ?>
   		<?php echo $form->textField($model,'rate',array('size'=>6,'maxlength'=>11)); ?> <?php echo $form->dropDownList($model,'rate_type',Lookup::items('DiscountRateType')); ?>
   		<?php echo $form->error($model,'rate'); ?>
   	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'handler'); ?>
   		<?php echo $form->dropDownList($model,'handler', $model->getHandlerList(), array('empty'=>'')); ?>
   		<?php echo $form->error($model,'handler'); ?>
   	</div>

    <?php foreach($model->getHandlerList() as $key=>$value): ?>

    <fieldset class="handler-params" id="handler-<?php echo $key; ?>" style="display: none;">
        <legend><?php echo $value; ?> - настройки</legend>

        <?php $this->renderPartial('handler/'.$key, array('model'=>$model)); ?>

    </fieldset>

    <?php endforeach; ?>

    <div class="row">
        Использовать от <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,
            'attribute'=>'start_date',
            'language'=>'ru',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
            ),
            'htmlOptions'=>array(
                'size'=>10,
                'maxlength'=>10
            ),
        )); ?>
        до <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
           'model'=>$model,
           'attribute'=>'finish_date',
           'language'=>'ru',
           'options' => array(
               'dateFormat' => 'yy-mm-dd',
           ),
           'htmlOptions'=>array(
               'size'=>10,
               'maxlength'=>10
           ),
        )); ?>
   		<?php echo $form->error($model,'start_date'); ?>
        <?php echo $form->error($model,'finish_date'); ?>
   	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('DiscountStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->