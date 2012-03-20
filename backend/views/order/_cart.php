<table class="order-cart">
    <thead>
        <tr>
            <th>Наименование</th>
            <th></th>
            <th>Сумма</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($products as $product): ?>
        <tr>
            <td><?php echo CHtml::link($product->name, array('product/update', 'id'=>$product->id)) ; ?></td>
            <td>
                <?php echo $product->quantity ; ?> × <?php echo Yii::app()->priceFormatter->format($product->orderPrice, true); ?>
                <?php if($product->discountPrice): ?>
                    - <?php echo Yii::app()->priceFormatter->format($product->discountPrice); ?>
                <?php endif; ?>
            </td>
            <td><?php echo Yii::app()->priceFormatter->format($product->sumPrice); ?></td>
        </tr>
        <?php endforeach; ?>
        <?php if($model->delivery): ?>
        <tr>
            <td>
                <?php echo CHtml::link('Доставка: '.$model->delivery->name, array('delivery/update', 'id'=>$model->delivery->id)) ; ?>
            </td>
            <td></td>
            <td><?php echo Yii::app()->priceFormatter->format($model->delivery_price, true); ?></td>
        </tr>
        <?php endif; ?>
        <tr>
            <td><h3>Итого</h3></td>
            <td><h3>
                <?php if($model->discountPrice): ?>
                    <?php echo Yii::app()->priceFormatter->format($model->getCost(false), true); ?> -
                    <?php echo Yii::app()->priceFormatter->format($model->discountPrice, true); ?>
                <?php endif; ?>
            </h3></td>
            <td><h3>
                <?php echo Yii::app()->priceFormatter->format($model->cost, true); ?>
            </h3></td>
        </tr>
    </tbody>
</table>