<div class="basket">
<?php if(Yii::app()->cart->isEmpty): ?>
<a href="#"></a>
<span>В корзине нет товаров</span>
<?php else: ?>
<a href="<?php echo Yii::app()->createUrl('order') ?>">
<span>В корзине <?php echo Yii::t('app', '{n} товар|{n} товара|{n} товаров|{n} товар', Yii::app()->cart->itemsCount); ?></span>
</a>
<?php endif; ?>
</div>