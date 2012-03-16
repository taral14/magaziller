<table>
    <thead>
    <tr>
        <th width="200">Прайс-лист</th>
        <th>Артикул</th>
        <th width="80">Цена</th>
        <th width="80">Склад</th>
    </tr>
    </thead>
    <tbody>
<?php foreach(PriceList::model()->findAll() as $i=>$priceList): ?>
    <?php $row=$model->getPriceListRow($priceList->id); ?>
    <tr <?php if($priceList->status==PriceList::STATUS_DISABLED):?>style="color: #CCCCCC;" title="Поставщик &quot;<?php echo $priceList->name; ?>&quot; отключен"<?php endif; ?>>
        <td><?php echo $priceList->name; ?></td>
        <td>
        <?php
        $bindUrl=$this->createUrl('priceListRow/bind');
        $unbindUrl=$this->createUrl('priceListRow/unbind');
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'name'=>"Pricelist[$i]",
                'value'=>$row?$row->article:'',
                'sourceUrl'=>$this->createUrl('priceListRow/autoComplete', array('price_list_id'=>$priceList->id)),
                'options'=>array(
                    'change'=>"js:function(event,ui){
                        if(!ui.item) $(this).val('');
                        if(ui.item) {
                            $.get('$bindUrl', {
                                id:ui.item.id,
                                product_id:$model->id
                            }, function(){ displayMessage('Позиция прайса привязана к товару', 'success'); });
                        } else {
                            $.get('$unbindUrl', {
                                price_list_id:$priceList->id,
                                product_id:$model->id
                            }, function(){ displayMessage('Связь разорвана', 'success'); });
                        }
                    }"
                ),
                'htmlOptions'=>array('style'=>'width:100%')
        ));
        ?></td>
        <td><?php if($row) echo Yii::app()->priceFormatter->format($row->price, true);?></td>
        <td><?php if($row) {
            echo ($row->availability)?'есть':'нету';
            echo ($row->quantity)?'('.$row->quantity.')':'';
        } ?></td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>