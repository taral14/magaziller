<div class="row">
	<label for="Payment_handlerParams_recipient">Получатель</label>
	<?php echo CHtml::activeTextField($model, 'handlerParams[recipient]',array('size'=>60,'maxlength'=>255)); ?>
</div>

<div class="row">
 	<label for="Payment_handlerParams_inn">ИНН получателя</label>
 	<?php echo CHtml::activeTextField($model, 'handlerParams[inn]',array('size'=>60,'maxlength'=>255)); ?>
</div>

<div class="row">
  	<label for="Payment_handlerParams_account">Счет получателя</label>
  	<?php echo CHtml::activeTextField($model, 'handlerParams[account]',array('size'=>60,'maxlength'=>255)); ?>
</div>

<div class="row">
  	<label for="Payment_handlerParams_bank">Банк получателя</label>
  	<?php echo CHtml::activeTextField($model, 'handlerParams[bank]',array('size'=>60,'maxlength'=>255)); ?>
</div>

<div class="row">
   	<label for="Payment_handlerParams_bik">БИК</label>
   	<?php echo CHtml::activeTextField($model, 'handlerParams[bik]',array('size'=>60,'maxlength'=>255)); ?>
</div>

<div class="row">
    <label for="Payment_handlerParams_correspondent_account">Кор. счет</label>
    <?php echo CHtml::activeTextField($model, 'handlerParams[correspondent_account]',array('size'=>60,'maxlength'=>255)); ?>
</div>

<div class="row">
     <label for="Payment_handlerParams_banknote">Обозначение валюты</label>
     <?php echo CHtml::activeTextField($model, 'handlerParams[banknote]',array('size'=>60,'maxlength'=>255)); ?>
</div>

<div class="row">
     <label for="Payment_handlerParams_pense">Обозначение копеек</label>
     <?php echo CHtml::activeTextField($model, 'handlerParams[pense]',array('size'=>60,'maxlength'=>255)); ?>
</div>