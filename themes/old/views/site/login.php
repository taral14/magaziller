<div class="best-head">Авторизация</div>
<div class="best-content">

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'login-form',
	'enableAjaxValidation'=>true,
)); ?>

    <p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<div class="row">
		<?php echo $form->labelEx($login,'username'); ?>
		<?php echo $form->textField($login,'username'); ?>
		<?php echo $form->error($login,'username'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($login,'password'); ?>
		<?php echo $form->passwordField($login,'password'); ?>
		<?php echo $form->error($login,'password'); ?>
	</div>

	<div class="row rememberMe">
		<?php echo $form->checkBox($login,'rememberMe'); ?>
		<?php echo $form->label($login,'rememberMe'); ?>
		<?php echo $form->error($login,'rememberMe'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Войти'); ?>
	</div>

<?php $this->endWidget(); ?>
</div><!-- form -->
    
</div>