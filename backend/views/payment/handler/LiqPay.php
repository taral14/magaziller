<div class="row">
	<label for="Payment_handlerParams_merchant_id">ID мерчанта</label>
	<?php echo CHtml::activeTextField($model, 'handlerParams[merchant_id]',array('size'=>60,'maxlength'=>255)); ?>
</div>

<div class="row">
 	<label for="Payment_handlerParams_signature">Подпись для остальных операций</label>
 	<?php echo CHtml::activeTextField($model, 'handlerParams[signature]',array('size'=>60,'maxlength'=>255)); ?>
 </div>