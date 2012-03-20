<a href="<?php echo $product->url; ?>"><div class="catalog_item">
    <div class="catalog_item_pic">
        <img src="<?php echo $product->getImageUrl('small'); ?>" />
     </div>
     <div class="catalog_item_price">
        <?php echo Yii::app()->priceFormatter->templateFormat('{int}<sup>{currency}</sup>', $product->price); ?>
     </div>
     <div class="catalog_item_opt">
        оптовая
         <strong>480</strong>
         за уп.
     </div>
     <h1><?php echo $product->name; ?></h1>
</div></a>