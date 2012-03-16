<div class="best-head">Корзина</div>
<br>
<div class="best-content">

    <?php $form=$this->beginWidget('CActiveForm', array(
    	'id'=>'products-form',
        'action'=>$this->createUrl('order/update')
    )); ?>
        <table class="products" width="100%">
            <col width="120">
            <col>
            <col width="60">
            <col width="60">
            <col width="120">
            <col width="20">
            <thead>
            <tr>
                <th></th>
                <th>Товар</th>
                <th>Цена</th>
                <th>Количество</th>
                <th>Итого</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <?php foreach(Yii::app()->cart->products as $i=>$product): ?>
            <tr>
                <td>
                    <img height="100" src="<?php echo $product->getImageUrl('small'); ?>">
                </td>
                <td valign="top">
                    <a href="<?php echo $product->url; ?>"><strong><?php echo $product->name; ?></strong></a><br>
                    <?php echo $product->summary; ?>
                </td>
                <td>
                    <?php echo Yii::app()->priceFormatter->format($product->price); ?>
                </td>
                <td>
                    <?php echo $form->dropDownList($product, "[$i]quantity", range(0,10), array('onchange'=>"$('#products-form').submit();")); ?> шт.
                </td>
                <td>
                    <?php echo Yii::app()->priceFormatter->format($product->sumPrice); ?>
                </td>
                <td>
                    <a title="убрать из корзины" href="<?php echo $this->createUrl('remove', array('id'=>$product->id)); ?>">
                        <img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/delete.png">
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php $this->endWidget(); ?>

    <b class="clearb"></b>
    <h3>Итого: <span id="subtotal_price"><?php echo Yii::app()->priceFormatter->format(Yii::app()->cart->cost); ?></span></h3>

    <b class="clearb"></b>

    <?php $this->renderPartial('_form', array('order'=>$order)); ?>

</div>