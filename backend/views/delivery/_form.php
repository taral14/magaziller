<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'delivery-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

<?php $this->beginClip('basic'); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'free_from'); ?>
		<?php echo $form->textField($model,'free_from'); ?>
		<?php echo $form->error($model,'free_from'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php $this->widget('ElRTE', array(
            'model'=>$model,
            'attribute'=>'description',
        )); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('DeliveryStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>
<?php $this->endClip(); ?>

<?php $this->beginClip('payments'); ?>
    <table>
    <?php foreach(Payment::model()->findAll() as $i=>$payment): ?>
        <tr>
            <td width="20"><?php echo CHtml::checkBox("Delivery[paymentIds][]", in_array($payment->id, $model->paymentIds), array('value'=>$payment->id, 'id'=>"Delivery_paymentIds_{$i}")); ?></td>
            <td><?php echo CHtml::label($payment->name, "Delivery_paymentIds_{$i}"); ?></td>
        </tr>
    <?php endforeach; ?>
    </table>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>
<?php $this->endClip(); ?>

    <?php
    $this->widget('CTabView', array(
        'tabs'=>array(
            'tab1'=>array(
                'title'=>'Основные',
                'content'=>$this->clips['basic']
            ),
            'tab2'=>array(
                'title'=>'Поддерживает формы оплаты',
                'content'=>$this->clips['payments']
            ),
        )
    ));
    ?>

<?php $this->endWidget(); ?>

</div><!-- form -->