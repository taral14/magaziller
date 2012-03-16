<?php
    Yii::app()->clientScript->registerScript('use_image', "
        $('#ScrapTemplate_use_image').change(function(){
            if($(this).is(':checked'))
                $('div.image-params').show();
            else
                $('div.image-params').hide();
        }).change();
    ");
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'scrap-template-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'template'); ?>
        <?php $this->widget('CodeMirror', array(
            'model'=>$model,
            'attribute'=>'template',
        )); ?>
		<?php echo $form->error($model,'template'); ?>
	</div>

	<div class="row">
        <?php echo $form->checkBox($model,'use_image', array('uncheckValue'=>0)); ?>
        <?php echo $form->label($model,'use_image'); ?>
		<?php echo $form->error($model,'use_image'); ?>
	</div>

    <div class="row image-params">
   		<?php echo $form->labelEx($model,'image'); ?>
   		<?php echo $form->textField($model,'image_width',array('size'=>4,'maxlength'=>4)); ?> Х
        <?php echo $form->textField($model,'image_height',array('size'=>4,'maxlength'=>4)); ?>
   		<?php echo $form->error($model,'image_width'); ?>
        <?php echo $form->error($model,'image_height'); ?>
   	</div>

	<div class="row">
        <?php echo $form->checkBox($model,'use_title', array('uncheckValue'=>0)); ?>
        <?php echo $form->label($model,'use_title'); ?>
		<?php echo $form->error($model,'use_title'); ?>
	</div>

	<div class="row">
        <?php echo $form->checkBox($model,'use_content', array('uncheckValue'=>0)); ?>
        <?php echo $form->label($model,'use_content'); ?>
		<?php echo $form->error($model,'use_content'); ?>
	</div>

	<div class="row">
        <?php echo $form->checkBox($model,'use_product', array('uncheckValue'=>0)); ?>
        <?php echo $form->label($model,'use_product'); ?>
		<?php echo $form->error($model,'use_product'); ?>
	</div>

    <div class="row">
        <?php echo $form->checkBox($model,'use_news', array('uncheckValue'=>0)); ?>
        <?php echo $form->label($model,'use_news'); ?>
        <?php echo $form->error($model,'use_news'); ?>
    </div>

    <div class="row">
        <?php echo $form->checkBox($model,'use_promotion', array('uncheckValue'=>0)); ?>
        <?php echo $form->label($model,'use_promotion'); ?>
        <?php echo $form->error($model,'use_promotion'); ?>
    </div>

    <div class="row">
        <?php echo $form->checkBox($model,'use_category', array('uncheckValue'=>0)); ?>
        <?php echo $form->label($model,'use_category'); ?>
        <?php echo $form->error($model,'use_category'); ?>
    </div>

    <div class="row">
        <?php echo $form->checkBox($model,'use_brand', array('uncheckValue'=>0)); ?>
        <?php echo $form->label($model,'use_brand'); ?>
        <?php echo $form->error($model,'use_brand'); ?>
    </div>

    <div class="row">
        <?php echo $form->checkBox($model,'use_url', array('uncheckValue'=>0)); ?>
        <?php echo $form->label($model,'use_url'); ?>
        <?php echo $form->error($model,'use_url'); ?>
    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->