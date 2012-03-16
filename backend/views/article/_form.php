<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'article-form',
	'enableAjaxValidation'=>true,
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
		<?php echo $form->labelEx($model,'content'); ?>
        <?php $this->widget('ElRTE', array(
            'model'=>$model,
            'attribute'=>'content',
        )); ?>
		<?php echo $form->error($model,'content'); ?>
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
		<?php echo $form->dropDownList($model,'status',Lookup::items('ArticleStatus')); ?>
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