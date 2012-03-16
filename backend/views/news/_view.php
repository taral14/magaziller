<div class="view">

	<b>
	    <?php echo $data->title; ?>
        (<?php echo Yii::app()->dateFormatter->format('dd MMMM y', $data->publish_date); ?>)
        <span style="float: right;"><?php echo Lookup::item('NewsStatus', $data->status); ?></span>
    </b>
    <b class="clearb"></b>
	<?php echo CHtml::encode($data->annotation); ?>
    <b class="clearb"></b>
    &nbsp;

    <div class="management">
        <?php echo CHtml::link('Редактировать', array('update', 'id'=>$data->id)); ?> | 
        <?php echo CHtml::link('Удалить', array('delete','id'=>$data->id), array('class'=>'delete-item'));?>
    </div>

</div>