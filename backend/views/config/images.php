<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'config-form',
	'enableAjaxValidation'=>true,
)); ?>

    <h2>Изображения</h2>

    <fieldset>
        <legend>Товар</legend>

        <div class="row">
       		<?php echo $form->labelEx($model,'product_image_small'); ?>
       		<?php echo $form->textField($model,'product_image_small_width',array('size'=>4,'maxlength'=>4)); ?> Х
            <?php echo $form->textField($model,'product_image_small_height',array('size'=>4,'maxlength'=>4)); ?>
       		<?php echo $form->error($model,'product_image_small_width'); ?>
            <?php echo $form->error($model,'product_image_small_height'); ?>
       	</div>

        <div class="row">
       		<?php echo $form->labelEx($model,'product_image_large'); ?>
       		<?php echo $form->textField($model,'product_image_large_width',array('size'=>4,'maxlength'=>4)); ?> Х
            <?php echo $form->textField($model,'product_image_large_height',array('size'=>4,'maxlength'=>4)); ?>
       		<?php echo $form->error($model,'product_image_large_width'); ?>
            <?php echo $form->error($model,'product_image_large_height'); ?>
       	</div>

    </fieldset>

    <fieldset>
        <legend>Бренд</legend>

        <div class="row">
       		<?php echo $form->labelEx($model,'brand_image_small'); ?>
       		<?php echo $form->textField($model,'brand_image_small_width',array('size'=>4,'maxlength'=>4)); ?> Х
            <?php echo $form->textField($model,'brand_image_small_height',array('size'=>4,'maxlength'=>4)); ?>
       		<?php echo $form->error($model,'brand_image_small_width'); ?>
            <?php echo $form->error($model,'brand_image_small_height'); ?>
       	</div>

        <div class="row">
       		<?php echo $form->labelEx($model,'brand_image_large'); ?>
       		<?php echo $form->textField($model,'brand_image_large_width',array('size'=>4,'maxlength'=>4)); ?> Х
            <?php echo $form->textField($model,'brand_image_large_height',array('size'=>4,'maxlength'=>4)); ?>
       		<?php echo $form->error($model,'brand_image_large_width'); ?>
            <?php echo $form->error($model,'brand_image_large_height'); ?>
       	</div>

    </fieldset>

    <fieldset>
        <legend>Категория</legend>

        <div class="row">
       		<?php echo $form->labelEx($model,'category_image_small'); ?>
       		<?php echo $form->textField($model,'category_image_small_width',array('size'=>4,'maxlength'=>4)); ?> Х
            <?php echo $form->textField($model,'category_image_small_height',array('size'=>4,'maxlength'=>4)); ?>
       		<?php echo $form->error($model,'category_image_small_width'); ?>
            <?php echo $form->error($model,'category_image_small_height'); ?>
       	</div>

        <div class="row">
       		<?php echo $form->labelEx($model,'category_image_large'); ?>
       		<?php echo $form->textField($model,'category_image_large_width',array('size'=>4,'maxlength'=>4)); ?> Х
            <?php echo $form->textField($model,'category_image_large_height',array('size'=>4,'maxlength'=>4)); ?>
       		<?php echo $form->error($model,'category_image_large_width'); ?>
            <?php echo $form->error($model,'category_image_large_height'); ?>
       	</div>

    </fieldset>

    <fieldset>
        <legend>Группа характеристик</legend>

        <div class="row">
       		<?php echo $form->labelEx($model,'feature_pack_image'); ?>
       		<?php echo $form->textField($model,'feature_pack_image_width',array('size'=>4,'maxlength'=>4)); ?> Х
            <?php echo $form->textField($model,'feature_pack_image_height',array('size'=>4,'maxlength'=>4)); ?>
       		<?php echo $form->error($model,'feature_pack_image_width'); ?>
            <?php echo $form->error($model,'feature_pack_image_height'); ?>
       	</div>

    </fieldset>

    <fieldset>
        <legend>Новость</legend>

        <div class="row">
       		<?php echo $form->labelEx($model,'news_image_small'); ?>
       		<?php echo $form->textField($model,'news_image_small_width',array('size'=>4,'maxlength'=>4)); ?> Х
            <?php echo $form->textField($model,'news_image_small_height',array('size'=>4,'maxlength'=>4)); ?>
       		<?php echo $form->error($model,'news_image_small_width'); ?>
            <?php echo $form->error($model,'news_image_small_height'); ?>
       	</div>

        <div class="row">
       		<?php echo $form->labelEx($model,'news_image_large'); ?>
       		<?php echo $form->textField($model,'news_image_large_width',array('size'=>4,'maxlength'=>4)); ?> Х
            <?php echo $form->textField($model,'news_image_large_height',array('size'=>4,'maxlength'=>4)); ?>
       		<?php echo $form->error($model,'news_image_large_width'); ?>
            <?php echo $form->error($model,'news_image_large_height'); ?>
       	</div>

    </fieldset>

    <fieldset>
        <legend>Акция</legend>

        <div class="row">
       		<?php echo $form->labelEx($model,'promotion_image_small'); ?>
       		<?php echo $form->textField($model,'promotion_image_small_width',array('size'=>4,'maxlength'=>4)); ?> Х
            <?php echo $form->textField($model,'promotion_image_small_height',array('size'=>4,'maxlength'=>4)); ?>
       		<?php echo $form->error($model,'promotion_image_small_width'); ?>
            <?php echo $form->error($model,'promotion_image_small_height'); ?>
       	</div>

        <div class="row">
       		<?php echo $form->labelEx($model,'promotion_image_large'); ?>
       		<?php echo $form->textField($model,'promotion_image_large_width',array('size'=>4,'maxlength'=>4)); ?> Х
            <?php echo $form->textField($model,'promotion_image_large_height',array('size'=>4,'maxlength'=>4)); ?>
       		<?php echo $form->error($model,'promotion_image_large_width'); ?>
            <?php echo $form->error($model,'promotion_image_large_height'); ?>
       	</div>

    </fieldset>

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить', array('class'=>'save_button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
