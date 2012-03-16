<div class="view">

	<b>
	    <?php echo $data->username; ?>
        (<?php echo Yii::app()->dateFormatter->format('dd MMMM y', $data->create_time); ?>)
        <span style="float: right;"><?php echo Lookup::item('UserStatus', $data->status); ?></span>
    </b>
    <b class="clearb"></b>

<?php if($data->role==User::ROLE_CLIENT): ?>
    <div style="float: left;width: 300px;">
        <?php echo $data->getAttributeLabel('phone'); ?>: <?php echo $data->phone; ?><br>
        <?php echo $data->getAttributeLabel('email'); ?>: <?php echo $data->email; ?><br>
    </div>

    <div style="float: left;width: 350px;">
        <?php echo $data->getAttributeLabel('group_id'); ?>: <?php echo $data->group->name; ?><br>
        <?php echo $data->getAttributeLabel('address'); ?>: <?php echo $data->address; ?><br>
    </div>
    <b class="clearb"></b>
<?php endif; ?>

    <?php echo Lookup::item('UserRole', $data->role); ?>

    <div class="management">
        <?php echo CHtml::link('Редактировать', array('update', 'id'=>$data->id)); ?> |
        <?php echo CHtml::link('Удалить', array('delete','id'=>$data->id), array('class'=>'delete-item'));?>
    </div>

</div>