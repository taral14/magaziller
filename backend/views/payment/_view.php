<div class="view">

	<b>
        <?php echo $data->name; ?>
        <span style="float: right;"><?php echo Lookup::item('PaymentStatus', $data->status); ?></span>
    </b>
    <b class="clearb"></b>
	<?php echo $data->description; ?>
    <b class="clearb"></b>
    &nbsp;

    <div class="management">
        <?php echo CHtml::link('Редактировать', array('update', 'id'=>$data->id)); ?> |
        <?php echo CHtml::link('Удалить', array('delete','id'=>$data->id), array('class'=>'delete-item'));?>
    </div>
</div>