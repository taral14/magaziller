<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

	<div class="row">
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'pack_id'); ?>
        <?php echo $form->dropDownList($model, 'pack_id', CHtml::listData(FeaturePack::model()->findAll(), 'id', 'name'), array('empty'=>'')); ?>
	</div>

    <div class="row">
		<?php echo $form->label($model, 'category_id'); ?>
        <div style="float: left;margin: 0.2em 0 0.5em;">
        <?php
        $this->widget('McDropdown',array(
            'model'=>$model,
            'attribute'=>'category_id',
            'data' => Category::model()->rooted()->findAll(),
            'options'=>array(
                'allowParentSelect'=>false,
            )
        ));
        ?>
        </div>
    </div>



	<div class="row">
		<?php echo $form->label($model,'status'); ?>
		<?php echo $form->dropDownList($model, 'status', Lookup::items('FeatureStatus'), array('empty'=>'')); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'type'); ?>
		<?php echo $form->dropDownList($model, 'type', Lookup::items('FeatureType'), array('empty'=>'')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Поиск', array('class'=>'search_button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->