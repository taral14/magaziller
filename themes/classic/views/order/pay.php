<?php
Yii::app()->getClientScript()->registerScript('payment', "
    $('.payment-row').click(function() {
        var el=$(this);
        el.find(':radio').attr('checked', true);
        $('#payment-form').submit();
    });
");
?>

<div class="best-head">
    <?php if($order->payment_status==Order::PAYMENT_STATUS_SUCCESS): ?>
    Ваш заказ успешно оплачен
    <?php else: ?>
    Ваш заказ еще не оплачен
    <?php endif; ?>
</div>
<br>
<div class="best-content">

    <table class="products" width="100%">
        <col width="120">
        <col>
        <col width="120">
        <col width="60">
        <col width="120">
        <thead>
        <tr>
            <th></th>
            <th>Товар</th>
            <th>Цена</th>
            <th>Количество</th>
            <th>Итого</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($order->products as $i=>$product): ?>
        <tr>
            <td>
                <img height="100" src="<?php echo $product->getImageUrl('small'); ?>">
            </td>
            <td valign="top">
                <a href="<?php echo $product->url; ?>"><strong><?php echo $product->name; ?></strong></a>
            </td>
            <td>
                <?php echo Yii::app()->priceFormatter->format($product->price); ?>
            </td>
            <td>
                <?php echo $product->quantity; ?> шт.
            </td>
            <td>
                <?php echo Yii::app()->priceFormatter->format($product->sumPrice); ?>
            </td>
        </tr>
        <?php endforeach; ?>
        <?php if($order->delivery): ?>
        <tr>
            <td></td>
            <td valign="top" colspan="3"><?php echo $order->delivery->name; ?></td>
            <td>
                <?php echo Yii::app()->priceFormatter->format($order->delivery->priceTo($order->cost)); ?>
            </td>
        </tr>
        <?php endif; ?>

        </tbody>
    </table>

    <h3>Итого: <span id="subtotal_price"><?php echo Yii::app()->priceFormatter->format($order->cost); ?></span></h3>

    <?php echo CHtml::beginForm('', 'post', array('id'=>'payment-form')); ?>

    <table>
       <tbody>
       <?php foreach($order->payments as $payment): ?>
        <tr class="payment-row">
            <td>
                <p><?php echo CHtml::activeRadioButton($order, 'payment_id', array('value'=>$payment->id, 'uncheckValue'=>null)); ?></p>
            </td>
            <td>
                <h3><?php echo $payment->name; ?></h3>
                <p><?php echo $payment->description; ?></p>
            </td>
        </tr>
       <?php endforeach; ?>
       </tbody>
    </table>

    <?php echo CHtml::endForm(); ?>

    <?php if($order->getPayHandler()): ?>
    <?php echo $order->renderPayForm(); ?>
    <?php else: ?>
    <h3>Для уточнения процедуры оплаты свяжитесь с нами</h3>
    <?php endif; ?>
</div>
