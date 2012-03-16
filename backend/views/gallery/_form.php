<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'brand-form',
	'enableAjaxValidation'=>true,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data',
    ),
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>

<!------------------------------------  ОСНОВНЫЕ ------------------------------------>
<?php $this->beginClip('basic'); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
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
		<label>Превью</label>
		<?php echo $form->textField($model,'small_width',array('size'=>6,'maxlength'=>3)); ?> X
        <?php echo $form->textField($model,'small_height',array('size'=>6,'maxlength'=>3)); ?> пикселей
        <?php echo $form->error($model,'small_width'); ?>
        <?php echo $form->error($model,'small_height'); ?>
	</div>

	<div class="row">
		<label>Изображение</label>
		<?php echo $form->textField($model,'large_width',array('size'=>6,'maxlength'=>3)); ?> X
        <?php echo $form->textField($model,'large_height',array('size'=>6,'maxlength'=>3)); ?> пикселей
        <?php echo $form->error($model,'large_width'); ?>
        <?php echo $form->error($model,'large_height'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status',Lookup::items('GalleryStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>
<?php $this->endClip(); ?>
<!------------------------------------  ФОТОГРАФИИ ------------------------------------>
<?php $this->beginClip('images'); ?>

<?php if($model->hasImages): ?>
<?php $this->beginWidget('PrettyPhoto', array(
    'gallery'=>true
)); ?>
<?php foreach($model->images as $image): ?>
    <div class="view" style="width: 150px; margin: 2px; float: left;">
        <?php
        echo CHtml::link('Удалить Х', '#', array(
            'submit'=>array('galleryImage/delete', 'id'=>$image->id),
            'params'=>array('returnUrl'=>Yii::app()->request->requestUri.'#tab3'),
            'confirm'=>'Вы уверены, что хотите удалить изображение?',
        ));
        ?>
        <br>
        <a href="<?php echo $image->getImageUrl('large'); ?>">
            <img src="<?php echo $image->getImageUrl('thumb'); ?>">
        </a>
    </div>
<?php endforeach; ?>
<?php $this->endWidget(); ?>
<?php else: ?>
    У этого товара нету изображений
<?php endif; ?>

<b class="clearb"></b>
<?php
    $this->widget('CMultiFileUpload', array(
        'name'=>'GalleryImage[filename]',
        'accept'=>'jpg|gif',
    ));
?>

	<div class="row buttons">
		<?php echo  ?>
	</div>

<?php $this->endClip(); ?>


    <?php
    $tabs=array(
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
    );
    if($model->isNewRecord==false) {
        $tabs['tab3']=array(
            'title'=>'Изображения',
            'content'=>$this->clips['images'],
        );
    }
    $this->widget('CTabView', array(
        'tabs'=>$tabs
    ));
    ?>

<?php $this->endWidget(); ?>

</div><!-- form -->