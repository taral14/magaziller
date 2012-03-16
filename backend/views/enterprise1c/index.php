<h2>Интеграция с 1С</h2>
<p>Интеграция с «1С: Управлением торговлей» реализована через формат <a href="http://www.1c.ru/rus/products/1c/integration/cml.htm">CommerceML</a>.</p>

<div class="form">

<fieldset>
    <legend>Автоматический обмен данными</legend>

    <?php $form=$this->beginWidget('CActiveForm', array(
    	'id'=>'config-form',
    	'enableAjaxValidation'=>true,
    )); ?>

    <label for="url_export">Адрес скрипта синхронизации</label>
    <input id="url_export" value="<?php echo $this->createAbsoluteUrl('exchange'); ?>" size="60" readonly="readonly" onclick="this.select();" onfocus="this.select();">

    <div class="row">
        <?php echo $form->labelEx($model,'enterprise_1c_login'); ?>
      	<?php echo $form->textField($model,'enterprise_1c_login',array('size'=>60,'maxlength'=>64)); ?>
   		<?php echo $form->error($model,'enterprise_1c_login'); ?>
   	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'enterprise_1c_password'); ?>
      	<?php echo $form->textField($model,'enterprise_1c_password',array('size'=>60,'maxlength'=>64)); ?>
   		<?php echo $form->error($model,'enterprise_1c_password'); ?>
   	</div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить', array('class'=>'save_button')); ?>
   	</div>

    <?php $this->endWidget(); ?>

</fieldset>

<fieldset>
    <legend>Обмен данными через файл</legend>

    <?php echo CHtml::beginForm('export', 'get'); ?>

    <label><?php echo CHtml::radioButton('size', true, array('value'=>'new'))?> Только измененные после даты последнего экспорта</label>
    <label><?php echo CHtml::radioButton('size', false, array('value'=>'all'))?> Все заказы</label>
    <label><?php echo CHtml::radioButton('size', false, array('value'=>'amount'))?> Последние <input name="amount" value="50" size="4"> шт.</label>

    <label><?php echo CHtml::checkBox('download', true)?> скачать файл</label>

    <div class="row buttons">
   		<?php echo CHtml::submitButton('Экспортировать в XML-файл', array('class'=>'save_button', 'style'=>'width:260px;')); ?>
   	</div>

    <?php echo CHtml::endForm(); ?>

</fieldset>

</div>