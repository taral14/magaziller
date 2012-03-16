<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'config-form',
	'enableAjaxValidation'=>true,
)); ?>

    <h2>Контент</h2>

    <fieldset>
       <legend>Товары</legend>

    <div class="row">
   		<?php echo $form->labelEx($model,'price_accuracy'); ?>
        <?php echo $form->dropDownList($model,'price_accuracy', array('Целое число', '1 цифра после запятой','2 цифры после запятой','3 цифры после запятой')); ?>
   		<?php echo $form->error($model,'price_accuracy'); ?>
   	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'product_show_absent'); ?>
        <?php echo $form->dropDownList($model,'product_show_absent', array('Не показывать', 'Показывать')); ?>
   		<?php echo $form->error($model,'product_show_absent'); ?>
   	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'product_catalog_limit'); ?>
   		<?php echo $form->textField($model,'product_catalog_limit',array('size'=>3,'maxlength'=>3)); ?>
   		<?php echo $form->error($model,'product_catalog_limit'); ?>
   	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'product_catalog_order'); ?>
        <?php echo $form->dropDownList($model,'product_catalog_order', array(
            'price'=>'Дешевые сначала',
            'price DESC'=>'Дорогие сначала',
            'name'=>'По названию',
            'hit DESC'=>'Спец предложения сначала',
            'browse DESC'=>'Популярные сначала',
        )); ?>
   		<?php echo $form->error($model,'product_catalog_order'); ?>
   	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'similar_price_accuracy'); ?>
        <?php echo $form->dropDownList($model,'similar_price_accuracy', array(
            '0.01'=>'Разница в цене 1%',
            '0.02'=>'Разница в цене 2%',
            '0.03'=>'Разница в цене 3%',
            '0.05'=>'Разница в цене 5%',
            '0.1'=>'Разница в цене 10%',
            '0.15'=>'Разница в цене 15%',
            '0.2'=>'Разница в цене 20%',
            '0.3'=>'Разница в цене 30%',
        )); ?>
   		<?php echo $form->error($model,'similar_price_accuracy'); ?>
   	</div>

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
       <legend>Поиск</legend>

    <div class="row">
   		<?php echo $form->labelEx($model,'product_search_limit'); ?>
   		<?php echo $form->textField($model,'product_search_limit',array('size'=>3,'maxlength'=>3)); ?>
   		<?php echo $form->error($model,'product_search_limit'); ?>
   	</div>

    <div class="row">
   		<?php echo $form->labelEx($model,'product_search_order'); ?>
        <?php echo $form->dropDownList($model,'product_search_order', array(
            'price'=>'Дешевые сначала',
            'price DESC'=>'Дорогие сначала',
            'name'=>'По названию',
            'hit DESC'=>'Спец предложения сначала',
            'browse DESC'=>'Популярные сначала',
        )); ?>
   		<?php echo $form->error($model,'product_search_order'); ?>
   	</div>

    </fieldset>

    <fieldset>
       <legend>Новости</legend>

    <div class="row">
   		<?php echo $form->labelEx($model,'news_catalog_limit'); ?>
   		<?php echo $form->textField($model,'news_catalog_limit',array('size'=>3,'maxlength'=>3)); ?>
   		<?php echo $form->error($model,'news_catalog_limit'); ?>
   	</div>

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

	<div class="row buttons">
		<?php echo CHtml::submitButton('Сохранить', array('class'=>'save_button')); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->