<div class="view">

	<b>
        <?php echo $data->name; ?>
        <span style="float: right;"><?php echo Lookup::item('DeliveryStatus', $data->status); ?></span>
    </b>
	<b class="clearb"></b>
    <?php echo $data->description; ?>
    <b class="clearb"></b>
	<b><?php echo CHtml::encode($data->getAttributeLabel('price')); ?>:</b>
	<?php echo Yii::app()->priceFormatter->format($data->price, true); ?>

<?php if($data->free_from):?>
	<b><?php echo CHtml::encode($data->getAttributeLabel('free_from')); ?>:</b>
	<?php echo Yii::app()->priceFormatter->format($data->free_from, true); ?>
<?php endif;?>

    <div class="management">
        <?php echo CHtml::link('Редактировать', array('update', 'id'=>$data->id)); ?> |
        <?php echo CHtml::link('Удалить', array('delete','id'=>$data->id), array('class'=>'delete-item'));?>
    </div>

</div>