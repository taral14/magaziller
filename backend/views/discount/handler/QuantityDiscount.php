<div class="row">
    <label for="Discount_handlerParams_minProductQuantity">Минимальное количество товаров одного типа для скидки на них: <span id="min-product-quantity-value"><?php echo @$model->handlerParams['minProductQuantity']; ?></span></label>
    <?php echo CHtml::activeHiddenField($model,'handlerParams[minProductQuantity]'); ?>
    <?php $this->widget('zii.widgets.jui.CJuiSlider', array(
        'value'=>@$model->handlerParams['minProductQuantity'],
        'options'=>array(
            'min'=>0,
            'max'=>50,
            'slide'=>"js:function(event, ui){ $('#Discount_handlerParams_minProductQuantity').val(ui.value); $('#min-product-quantity-value').text(ui.value); }",
        ),
        'htmlOptions'=>array(
            'style'=>'width:300px;',
        ),
    )); ?>
</div>

<div class="row">
    <label for="Discount_handlerParams_minCartQuantity">Минимальное количество товаров в корзине для скидки <span id="min-cart-quantity-value"><?php echo @$model->handlerParams['minCartQuantity']; ?></span></label>
    <?php echo CHtml::activeHiddenField($model,'handlerParams[minCartQuantity]'); ?>
    <?php $this->widget('zii.widgets.jui.CJuiSlider', array(
        'value'=>@$model->handlerParams['minCartQuantity'],
        'options'=>array(
            'min'=>0,
            'max'=>50,
            'slide'=>"js:function(event, ui){ $('#Discount_handlerParams_minCartQuantity').val(ui.value); $('#min-cart-quantity-value').text(ui.value); }",
        ),
        'htmlOptions'=>array(
            'style'=>'width:300px;',
        ),
    )); ?>
</div>