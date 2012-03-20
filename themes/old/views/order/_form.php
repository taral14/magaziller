<?php
Yii::app()->getClientScript()->registerScript('delivery-payment', "
    $('.delivery-radio').click(function(){
        var el=$(this);
        el.find(':radio').attr('checked', true);
        $('#total_price').html(el.attr('price'));
        var payment_ids=el.attr('payment_ids').split(',');
        $('#Order_payment_id option').each(function() {
            if(this.value!='' && $.inArray(this.value, payment_ids)==-1) {
                $(this).hide();
                if(this.selected) {
                    $('#Order_payment_id').val('').change();
                }
            } else {
                $(this).show();
            }
        });
    });
    $('.delivery-radio:has(:radio:checked)').click();
");
?>
<h2>Доставка</h2>

<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
    'action'=>$this->createUrl('index'),
	'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
)); ?>
    <?php echo $form->errorSummary($order); ?>

        <table>
           <tbody>
           <?php foreach(Delivery::model()->findAll() as $delivery): ?>
            <tr class="delivery-radio" price="<?php echo Yii::app()->priceFormatter->format(Yii::app()->cart->cost+$delivery->priceTo(Yii::app()->cart->cost)); ?>" payment_ids="<?php echo implode(',',$delivery->paymentIds); ?>">
                <td>
                    <p><?php echo $form->radioButton($order, 'delivery_id', array('value'=>$delivery->id, 'uncheckValue'=>null)); ?></p>
                </td>
                <td>
                    <h3><?php echo $delivery->name; ?> (<?php echo Yii::app()->priceFormatter->format($delivery->price); ?><?php if($delivery->free_from):?> бесплатно от <?php echo Yii::app()->priceFormatter->format($delivery->free_from); ?><?php endif; ?>)</h3>
                    <p><?php echo $delivery->description; ?></p>
                </td>
            </tr>
           <?php endforeach; ?>
           </tbody>
        </table>

    <div class="total_line">
        <span class="total_sum">Итого с доставкой: <span id="total_price"><?php echo Yii::app()->priceFormatter->format($order->delivery?Yii::app()->cart->cost+$order->delivery->priceTo(Yii::app()->cart->cost):Yii::app()->cart->cost ); ?></span>
    </div>

    <h1>Адрес получателя</h1>

	<div class="row">
		<?php echo $form->labelEx($order, 'payment_id'); ?>
		<?php echo $form->dropDownList($order, 'payment_id', CHtml::listData(Payment::model()->findAll(), 'id', 'name'), array('empty'=>'')); ?>
		<?php echo $form->error($order, 'payment_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($order, 'name'); ?>
		<?php echo $form->textField($order, 'name'); ?>
		<?php echo $form->error($order, 'name'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($order, 'email'); ?>
        <?php echo $form->textField($order, 'email'); ?>
        <?php echo $form->error($order, 'email'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($order, 'phone'); ?>
        <?php echo $form->textField($order, 'phone'); ?>
        <?php echo $form->error($order, 'phone'); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($order, 'address'); ?>
        <?php echo $form->textArea($order, 'address', array('cols'=>40, 'rows'=>4)); ?>
        <?php echo $form->error($order, 'address'); ?>
    </div>

    <?php echo CHtml::submitButton('Заказать'); ?>

<?php $this->endWidget(); ?>
</div>