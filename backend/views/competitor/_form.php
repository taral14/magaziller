<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'competitor-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

<!-- Основные -->
<?php $this->beginClip('basic'); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'url'); ?>
   		<?php echo $form->textField($model,'url',array('size'=>60,'maxlength'=>255)); ?>
   		<?php echo $form->error($model,'url'); ?>
   	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'jquery_path'); ?>
   		<?php echo $form->textField($model,'jquery_path',array('size'=>60,'maxlength'=>255)); ?>
   		<?php echo $form->error($model,'jquery_path'); ?>
   	</div>

    <div class="row buttons">
   		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
   	</div>

<?php $this->endClip(); ?>
<!-- //Основные -->
    <?php
    $this->widget('CTabView', array(
        'tabs'=>array(
            'tab1'=>array(
                'title'=>'Основные',
                'content'=>$this->clips['basic'],
            ),
        )
    ));
    ?>

<?php $this->endWidget(); ?>

</div><!-- form -->