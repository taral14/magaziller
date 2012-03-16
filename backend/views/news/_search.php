<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

    <?php echo $form->hiddenField($model,'status'); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'publish_date'); ?>

        от
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,
            'attribute'=>'publish_date[from]',
            'language'=>'ru',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
            ),
        )); ?>

        - до
        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
            'model'=>$model,
            'attribute'=>'publish_date[till]',
            'language'=>'ru',
            'options' => array(
                'dateFormat' => 'yy-mm-dd',
            ),
        )); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Поиск', array('class'=>'search_button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->