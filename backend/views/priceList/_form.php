<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'price-list-form',
	'enableAjaxValidation'=>true,
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

<?php $this->beginClip('basic'); ?>

	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'currency_id'); ?>
        <?php echo $form->dropDownList($model,'currency_id', CHtml::listData(Currency::model()->findAll(), 'id', 'name')); ?>
		<?php echo $form->error($model,'currency_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'availability_true'); ?>
		<?php echo $form->textField($model,'availability_true',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'availability_true'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'availability_false'); ?>
		<?php echo $form->textField($model,'availability_false',array('size'=>45,'maxlength'=>45)); ?>
		<?php echo $form->error($model,'availability_false'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
		<?php echo $form->textArea($model,'description',array('rows'=>6, 'cols'=>50)); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('PriceListStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>

<?php $this->endClip(); ?>

<?php $this->beginClip('columns'); ?>

<table style="width:675px;">
    <thead>
        <tr>
            <?php for($n=0; $n<7; $n++): ?>
            <th>
                <?php echo CHtml::dropDownList("PriceList[columns][$n]", $model->getColumn($n), Lookup::items('PriceListColumn'), array('style'=>'width:100%','empty'=>'')); ?>
            </th>
            <?php endfor; ?>
        </tr>
    </thead>
</table>
<div id="test-result" style="max-height: 350px; overflow:auto;"></div>
<?php $this->widget('Uplodify', array(
	'name'=>'file',
	'uploadUrl'=>$this->createUrl('testUpload'),
	'options'=>array(
		'onUploadSuccess'=>'js:function(event, data){ $("#test-result").html(data); }',
		'fileTypeExts'=>'*.csv;*.xls;',
		'fileTypeDesc'=>'Прайс-лист',
	)
)); ?>

<?php $this->endClip(); ?>

<?php $this->beginClip('rows'); ?>

<table style="width:675px;">
    <thead>
        <tr>
            <th>Артикул</th>
            <th width="200">Товар</th>
            <th width="80">Цена</th>
            <th width="60">Склад</th>
            <th width="20"></th>
        </tr>
    </thead>
</table>
<div id="rows-result" style="max-height:350px; overflow:auto;">
<?php $this->renderPartial('_rows', array('model'=>$model)); ?>
</div>
<?php $this->widget('Uplodify', array(
	'name'=>'file',
	'uploadUrl'=>$this->createUrl('upload', array('id'=>$model->id)),
	'options'=>array(
		'onUploadSuccess'=>'js:function(event, data){ console.debug(data); $("#rows-result").html(data); }',
		'fileTypeExts'=>'*.csv;*.xls;',
		'fileTypeDesc'=>'Прайс-лист',
	)
)); ?>

<?php $this->endClip(); ?>

<?php
    $tabs=array(
        'tab1'=>array(
            'title'=>'Основные',
            'content'=>$this->clips['basic'],
        ),
        'tab2'=>array(
            'title'=>'Порядок колонок',
            'content'=>$this->clips['columns'],
        ),
    );
    if(!$model->isNewRecord) {
        $tabs['tab3']=array(
            'title'=>'Прайс',
            'content'=>$this->clips['rows'],
        );
    }
    $this->widget('CTabView', array(
        'tabs'=>$tabs,
    ));
?>

<?php $this->endWidget(); ?>

</div><!-- form -->