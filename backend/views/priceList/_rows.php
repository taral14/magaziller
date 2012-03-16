<?php if(Yii::app()->user->hasFlash('upload_error')): ?>

<div class="errorSummary">
    <ul>
        <li><?php echo Yii::app()->user->getFlash('upload_error'); ?></li>
    </ul>
</div>

<?php else: ?>

<table style="width:675px;">
    <tbody>
    <?php foreach($model->rows as $i=>$row):?>
        <tr>
            <td><?php echo $row->article; ?></td>
            <td width="200">
            <?php
            $bindUrl=$this->createUrl('priceListRow/bind');
            $this->widget('ProductAutoComplete', array(
                'name'=>"Product[$i]",
                'value'=>CHtml::value($row, 'product.name'),
                'url'=>$this->createUrl('product/autoComplete', array('price_list_id'=>$model->id)),
                'options'=>array(
                    'change'=>"js:function(event,ui){
                        if(!ui.item) $(this).val('');
                        $.get('$bindUrl', {
                            id:$row->id,
                            product_id:(ui.item)?ui.item.id:''
                        });
                    }"
                ),
                'htmlOptions'=>array('style'=>'width:100%;')
            ));
            ?>
            </td>
            <td width="80"><?php echo Yii::app()->priceFormatter->format($row->price, true, 3); ?></td>
            <td width="60"><?php echo $row->availability?'есть':'нету'; ?><?php if($row->quantity) echo '('.$row->quantity.')'; ?></td>
            <td width="20"><img src="<?php echo $this->assetsUrl; ?>/images/delete.png" alt="Удалить" width="16" height="16" class="delete"></td>
        </tr>
    <?php endforeach; ?>
    <?php if($model->hasRows==false): ?>
        <tr>
            <td colspan="5">Прайс этого поставщика пустой</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>

<?php endif; ?>