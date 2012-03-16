<div class="view">

	<b>
	    <?php echo $data->name; ?>
        (<?php echo $data->upload_time?Yii::app()->dateFormatter->format('dd MMMM y, HH:mm:ss', $data->upload_time):'не обновлялся'; ?>)
        <span style="float: right;"><?php echo Lookup::item('PriceListStatus', $data->status); ?></span>
    </b>
    <b class="clearb"></b>
    <?php echo CHtml::encode($data->description); ?>
    <b class="clearb"></b>
    <?php echo Yii::t('app', '{n} позиция|{n} позиции|{n} позиций|{n} позиция', $data->countRows); ?>
    &nbsp;

    <div class="management">
        <?php echo CHtml::link('Редактировать', array('update', 'id'=>$data->id)); ?> |
        <?php echo CHtml::link('Удалить', array('delete','id'=>$data->id), array('class'=>'delete-item'));?>
    </div>
</div>