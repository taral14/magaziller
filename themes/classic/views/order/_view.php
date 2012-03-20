<?php if(Yii::app()->cart->isEmpty): ?>
<a href="#"><div class="cart">
    <div class="cart_head">
    Корзина
    </div>
    <p>0 товаров,</p>
    <p>перейти</p>
</div></a>
<?php else: ?>
<a href="<?php echo Yii::app()->createUrl('order/index') ?>"><div class="cart">
    <div class="cart_head">
    Корзина
    </div>
    <p><?php echo Yii::t('app', '{n} товар|{n} товара|{n} товаров|{n} товар', Yii::app()->cart->itemsCount); ?>,</p>
    <p>перейти</p>
</div></a>
<?php endif; ?>