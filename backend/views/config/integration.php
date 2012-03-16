<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'config-form',
	'enableAjaxValidation'=>true,
)); ?>

    <h2>Интеграция</h2>

    <fieldset>
       <legend>Интеграция с Вконтакте</legend>

	<div class="row">
		<?php echo $form->labelEx($model,'vkontakte_api_id'); ?>
		<?php echo $form->textField($model,'vkontakte_api_id',array('size'=>60,'maxlength'=>11)); ?>
		<?php echo $form->error($model,'vkontakte_api_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'vkontakte_poll_id'); ?>
		<?php echo $form->textField($model,'vkontakte_poll_id',array('size'=>60,'maxlength'=>32)); ?>
		<?php echo $form->error($model,'vkontakte_poll_id'); ?>
	</div>
        
    <a href="http://vkontakte.ru/developers.php?oid=-1&p=Poll" target="_blank">Настройка и редактирование голосований</a>

    </fieldset>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить', array('class'=>'save_button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->