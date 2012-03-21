<div class="view">

	<b>
	    <?php echo $data->title; ?>
        (<?php echo Yii::app()->dateFormatter->format('dd MMMM y, HH:mm:ss', $data->update_time); ?>)
        <span style="float: right;"><?php echo Lookup::item('ArticleStatus', $data->status); ?></span>
    </b>

    <b class="clearb"></b>

    <a class="url" href="<?php echo $data->url; ?>"><?php echo Yii::app()->request->hostInfo.$data->url; ?></a>

    <div class="management">
        <?php echo CHtml::link('Редактировать', array('update', 'id'=>$data->id)); ?> |
        <?php echo CHtml::link('Удалить', array('delete','id'=>$data->id), array('class'=>'delete-item'));?>
    </div>

</div>