<div class="view">

	<b>
        ID <?php echo $data->id; ?>: <?php echo $data->name; ?> <?php echo $data->variation?'('.$data->variation.')':''; ?>
        (<?php echo Yii::app()->priceFormatter->format($data->price, true); ?>)
        <span style="float: right;">
            <?php echo Lookup::item('ProductStatus', $data->status); ?>
        </span>
    </b>
    <b class="clearb"></b>
    <div class="thumb-image">
        <?php echo CHtml::image($data->getImageUrl('thumb'), $data->name);?>
    </div>
    Категория: <?php echo $data->category->name; ?><br>
    Бренд: <?php echo ($data->brand)?$data->brand->name:'Не заполнено'; ?>
    <b class="clearb"></b>
    <?php
        $arr=array();
        if($data->hit)
            $arr[]=$data->getAttributeLabel('hit');
        if($data->shopwindow)
            $arr[]=$data->getAttributeLabel('shopwindow');
        echo empty($arr)?'&nbsp;':implode(', ', $arr);
    ?>
    <div class="management">
        <?php echo CHtml::link('Редактировать', array('update', 'id'=>$data->id)); ?> |
        <?php echo CHtml::link('Удалить', array('delete','id'=>$data->id), array('class'=>'delete-item'));?>
    </div>

</div>