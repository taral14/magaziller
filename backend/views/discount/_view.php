<div class="view">

	<b>
	    <?php echo $data->name; ?>
        (от <?php echo Yii::app()->dateFormatter->format('dd MMMM y', $data->start_date); ?> до <?php echo Yii::app()->dateFormatter->format('dd MMMM y', $data->finish_date); ?>)
        <span style="float: right;"><?php echo Lookup::item('DiscountStatus', $data->status); ?></span>
    </b>

    <b class="clearb"></b>

    <?php echo CArray::get($data->getHandlerList(), $data->handler, '&nbsp;'); ?>

    <div class="management">
        <?php echo CHtml::link('Редактировать', array('update', 'id'=>$data->id)); ?> |
        <?php echo CHtml::link('Удалить', array('delete','id'=>$data->id), array('class'=>'delete-item'));?>
    </div>

</div>