<li class="best-item">
    <div class="best-inactive">
        <a href="<?php echo $product->url; ?>"><img height="250" src="<?php echo $product->getImageUrl('small'); ?>" /></a>
        <b class="clearb"></b>
        <div class="best-price">
        <?php echo Yii::app()->priceFormatter->templateFormat('{int}<span>{currency}</span>', $product->price); ?>
        </div>
        <a class="buy" onclick="$.putToCart(<?php echo $product->id; ?>); return false;" href="#"></a>
        <a class="buy" onclick="$.putToCompare(<?php echo $product->id; ?>); return false;" href="#"></a>
        <b class="clearb"></b>
        <a class="name" href="<?php echo $product->url; ?>"><?php echo $product->name; ?></a>
    </div>
</li>