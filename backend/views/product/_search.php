<div class="wide form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
)); ?>

    <?php echo $form->hiddenField($model,'status'); ?>
    <?php echo $form->hiddenField($model,'hit'); ?>
    <?php echo $form->hiddenField($model,'shopwindow'); ?>

	<div class="row">
		<?php echo $form->label($model,'id'); ?>
		<?php echo $form->textField($model,'id'); ?>
	</div>

    <div class="row">
		<?php echo $form->label($model,'category_id'); ?>
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
		<?php echo $form->label($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
	</div>

	<div class="row">
		<?php echo $form->label($model,'price'); ?>
        от
		<?php echo $form->textField($model,'price[from]',array('size'=>5,'maxlength'=>6)); ?>
        - до
        <?php echo $form->textField($model,'price[till]',array('size'=>5,'maxlength'=>6)); ?>
	</div>
<?php if(false){ ?>
	<div class="row">
		<?php echo $form->label($model,'category_id'); ?>
        <?php
        $this->widget('McDropdown',array(
            'model'=>$model,
            'attribute'=>'category_id',
            'data' => Category::model()->rooted()->findAll(),
            'options'=>array(
                'allowParentSelect'=>false,
            ),
        ));
        ?>
	</div>
<?php } ?>
	<div class="row">
		<?php echo $form->label($model,'brand_id'); ?>
		<?php echo $form->dropDownList($model,'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name'), array('empty'=>'')); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Поиск', array('class'=>'search_button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- search-form -->