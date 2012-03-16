<?php
Yii::app()->clientScript->registerScript('sortable-category', "
$('#Market_description_type').change(function(){
    var value=$(this).val();
    if(value==1)
        $('#Market_description').show();
    else
        $('#Market_description').val('').hide();
}).change();
");
?>

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'market-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

<!-- Основные -->
<?php $this->beginClip('basic'); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php echo $form->dropDownList($model,'description_type',Lookup::items('MarketDescriptionType')); ?><br>
        <?php echo $form->textArea($model, 'description', array('rows'=>5, 'cols'=>60)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('MarketStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>
<?php $this->endClip(); ?>

<?php $this->beginClip('categories'); ?>
    <ul class="in-categories">
        <?php echo $this->renderPartial('_categories', array(
            'model'=>$model,
            'categories'=>Category::model()->rooted()->findAll()
        )); ?>
    </ul>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>
<?php $this->endClip(); ?>

<!-- //Основные -->
    <?php
    $this->widget('CTabView', array(
        'tabs'=>array(
            'tab1'=>array(
                'title'=>'Основные',
                'content'=>$this->clips['basic'],
            ),
            'tab2'=>array(
                'title'=>'Экспортировать товары с категорий',
                'content'=>$this->clips['categories'],
            ),
        )
    ));
    ?>

<?php $this->endWidget(); ?>

</div><!-- form -->