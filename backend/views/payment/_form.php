<?php
    Yii::app()->clientScript->registerScript('handler', "
        $('#Payment_handler').change(function(){
            $('.handler-params').hide().find('input,select').attr('disabled','disabled');
            $('#handler-'+$(this).val()).show().find('input,select').removeAttr('disabled');
        }).change();
    ");
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'payment-form',
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
   		<?php echo $form->labelEx($model,'currency_id'); ?>
        <?php echo $form->dropDownList($model,'currency_id', $model->getCurrencyList()); ?>
   		<?php echo $form->error($model,'currency_id'); ?>
   	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'handler'); ?>
   		<?php echo $form->dropDownList($model,'handler', $model->getHandlerList(), array('empty'=>'Обработка производится вручную')); ?>
   		<?php echo $form->error($model,'handler'); ?>
   	</div>

    <?php foreach($model->getHandlerList() as $key=>$value): ?>

    <fieldset class="handler-params" id="handler-<?php echo $key; ?>" style="display: none;">
        <legend><?php echo $value; ?> - настройки</legend>

        <?php $this->renderPartial('handler/'.$key, array('model'=>$model)); ?>

    </fieldset>

    <?php endforeach; ?>



	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php $this->widget('ElRTE', array(
            'model'=>$model,
            'attribute'=>'description',
            'options' => array(
                'height' => '150',
            ),
        )); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('PaymentStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>
<?php $this->endClip(); ?>

<?php $this->beginClip('deliveries'); ?>
    <table>
    <?php foreach(Delivery::model()->findAll() as $i=>$delivery): ?>
        <tr>
            <td width="20"><?php echo CHtml::checkBox("Payment[deliveryIds][]", in_array($delivery->id, $model->deliveryIds), array('value'=>$delivery->id, 'id'=>"Payment_deliveryIds_{$i}")); ?></td>
            <td><?php echo CHtml::label($delivery->name, "Payment_deliveryIds_{$i}"); ?></td>
            <td width="20"><?php echo Yii::app()->priceFormatter->format($delivery->price); ?></td>
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
                'title'=>'Поддерживает способы доставки',
                'content'=>$this->clips['deliveries']
            ),
        )
    ));
    ?>



<?php $this->endWidget(); ?>

</div><!-- form -->