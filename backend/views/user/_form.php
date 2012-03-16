<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'user-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

<?php $this->beginClip('basic'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'username'); ?>
		<?php echo $form->textField($model,'username',array('size'=>60,'maxlength'=>255, 'disabled'=>!$model->isNewRecord)); ?>
		<?php echo $form->error($model,'username'); ?>
	</div>

<?php if(!$model->isNewRecord): ?>

<?php
    Yii::app()->clientScript->registerScript('changePassword', "
        $('#changePassword').change(function(){
            if($(this).is(':checked'))
                $('div.change-password').show();
            else
                $('div.change-password').hide();
        }).change();
    ");
?>

    <div class="row">
        <?php echo CHtml::checkBox('changePassword', $model->scenario=='changePassword'); ?>
        <label for="changePassword">Изменить пароль</label>
    </div>

<?php endif; ?>

	<div class="row change-password">
		<?php echo $form->labelEx($model,'password'); ?>
        <?php echo $form->passwordField($model,'password', array('value'=>'', 'size'=>45,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'password'); ?>
	</div>

	<div class="row change-password">
		<?php echo $form->labelEx($model,'rPassword'); ?>
        <?php echo $form->passwordField($model,'rPassword', array('value'=>'', 'size'=>45,'maxlength'=>128)); ?>
		<?php echo $form->error($model,'rPassword'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'role'); ?>
		<?php echo $form->dropDownList($model,'role', Lookup::items('UserRole')); ?>
		<?php echo $form->error($model,'role'); ?>
	</div>

<?php
    Yii::app()->clientScript->registerScript('changeRole', "
        $('#User_role').change(function(){
            if($(this).val()=='".User::ROLE_CLIENT."')
                $('div.user-role').show();
            else
                $('div.user-role').hide();
        }).change();
    ");
?>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row user-role">
		<?php echo $form->labelEx($model,'group_id'); ?>
		<?php echo $form->dropDownList($model,'group_id', CHtml::listData(Group::model()->findAll(), 'id', 'name'), array('empty'=>'')); ?>
		<?php echo $form->error($model,'group_id'); ?>
	</div>

	<div class="row user-role">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textArea($model,'address',array('rows'=>2, 'cols'=>50)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row user-role">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>2, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', Lookup::items('UserStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

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
        )
    ));
?>

<?php $this->endWidget(); ?>

</div><!-- form -->