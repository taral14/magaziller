<?php
    Yii::app()->clientScript->registerScript('use_image', "
        $('#Scrap_use_image').change(function(){
            if($(this).is(':checked'))
                $('div.image-params').show();
            else
                $('div.image-params').hide();
        }).change();
    ");

    $deleteUrl=Yii::app()->createUrl('scrapTemplate/delete');
    Yii::app()->clientScript->registerScript('delete-template', "
        $('#templates-table .delete').click(function() {
            if(confirm('Вы уверены, что хотите удалить шаблон этого елемента страницы?')==false) return;
            var el=$(this).parent().parent();
            var id=el.attr('id').match(/Template_id-([0-9])+/)[1];
            $.get('$deleteUrl', {id:id,ajax:true}, function(){
                displayMessage('Шаблон удален', 'success');
                el.remove();
            });
            return false;
        });
    ");
?>
<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'scrap-form',
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
   		<?php echo $form->labelEx($model,'route'); ?>
   		<?php echo $form->textField($model,'route',array('size'=>60,'maxlength'=>255)); ?>
   		<?php echo $form->error($model,'route'); ?>
   	</div>

	<div class="row">
		<label><?php echo $model->getAttributeLabel('limit_items'); ?>: <span id="limit-items-value"><?php echo $model->limit_items; ?></span></label>
		<?php echo $form->hiddenField($model,'limit_items'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiSlider', array(
            'value'=>$model->limit_items,
            'options'=>array(
                'min'=>1,
                'max'=>30,
                'slide'=>"js:function(event, ui){ $('#Scrap_limit_items').val(ui.value); $('#limit-items-value').text(ui.value); }",
            ),
            'htmlOptions'=>array(
                'style'=>'width:300px;',
            ),
        )); ?>
		<?php echo $form->error($model,'limit_items'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>
<?php $this->endClip(); ?>
<?php $this->beginClip('templates'); ?>

    <table id="templates-table">
        <col />
        <col width="56">
        <thead>
        <tr>
            <th>Название</th>
            <th></th>
        </tr>
        </thead>
        <tbody>
    <?php foreach($model->templates as $template): ?>

    <tr id="Template_id-<?php echo $template->id; ?>">
        <td><?php echo $template->name; ?></td>
        <td>
            <a title="Редактировать" href="<?php echo Yii::app()->createUrl('scrapTemplate/update', array('id'=>$template->id, 'returnUrl'=>$this->createUrl('update', array('id'=>$model->id,'#'=>'templates')))); ?>"><img src="<?php echo $this->assetsUrl; ?>/images/update.png" alt="Редактировать" width="16" height="16"></a>
            <a title="Удалить" href="#" class="delete"><img src="<?php echo $this->assetsUrl; ?>/images/delete.png" alt="Удалить" width="16" height="16"></a>
        </td>
    </tr>

    <?php endforeach; ?>
        </tbody>
    </table>

    <?php echo CHtml::link('Добавить шаблон', array('scrapTemplate/create', 'scrap_id'=>$model->id, 'returnUrl'=>$this->createUrl('update', array('id'=>$model->id,'#'=>'templates')))); ?>

<?php $this->endClip(); ?>


    <?php
    $tabs['basic']=array(
        'title'=>'Основные',
        'content'=>$this->clips['basic']
    );
    if(!$model->isNewRecord) {
        $tabs['templates']=array(
            'title'=>'Шаблоны',
            'content'=>$this->clips['templates']
        );
    }
    $this->widget('CTabView', array('tabs'=>$tabs));
    ?>

<?php $this->endWidget(); ?>

</div><!-- form -->