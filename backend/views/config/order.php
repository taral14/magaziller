<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'config-form',
	'enableAjaxValidation'=>true,
)); ?>

    <h2>Зказкы</h2>

    <fieldset>
       <legend>Найтройка оповещения на ел.почту</legend>

        <?php echo CHtml::errorSummary($model); ?>

        <div class="row">
            <?php echo $form->checkBox($model,'mailing_new_order_to_admin'); ?>
            <?php echo $form->label($model,'mailing_new_order_to_admin'); ?>
            <?php echo $form->error($model,'mailing_new_order_to_admin'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model,'mailing_new_order_to_user'); ?>
            <?php echo $form->label($model,'mailing_new_order_to_user'); ?>
            <?php echo $form->error($model,'mailing_new_order_to_user'); ?>
        </div>

        <div class="row mail-pattern">
       		<?php echo $form->labelEx($model,'mailing_new_order_subject'); ?>
       		<?php echo $form->textField($model,'mailing_new_order_subject',array('size'=>60,'maxlength'=>255)); ?>
       		<?php echo $form->error($model,'mailing_new_order_subject'); ?>
       	</div>

        <div class="row mail-pattern" style="width: 680px;">
            <?php echo $form->labelEx($model,'mailing_new_order_pattern'); ?>
            <?php $this->widget('CodeMirror', array(
                'model'=>$model,
                'attribute'=>'mailing_new_order_pattern',
            )); ?>
            <?php echo $form->error($model,'mailing_new_order_pattern'); ?>
        </div>

    </fieldset>
    <fieldset>
       <legend>Найтройка оповещения через sms</legend>

        <div class="row">
            <?php echo $form->checkBox($model,'smsing_new_order_to_admin'); ?>
            <?php echo $form->label($model,'smsing_new_order_to_admin'); ?>
            <?php echo $form->error($model,'smsing_new_order_to_admin'); ?>
        </div>

        <div class="row order-phones">
       		<?php echo $form->labelEx($model,'smsing_new_order_phones'); ?>
       		<?php echo $form->textField($model,'smsing_new_order_phones',array('size'=>60,'maxlength'=>255)); ?>
       		<?php echo $form->error($model,'smsing_new_order_phones'); ?>
            <p class="hint">
          	    Например: (050)333-33-33, (068)333-33-33
          	</p>
       	</div>

    </fieldset>

    <fieldset>
       <legend>Оформление заказа</legend>

        <div class="row">
            <?php echo $form->checkBox($model,'payment_required'); ?>
            <?php echo $form->label($model,'payment_required'); ?>
            <?php echo $form->error($model,'payment_required'); ?>
        </div>

        <div class="row">
            <?php echo $form->checkBox($model,'delivery_required'); ?>
            <?php echo $form->label($model,'delivery_required'); ?>
            <?php echo $form->error($model,'delivery_required'); ?>
        </div>

    </fieldset>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить', array('class'=>'save_button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
<?php
    Yii::app()->clientScript->registerScript('use_mailing_to_user', "
        $('#Config_mailing_new_order_to_user').change(function(){
            if($(this).is(':checked'))
                $('div.mail-pattern').show();
            else
                $('div.mail-pattern').hide();
        }).change();
    ");
    Yii::app()->clientScript->registerScript('use_smsing_to_user', "
        $('#Config_smsing_new_order_to_admin').change(function(){
            if($(this).is(':checked'))
                $('div.order-phones').show();
            else
                $('div.order-phones').hide();
        }).change();
    ");
?>