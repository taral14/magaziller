<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'category-form',
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
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
        <?php
        $this->widget('McDropdown',array(
            'model'=>$model,
            'attribute'=>'parent_id',
            'data' => Category::model()->rooted()->findAll(),
            'without'=>$model->id,
            'options'=>array(
                'select'=>'js:function(id){
                    $("#tab3").html("Сперва нужно сохранить категорию.");
                }'
            )
        ));
        ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php $this->widget('ElRTE', array(
            'model'=>$model,
            'attribute'=>'description',
        )); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
        <?php if(!$model->isNewRecord && $model->image): ?>
        <?php $this->beginWidget('PrettyPhoto', array(
            'gallery'=>false
        )); ?>
        <a class="thumb-image" href="<?php echo $model->getImageUrl('large'); ?>" target="_blank">
            <?php echo CHtml::image($model->getImageUrl('thumb'), $model->name);?>
        </a>
        <?php $this->endWidget(); ?>
        <?php else: ?>
        <div class="thumb-image">
            <?php echo CHtml::image($model->getImageUrl('thumb'), $model->name);?>
        </div>
        <?php endif; ?>
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('CategoryStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>
<?php $this->endClip(); ?>
<!-- //Основные -->

    <?php
    $tabs=array(
        'basic'=>array(
            'title'=>'Основные',
            'content'=>$this->clips['basic'],
        ),
        'seo'=>array(
            'title'=>'SEO',
            'view'=>'/seo/_form',
            'data'=>array(
                'model'=>$model,
                'form'=>$form,
            ),
        ),
    );
    if(!$model->isNewRecord) {
        $tabs['position']=array(
            'title'=>'Настроить порядок',
            'view'=>'_position',
            'data'=>array(
                'categories'=>$model->neighbors,
            ),
        );

    }

    if(!$model->isNewRecord && $model->hasChildren==false) {
        $tabs['features']=array(
            'title'=>'Характеристики',
            'view'=>'_features',
            'data'=>array(
                'category'=>$model,
                'features'=>$model->features,
            ),
        );
        $tabs['filters']=array(
            'title'=>'Фильтры',
            'view'=>'_filters',
            'data'=>array(
                'category'=>$model,
                'filters'=>$model->filters,
            ),
        );
    }

    $this->widget('CTabView', array(
        'tabs'=>$tabs
    ));
    ?>

<?php $this->endWidget(); ?>

</div><!-- form -->