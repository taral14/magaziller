<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'product-form',
	'enableAjaxValidation'=>true,
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data',
    ),
)); ?>

	<p class="note">Поля отмеченные <span class="required">*</span> обязательны для заполнения.</p>

	<?php echo $form->errorSummary($model); ?>
<!------------------------------------  ОСНОВНЫЕ ------------------------------------>
<?php $this->beginClip('basic'); ?>
<?php if(!$model->original_id): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'name'); ?>
		<?php echo $form->textField($model,'name',array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($model,'name'); ?>
	</div>
<?php endif; ?>
<?php if($model->hasVariations): ?>
    <div class="row">
        <?php echo $form->labelEx($model,'variation'); ?>
        <?php echo $form->textField($model,'variation',array('size'=>60,'maxlength'=>255)); ?>
        <?php echo $form->error($model,'variation'); ?>
    </div>
<?php endif; ?>
<?php if(!$model->original_id): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'category_id'); ?>
        <?php
        $this->widget('McDropdown',array(
            'model'=>$model,
            'attribute'=>'category_id',
            'data' => Category::model()->rooted()->findAll(),
            'options'=>array(
                'allowParentSelect'=>false,
                'select'=>'js:function(cid){
                    $.get("features", {category_id:cid}, function(html){
                        $("#feature-values-form").html(html);
                    });
                }',
            )
        ));
        ?>
		<?php echo $form->error($model,'category_id'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'brand_id'); ?>
		<?php echo $form->dropDownList($model,'brand_id', CHtml::listData(Brand::model()->findAll(), 'id', 'name'), array('empty'=>'Не заполнено')); ?>
		<?php echo $form->error($model,'brand_id'); ?>
	</div>
<?php endif; ?>
	<div class="row">
		<?php echo $form->labelEx($model,'price'); ?>
		<?php echo $form->textField($model,'price'); ?>
		<?php echo $form->error($model,'price'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'other_price'); ?>
		<?php echo $form->textField($model,'other_price'); ?>
		<?php echo $form->error($model,'other_price'); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'enterprise_1c_id'); ?>
        <?php echo $form->textField($model,'enterprise_1c_id'); ?>
        <?php echo $form->error($model,'enterprise_1c_id'); ?>
    </div>
<?php if(!$model->original_id): ?>
    <div class="row">
        <?php echo $form->labelEx($model,'unit'); ?>
        <?php echo $form->textField($model,'unit'); ?>
        <?php echo $form->error($model,'unit'); ?>
    </div>
<?php endif; ?>
	<div class="row">
        <?php
        if(!$model->isNewRecord && $model->image): ?>
        <?php $this->beginWidget('PrettyPhoto', array(
            'gallery'=>false
        )); ?>
        <a class="thumb-image" href="<?php echo $model->getImageUrl('large'); ?>" target="_blank">
            <?php echo CHtml::image($model->getImageUrl('thumb'));?>
        </a>
        <?php $this->endWidget(); ?>
        <?php else: ?>
        <div class="thumb-image">
            <?php echo CHtml::image($model->getImageUrl('thumb'));?>
        </div>
        <?php endif; ?>
		<?php echo $form->labelEx($model,'image'); ?>
		<?php echo $form->fileField($model,'image'); ?>
		<?php echo $form->error($model,'image'); ?>
	</div>
<?php if(!$model->original_id): ?>
	<div class="row">
		<?php echo $form->labelEx($model,'summary'); ?>
        <?php $this->widget('ElRTE', array(
            'model'=>$model,
            'attribute'=>'summary',
            'options' => array(
                'height' => '100',
            ),
        )); ?>
		<?php echo $form->error($model,'summary'); ?>
	</div>

	<div class="row">
		<?php echo $form->labelEx($model,'description'); ?>
        <?php $this->widget('ElRTE', array(
            'model'=>$model,
            'attribute'=>'description',
            'options' => array(
                'height' => '200',
            ),
        )); ?>
		<?php echo $form->error($model,'description'); ?>
	</div>
<?php endif; ?>
	<div class="row">
		<label><?php echo $model->getAttributeLabel('priority'); ?>: <span id="priority-value"><?php echo $model->priority; ?></span></label>
		<?php echo $form->hiddenField($model,'priority'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiSlider', array(
            'value'=>$model->priority,
            'options'=>array(
                'min'=>0,
                'max'=>50,
                'slide'=>"js:function(event, ui){ $('#Product_priority').val(ui.value); $('#priority-value').text(ui.value); }",
            ),
            'htmlOptions'=>array(
                'style'=>'width:300px;',
            ),
        )); ?>
		<?php echo $form->error($model,'priority'); ?>
	</div>
