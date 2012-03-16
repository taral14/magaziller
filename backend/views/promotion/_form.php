<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'promotion-form',
	'enableAjaxValidation'=>true,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data',
    ),
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

<!-- Основные -->
<?php $this->beginClip('basic'); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'title'); ?>
		<?php echo $form->textField($model,'title',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'title'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'annotation'); ?>
        <?php $this->widget('ElRTE', array(
            'model'=>$model,
            'attribute'=>'annotation',
            'options' => array(
                'height' => '150',
            ),
        )); ?>
		<?php echo $form->error($model,'annotation'); ?>
	</div>

	<div class="row">
        <?php if(!$model->isNewRecord && $model->image): ?>
        <?php $this->beginWidget('PrettyPhoto', array(
            'gallery'=>false
        )); ?>
        <a class="thumb-image" title="" href="<?php echo $model->getImageUrl('large'); ?>" target="_blank">
            <?php echo CHtml::image($model->getImageUrl('thumb'), $model->title);?>
        </a>
        <?php $this->endWidget(); ?>
        <?php else: ?>
        <div class="thumb-image">
            <?php echo CHtml::image($model->getImageUrl('thumb'), $model->title);?>
        </div>
        <?php endif; ?>
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'content'); ?>
        <?php $this->widget('widgets.ElRTE', array(
            'model'=>$model,
            'attribute'=>'content',
        )); ?>
		<?php echo $form->error($model,'content'); ?>
	</div>

    <div class="row">
           <?php echo $form->labelEx($model,'productNames'); ?>
           <?php $this->widget('ProductAutoComplete', array(
               'model'=>$model,
               'attribute'=>'productNames',
               'url'=>$this->createUrl('product/autoComplete'),
               'options'=>array(
                   'select'=>'js:function(event,ui){
                       var terms = this.value.split(/,\s*/);
   					terms.pop();
   					terms.push(ui.item.value);
   					terms.push("");
   					this.value = terms.join(", ");
   					return false;
                   }'
               ),
               'htmlOptions'=>array('size'=>100,'maxlength'=>255)
           )); ?>
   	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'tags'); ?>
        <?php
        $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'model'=>$model,
            'attribute'=>'tags',
            'sourceUrl'=>$this->createUrl('tag/autoComplete'),
            'options'=>array(
                'select'=>'js:function(event,ui){
                    var terms = this.value.split(/,\s*/);
					terms.pop();
					terms.push(ui.item.value);
					terms.push("");
					this.value = terms.join(", ");
					return false;
                }'
            ),
            'htmlOptions'=>array('size'=>100,'maxlength'=>255)
        ));
        ?>
   		<?php echo $form->error($model,'tags'); ?>
   	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
        <?php echo $form->dropDownList($model,'status',Lookup::items('PromotionStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

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
                'title'=>'SEO информация',
                'view'=>'/seo/_form',
                'data'=>array(
                    'model'=>$model,
                    'form'=>$form,
                ),
            ),
        )
    ));
    ?>



<?php $this->endWidget(); ?>

</div><!-- form -->