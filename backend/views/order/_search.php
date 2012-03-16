<div class="wide form">

<p>
Вы можете дополнительно ввести оператор сравнения (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
или <b>=</b>) в начале каждого из Ваших поисковых значений, чтобы определить, как сравнение должно быть сделано.
</p>

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

    <div class="row">
   		<?php echo $form->label($model,'create_time'); ?>
           от
           <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
               'model'=>$model,
               'attribute'=>'create_time[from]',
               'language'=>'ru',
               'options' => array(
                   'dateFormat' => 'yy-mm-dd 00:00:00',
               ),
           )); ?>

           - до
           <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
               'model'=>$model,
               'attribute'=>'create_time[till]',
               'language'=>'ru',
               'options' => array(
                   'dateFormat' => 'yy-mm-dd 23:59:59',
               ),
           )); ?>
   	</div>

	<div class="row">
		<?php echo $form->label($model,'phone'); ?>
		<?php echo $form->textField($model,'phone',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'email'); ?>
		<?php echo $form->textField($model,'email',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'address'); ?>
		<?php echo $form->textField($model,'address',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'comment'); ?>
		<?php echo $form->textField($model,'comment',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Поиск', array('class'=>'search_button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->