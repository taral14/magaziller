	<div class="row">
		<?php echo $form->labelEx($model,'metaTitle'); ?>
		<?php echo $form->textField($model,'metaTitle',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'metaTitle'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'metaKeywords'); ?>
		<?php echo $form->textField($model,'metaKeywords',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'metaKeywords'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'metaDescription'); ?>
		<?php echo $form->textField($model,'metaDescription',array('size'=>60,'maxlength'=>500)); ?>
		<?php echo $form->error($model,'metaDescription'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? isset($submitText)?$submitText:'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>