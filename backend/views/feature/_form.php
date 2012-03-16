<?php
    Yii::app()->clientScript->registerScript('feature_type', "
        $('#Feature_type').change(function(){
            if($(this).val()==".Feature::TYPE_SELECT." || $(this).val()==".Feature::TYPE_BOOL.")
                $('.alowed_values').show();
            else
                $('.alowed_values').hide();
        }).change();
    ");

    if($model->isNewRecord===false) {
        Yii::app()->clientScript->registerScript('load_alowed_values', "
            $('#load-alowed-values').click(function(){
                if($('#Feature_alowed_values').val()!='' && !confirm('Введенные значения заменятся. Продолжить?')) {
                    return false;
                }
                $.getJSON('loadAlowedValues', {id:".CJavaScript::encode($model->id)."}, function(values){
                    $('#Feature_alowed_values').val(values.join(\"\\n\"));
                });
                return false;
            })
        ");
    }
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'feature-form',
	'enableAjaxValidation'=>true,
));?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

<?php $this->beginClip('basic'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
        <?php echo $form->checkBox($model,'hide_name'); ?>
        <?php echo $form->label($model,'hide_name'); ?>
		<?php echo $form->error($model,'hide_name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'pack_id'); ?>
        <?php echo $form->dropDownList($model, 'pack_id', CHtml::listData(FeaturePack::model()->findAll(), 'id', 'name'), array('empty'=>'')); ?>
		<?php echo $form->error($model,'pack_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'unit'); ?>
		<?php echo $form->textField($model,'unit',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'unit'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'type'); ?>
        <?php echo $form->dropDownList($model, 'type', Lookup::items('FeatureType')) ?>
		<?php echo $form->error($model,'type'); ?>
	</div>

	<div class="row alowed_values">

        <?php if($model->isNewRecord): ?>
            <?php echo $form->labelEx($model,'alowed_values'); ?>
        <?php else: ?>
            <?php echo $form->labelEx($model,'alowed_values', array('style'=>'float:left;')); ?>
            &nbsp;(<a id="load-alowed-values" href="#">загрузить значения с товаров</a>)
        <?php endif; ?>
		<?php echo $form->textArea($model,'alowed_values',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'alowed_values'); ?>
	</div>

	<div class="row">
        <?php echo $form->checkBox($model,'unique'); ?>
        <?php echo $form->label($model,'unique'); ?>
		<?php echo $form->error($model,'unique'); ?>
	</div>

	<div class="row">
        <?php echo $form->checkBox($model,'required'); ?>
        <?php echo $form->label($model,'required'); ?>
		<?php echo $form->error($model,'required'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model, 'status', Lookup::items('FeatureStatus')) ?>
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

    <?php
    $this->widget('CTabView', array(
        'tabs'=>array(
            'tab1'=>array(
                'title'=>'Основные',
                'content'=>$this->clips['basic'],
            ),
            'tab2'=>array(
                'title'=>'Использовать в категориях',
                'content'=>$this->clips['categories'],
            ),
        )
    ));
    ?>

<?php $this->endWidget(); ?>

</div><!-- form -->