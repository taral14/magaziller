<?php
$css_class='';
switch($data->status) {
    case Order::STATUS_NEW:
        $css_class=' view-order-new';
        break;
    case Order::STATUS_PROCESSING:
        $css_class=' view-order-processing';
        break;
    case Order::STATUS_ABSENT:
        $css_class=' view-order-absent';
        break;
    case Order::STATUS_DELETE:
    case Order::STATUS_COMPLETE:
        $css_class=' view-order';
        break;
}
$payment_css_class='';
switch($data->payment_status) {
    case Order::PAYMENT_STATUS_SUCCESS:
        $payment_css_class='order-payment-success';
        break;
    case Order::PAYMENT_STATUS_FAILURE:
        $payment_css_class='order-payment-failure';
        break;
}
?>


<div class="view<?php echo $css_class; ?>">

	<b>
        Заказ №<?php echo $data->id; ?>
        (<?php echo Yii::app()->dateFormatter->format('dd MMMM y, HH:mm:ss', $data->create_time); ?>)
        <span style="float: right;">
            <?php echo Lookup::item('OrderStatus', $data->status); ?>
        </span>
    </b>
    <b class="clearb"></b>
    <div style="float: left;width: 285px;">
        <b><?php echo $data->getAttributeLabel('name'); ?>:</b> <?php echo $data->name; ?><br>
        <b><?php echo $data->getAttributeLabel('phone'); ?>:</b> <?php echo $data->email; ?><br>
        <b><?php echo $data->getAttributeLabel('email'); ?>:</b> <?php echo $data->email; ?><br>
        <b><?php echo $data->getAttributeLabel('address'); ?>:</b> <?php echo $data->address; ?><br>
        <i><?php echo $data->comment; ?></i>
    </div>

    <div style="float: left;width: 600px;">
        <table class="order-cart">
                <?php foreach($data->products as $product): ?>
                <tr>
                    <td><?php echo CHtml::link($product->name, array('product/update', 'id'=>$product->id)) ; ?></td>
                    <td><?php echo $product->quantity ; ?> × <?php echo Yii::app()->priceFormatter->format($product->orderPrice, true); ?></td>
                </tr>
                <?php endforeach; ?>
                <?php if($data->delivery): ?>
                <tr>
                    <td>
                        <?php echo CHtml::link('Доставка: '.$data->delivery->name, array('delivery/update', 'id'=>$data->delivery->id)) ; ?>
                    </td>
                    <td><?php echo Yii::app()->priceFormatter->format($data->delivery_price, true); ?></td>
                </tr>
                <?php endif; ?>
                <tr>
                    <td><b>Итого</b></td>
                    <td><b><?php echo Yii::app()->priceFormatter->format($data->cost, true); ?></b></td>
                </tr>
        </table>
    </div>

    <b class="clearb"></b>
    <?php if($data->payment): ?>
    <span class="<?php echo $payment_css_class; ?>"><?php echo $data->payment->name; ?> (<?php echo Lookup::item('OrderPaymentStatus', $data->payment_status); ?>)</span>
    <?php else: ?>
    &nbsp;
    <?php endif; ?>

    <div class="management">
        <?php if($data->status==Order::STATUS_NEW): ?>
        <?php
        echo CHtml::link('В обработку', array('updateStatus', 'id'=>$data->id, 'status'=>Order::STATUS_PROCESSING), array(
            'class'=>'order-status-processing',
        ));
        ?> |
        <?php endif; ?>

        <?php if($data->status==Order::STATUS_PROCESSING): ?>
        <?php
        echo CHtml::link('Выполнен', array('updateStatus', 'id'=>$data->id, 'status'=>Order::STATUS_COMPLETE), array(
            'class'=>'order-status-complete',
        ));
        ?> |
        <?php endif; ?>

        <?php echo CHtml::link('Редактировать', array('update', 'id'=>$data->id)); ?>

        <?php if($data->status!=Order::STATUS_DELETE): ?>
        |
        <?php
        echo CHtml::link('Удалить', array('updateStatus', 'id'=>$data->id, 'status'=>Order::STATUS_DELETE), array(
            'class'=>'order-status-delete',
        ));
        ?>
        <?php endif; ?>
    </div>

</div>