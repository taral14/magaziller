<?php /*
  *
  * $products - товары что участвуют в сравнении
  *
  * */ ?>

<div class="best-head">Сравнение товаров</div>
<br>
<div class="best-content">


<?php if(Yii::app()->compare->isEmpty): ?>
Товаров нет в сравнении
<?php else: ?>

    <?php foreach(Yii::app()->compare->getProductsGroupByCategories() as $pack): list($category, $products)=$pack; ?>

        <?php if(Yii::app()->compare->getCategoriesCount()>1): ?>
        <h2> Сравнение товаров категории <?php echo $category->name; ?></h2>
        <?php endif; ?>

<div style="width: 750px; overflow: auto;">
<table width="<?php echo 200*count($products)+150; ?>">
    <thead>
        <tr>
            <th></th>
            <?php foreach($products as $product): ?>
            <th><a href="<?php echo $product->url; ?>"><?php echo $product->brand->name; ?> <?php echo $product->name; ?></a></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td></td>
            <?php foreach($products as $product): ?>
            <td><img src="<?php echo $product->getImageUrl('small'); ?>" width="170px"></td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Цена</td>
            <?php foreach($products as $product): ?>
            <td><?php echo Yii::app()->priceFormatter->format($product->price); ?></td>
            <?php endforeach; ?>
        </tr>

        <tr>
            <td>Кратко</td>
            <?php foreach($products as $product): ?>
            <td><?php echo $product->summary; ?></td>
            <?php endforeach; ?>
        </tr>

        <?php foreach($category->getFeatures(Feature::IN_COMPARE) as $feature): ?>

        <tr>
            <td><?php echo $feature->name; ?></td>
            <?php foreach($products as $product): ?>
            <td><?php echo $product->getHasFeatureValue($feature->id)?$product->getFeatureValue($feature->id).' '.$feature->unit:'-'; ?></td>
            <?php endforeach; ?>
        </tr>

        <?php endforeach; ?>

        <tr>
            <td></td>
            <?php foreach($products as $product): ?>
            <td><a href="<?php echo $this->createUrl('remove', array('id'=>$product->id)); ?>">[Убрать с сравнения]</a></td>
            <?php endforeach; ?>
        </tr>

    </tbody>
</table>
</div>
    <br>
        
    <?php endforeach; ?>
    
<?php endif; ?>

</div>