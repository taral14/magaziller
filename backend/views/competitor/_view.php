<div class="view">

	<b>
        <?php echo $data->name; ?>
        <span style="float: right;">Отслеживается <?php echo Yii::t('app', '{n} товар|{n} товара|{n} товаров|{n} товар', $data->countProducts); ?></span>
    </b>

    <b class="clearb"></b>
    <?php echo CHtml::link($data->url, $data->url, array('target'=>'_blank')); ?>

    <div class="management">
        <?php echo CHtml::link('Редактировать', array('update', 'id'=>$data->id)); ?> |
        <?php echo CHtml::link('Удалить', array('delete','id'=>$data->id), array('class'=>'delete-item'));?>
    </div>

</div>