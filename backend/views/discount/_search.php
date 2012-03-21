<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

    <?php echo $form->hiddenField($model,'status'); ?>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name'); ?>
	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'handler'); ?>
   		<?php echo $form->dropDownList($model,'handler', $model->getHandlerList(), array('empty'=>'')); ?>
   	</div>

    <div class="row">
   		<?php echo $form->label($model,'start_date'); ?>
   		<?php echo $form->textField($model,'start_date'); ?>
   	</div>

    <div class="row">
   		<?php echo $form->label($model,'finish_date'); ?>
   		<?php echo $form->textField($model,'finish_date'); ?>
   	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Поиск', array('class'=>'search_button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->