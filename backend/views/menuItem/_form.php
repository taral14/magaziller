<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'menu-item-form',
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

<?php $this->beginClip('basic'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'parent_id'); ?>
        <?php
        $this->widget('McDropdown',array(
            'model'=>$model,
            'attribute'=>'parent_id',
            'data' => MenuItem::model()->rooted()->findAll(),
            'without'=>$model->id,
            'options'=>array(
                'select'=>'js:function(id){
                    $.get("'.$this->createUrl('position').'", {
                        id:id
                    }, function(html){
                        $("#tab2").html(html);
                    });
                }'
            )
        ));
        ?>
		<?php echo $form->error($model,'parent_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'uri'); ?>
		<?php echo $form->textField($model,'uri',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'uri'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>

<?php $this->endClip(); ?>

    <?php
    $tabs['tab1']=array(
        'title'=>'Основные',
        'content'=>$this->clips['basic'],
    );
    if(!$model->isNewRecord && count($model->neighbors)>1) {
        $tabs['tab2']=array(
            'title'=>'Настроить порядок',
            'view'=>'_position',
            'data'=>array(
                'model'=>$model,
                'menuItems'=>$model->neighbors
            ),
        );
    }

    $this->widget('CTabView', array(
        'tabs'=>$tabs,
    ));
    ?>

<?php $this->endWidget(); ?>

</div><!-- form -->