<?php if(!$model->original_id): ?>
	<div class="row">
        <?php echo $form->labelEx($model,'accessoryNames'); ?>
        <?php $this->widget('ProductAutoComplete', array(
            'model'=>$model,
            'attribute'=>'accessoryNames',
            'url'=>$this->createUrl('autoComplete', array('without'=>$model->id)),
            'options'=>array(
                'select'=>'js:function(event,ui){
                    var terms = this.value.split(/,\s*/);
					terms.pop();
					terms.push(ui.item.value);
					terms.push("");
					this.value = terms.join(", ");
					return false;
                }'
            ),
            'htmlOptions'=>array('size'=>100,'maxlength'=>255)
        )); ?>
	</div>

    <div class="row">
        <?php echo $form->labelEx($model,'generalProductNames'); ?>
        <?php $this->widget('ProductAutoComplete', array(
            'model'=>$model,
            'attribute'=>'generalProductNames',
            'url'=>$this->createUrl('autoComplete', array('without'=>$model->id)),
            'options'=>array(
                'select'=>'js:function(event,ui){
                    var terms = this.value.split(/,\s*/);
                    terms.pop();
                    terms.push(ui.item.value);
                    terms.push("");
                    this.value = terms.join(", ");
                    return false;
                }'
             ),
            'htmlOptions'=>array('size'=>100,'maxlength'=>255)
        )); ?>
    </div>

    <div class="row">
        <?php echo $form->labelEx($model,'promotionNames'); ?>
        <?php $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
            'model'=>$model,
            'attribute'=>'promotionNames',
            'sourceUrl'=>$this->createUrl('promotion/autoComplete'),
            'options'=>array(
                'select'=>'js:function(event,ui){
                    var terms = this.value.split(/,\s*/);
                    terms.pop();
                    terms.push(ui.item.value);
                    terms.push("");
                    this.value = terms.join(", ");
                    return false;
                }'
             ),
            'htmlOptions'=>array('size'=>100,'maxlength'=>255)
        )); ?>
    </div>
<?php endif; ?>
	<div class="row">
		<?php echo $form->labelEx($model,'status'); ?>
		<?php echo $form->dropDownList($model,'status', Lookup::items('ProductStatus')); ?>
		<?php echo $form->error($model,'status'); ?>
	</div>

	<div class="row">
        <?php echo $form->checkBox($model,'hit'); ?>
        <?php echo $form->label($model,'hit'); ?>
		<?php echo $form->error($model,'hit'); ?>
	</div>

	<div class="row">
        <?php echo $form->checkBox($model,'shopwindow'); ?>
        <?php echo $form->label($model,'shopwindow'); ?>
		<?php echo $form->error($model,'shopwindow'); ?>
	</div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>

<?php $this->endClip(); ?>
<!------------------------------------  ХАРАКТЕРИСТИКИ ------------------------------------>
<?php $this->beginClip('features'); ?>
    <div id="feature-values-form">
<?php if($model->category && count($model->category->features)): ?>

    <?php
        $features=$model->category->features;
        foreach($features as $i=>$feature):
        $name='Product['.$feature->attribute.']';
        if(!isset($features[$i-1]) || $features[$i-1]->pack_id!=$feature->pack_id):
    ?>

    <fieldset>
       <legend><?php echo $feature->pack->name; ?></legend>

    <?php endif; ?>

    <div class="row">
        <?php echo CHtml::label($feature->name, 'Product_'.$feature->attribute, array('required'=>$feature->required)) ?>
        <?php
        switch($feature->type) {
            case Feature::TYPE_BOOL:
                echo CHtml::openTag('label');
                echo $form->radioButton($model, $feature->attribute, array('value'=>$feature->trueValue, 'uncheckValue'=>null));
                echo $feature->trueValue;
                echo CHtml::closeTag('label');
                echo CHtml::openTag('label');
                echo $form->radioButton($model, $feature->attribute, array('value'=>$feature->falseValue, 'uncheckValue'=>null));
                echo $feature->falseValue;
                echo CHtml::closeTag('label');
                if(!$feature->required) {
                    echo CHtml::openTag('label');
                    echo $form->radioButton($model, $feature->attribute, array('value'=>'', 'uncheckValue'=>null));
                    echo 'Не заполнено';
                    echo CHtml::closeTag('label');
                }
            break;
            case Feature::TYPE_SELECT:
                echo $form->dropDownList($model, $feature->attribute, $feature->selectValues, array('empty'=>'','style'=>'width:370px;'));
            break;
            /*case Feature::TYPE_IMAGE:
            case Feature::TYPE_FILE:
                $this->widget('ElFinderInput', array(
                    'model'=>$model,
                    'attribute'=>$feature->attribute,
                ));
            break;*/
            default:
                echo $form->textField($model, $feature->attribute, array('size'=>60));
        }
        ?>
        <?php echo $feature->unit; ?>
    </div>

    <?php if(!isset($features[$i+1]) || $features[$i+1]->pack_id!=$feature->pack_id): ?>
    </fieldset>
    <?php endif; ?>

    <?php endforeach; ?>


<?php else: ?>
       Не найдено дополнительных характеристик.
<?php endif; ?>

    </div>

	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Добавить' : 'Сохранить', array('class'=>'save_button')); ?>
	</div>
<?php $this->endClip(); ?>

<?php
$tabs=array(
    'tab1'=>array(
        'title'=>'Основные',
        'content'=>$this->clips['basic'],
    ),
);
if(!$model->original_id) {
    $tabs['tab2']=array(
        'title'=>'Характеристики',
        'content'=>$this->clips['features'],
    );
    $tabs['tab4']=array(
        'title'=>'SEO',
        'view'=>'/seo/_form',
        'data'=>array(
            'model'=>$model,
            'form'=>$form,
            'submitText'=>$model->isNewRecord ? 'Добавить товар' : 'Сохранить'
        ),
    );
}
if($model->isNewRecord==false) {
    $tabs['tab3']=array(
        'title'=>'Изображения',
        'view'=>'_images',
        'data'=>array(
            'model'=>$model,
        ),
    );
    if(PriceList::model()->count()) {
        $tabs['tab5']=array(
            'title'=>'Прайсы',
            'view'=>'_price_lists',
            'data'=>array(
                'model'=>$model,
            ),
        );
    }
}
$this->widget('CTabView', array(
    'tabs'=>$tabs
));
?>

<?php $this->endWidget(); ?>

</div><!-- form -->