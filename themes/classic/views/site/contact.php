<div class="best-head">Контакты</div>
<div class="best-content">
<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p><?php echo Yii::app()->config['contact_text']; ?></p>

<?php echo Yii::app()->config['contact_map']; ?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm'); ?>

    <p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($contact); ?>

	<div class="row">
		<?php echo $form->labelEx($contact,'name'); ?>
		<?php echo $form->textField($contact,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($contact,'email'); ?>
		<?php echo $form->textField($contact,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($contact,'subject'); ?>
		<?php echo $form->textField($contact,'subject',array('size'=>60,'maxlength'=>128)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($contact,'body'); ?>
		<?php echo $form->textArea($contact,'body',array('rows'=>6, 'cols'=>50)); ?>
	</div>

	<?php if(CCaptcha::checkRequirements() && Yii::app()->config['contact_use_captcha']): ?>
	<div class="row">
		<?php echo $form->labelEx($contact,'verifyCode'); ?>
		<div>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->textField($contact,'verifyCode'); ?>
		</div>
		<div class="hint">Пожалуйста, введите буквы, изображенные на картинке выше.
		<br/>Регистр букв не учитывается.</div>
	</div>
	<?php endif; ?>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Отправить'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

<?php endif; ?>
</div>