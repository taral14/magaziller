<div class="view">

	<b>
	    <?php echo $data->pack->name; ?>: <?php echo $data->name; ?>
        <span style="float: right;"><?php echo Lookup::item('FeatureStatus', $data->status); ?></span>
    </b>

    <b class="clearb"></b>

    <?php echo Lookup::item('FeatureType', $data->type); ?>

    <div class="management">
        <?php echo CHtml::link('Редактировать', array('update', 'id'=>$data->id)); ?> |
        <?php echo CHtml::link('Удалить', array('delete','id'=>$data->id), array('class'=>'delete-item'));?>
    </div>

</div>