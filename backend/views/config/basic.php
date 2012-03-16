<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'config-form',
	'enableAjaxValidation'=>true,
)); ?>

    <h2>Основные</h2>

	<div class="row">
		<?php echo $form->labelEx($model,'shop_name'); ?>
		<?php echo $form->textField($model,'shop_name',array('size'=>60,'maxlength'=>64)); ?>
		<?php echo $form->error($model,'shop_name'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'company'); ?>
        <?php echo $form->textField($model,'company',array('size'=>60,'maxlength'=>64)); ?>
        <?php echo $form->error($model,'company'); ?>
    </div>

	<div class="row">
		<?php echo $form->labelEx($model,'admin_email'); ?>
		<?php echo $form->textField($model,'admin_email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'admin_email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'contact_email'); ?>
		<?php echo $form->textField($model,'contact_email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'contact_email'); ?>
	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'contact_phone'); ?>
   		<?php echo $form->textField($model,'contact_phone',array('size'=>60,'maxlength'=>255)); ?>
   		<?php echo $form->error($model,'contact_phone'); ?>
   	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'currency_default'); ?>
        <?php echo $form->dropDownList($model,'currency_default', $model->getCurrencyList()); ?>
   		<?php echo $form->error($model,'currency_default'); ?>
   	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'currency_basic'); ?>
        <?php echo $form->dropDownList($model,'currency_basic', $model->getCurrencyList()); ?>
   		<?php echo $form->error($model,'currency_basic'); ?>
   	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'counters'); ?>
   		<?php //echo $form->textArea($model,'counters',array('cols'=>60,'rows'=>5)); ?>
        <?php $this->widget('CodeMirror', array(
            'model'=>$model,
            'attribute'=>'counters',
        )); ?>
   		<?php echo $form->error($model,'counters'); ?>
   	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить', array('class'=>'save_button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->