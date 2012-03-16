<div class="view">

	<b>
	    <?php echo $data->name; ?> (<?php echo $data->route; ?>)
    </b>

    <b class="clearb"></b>

    <?php echo Yii::t('app', '{n} слайд|{n} слайда|{n} слайдов|{n} слайд', $data->countItems); ?>

    <div class="management">
        <?php echo CHtml::link('Подробнее', array('view', 'id'=>$data->id)); ?> |
        <?php echo CHtml::link('Удалить', array('delete','id'=>$data->id), array('class'=>'delete-item'));?>
    </div>

</div>