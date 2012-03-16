<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'order-form',
	'enableAjaxValidation'=>true,
)); ?>

	<?php echo $form->errorSummary($model); ?>

<?php $this->beginClip('basic'); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'delivery_id'); ?>
		<?php echo $form->dropDownList($model,'delivery_id', CHtml::listData(Delivery::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'delivery_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'delivery_price'); ?>
		<?php echo $form->textField($model,'delivery_price'); ?>
		<?php echo $form->error($model,'delivery_price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'payment_id'); ?>
        <?php echo $form->dropDownList($model,'payment_id', CHtml::listData(Payment::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'payment_id'); ?>
	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'payment_status'); ?>
   		<?php echo $form->dropDownList($model,'payment_status', Lookup::items('OrderPaymentStatus')); ?>
   		<?php echo $form->error($model,'payment_status'); ?>
   	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('OrderStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
        <?php if($model->user): ?>
            <?php echo CHtml::link('[Профиль]', array('user/update', 'id'=>$model->user_id)); ?>
        <?php endif; ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'phone'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'email'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'address'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'comment'); ?>
		<?php echo $form->textArea($model,'comment',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'comment'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>
<?php $this->endClip(); ?>

<?php $this->beginClip('info'); ?><div class="form wide">

	<div class="row">
		<?php echo $form->labelEx($model,'create_time'); ?>
		<?php echo Yii::app()->dateFormatter->format('dd MMMM y', $model->create_time); ?>
	</div>

    <?php if($model->user): ?>
	<div class="row">
		<?php echo $form->labelEx($model->user,'username'); ?>
        <?php echo CHtml::link($model->user->username, array('user/update', 'id'=>$model->user->id)); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model->user,'email'); ?>
        <?php echo CHtml::mailto($model->user->email, $model->user->email); ?>
	</div>
    <?php endif; ?>

	<div class="row">
		<?php echo $form->labelEx($model,'ip'); ?>
		<?php echo $model->ip; ?>
	</div>

<?php if($model->referer): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'referer'); ?>
		<?php echo urldecode($model->refererHost); ?>
	</div>
<?php if($model->search_terms): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'search_terms'); ?>
		<?php echo $model->search_terms; ?>
	</div>
<?php endif; ?>
<?php endif; ?>

</div><?php $this->endClip(); ?>


    <?php
    $this->widget('CTabView', array(
        'tabs'=>array(
            'tab1'=>array(
                'title'=>'Основные',
                'content'=>$this->clips['basic'],
            ),
            'tab2'=>array(
                'title'=>'Корзина',
                'view'=>'_cart',
                'data'=>array(
                    'model'=>$model,
                    'products'=>$model->products,
                ),
            ),
            'tab3'=>array(
                'title'=>'Информация',
                'content'=>$this->clips['info'],
            ),
        )
    ));
    ?>

<?php $this->endWidget(); ?>

</div><!-- form -->