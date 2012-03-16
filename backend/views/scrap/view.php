<?php
$this->breadcrumbs=array(
	'Элементы страниц'=>array('index'),
	$model->name,
);

$this->menu=array(
	array('label'=>'Каталог', 'url'=>array('index')),
	array('label'=>'Добавить', 'url'=>array('create')),
    array('label'=>'Редактировать', 'url'=>array('update', 'id'=>$model->id)),
);
?>

<h1>Элемент страницы "<?php echo $model->name; ?>"</h1>

<?php if($model->hasTemplates==false) :?>
    <p>Что бы продолжить нужно <a href="<?php echo Yii::app()->createUrl('scrapTemplate/create', array('scrap_id'=>$model->id)); ?>">добавить</a> хотя бы 1 шаблон для элементов слайдера.</p>
<?php else: ?>
<div class="form">
<?php $form=$this->beginWidget('CActiveForm', array(
    'htmlOptions'=>array(
        'enctype'=>'multipart/form-data',
    ),
)); ?>

<?php foreach($items as $i=>$item): ?>

<div class="view">

	<div class="template" <?php if($model->countTemplates<2) echo 'style="display:none;"'?>>
		<?php echo $form->labelEx($item,"[$i]template_id"); ?>
        <?php echo $form->dropDownList($item, "[$i]template_id", $model->getTemplatesList(), array('class'=>'form-template')); ?>
		<?php echo $form->error($item,"template_id"); ?>
	</div>

	<div class="row title">
		<?php echo $form->labelEx($item,"[$i]title"); ?>
        <?php echo $form->textField($item, "[$i]title", array('size'=>60,'maxlength'=>255)); ?>
		<?php echo $form->error($item,"title"); ?>
	</div>

    <div class="row url">
   		<?php echo $form->labelEx($item,"[$i]url"); ?>
           <?php echo $form->textField($item, "[$i]url", array('size'=>60,'maxlength'=>255)); ?>
   		<?php echo $form->error($item,"url"); ?>
   	</div>

	<div class="row image">
        <?php
        if(!$item->isNewRecord && $item->image): ?>
        <?php $this->beginWidget('PrettyPhoto', array(
            'gallery'=>false
        )); ?>
        <a class="thumb-image" href="<?php echo $item->getImageUrl(); ?>" target="_blank">
            <?php echo CHtml::image($item->getImageUrl('thumb'));?>
        </a>
        <?php $this->endWidget(); ?>
        <?php else: ?>
        <div class="thumb-image">
            <?php echo CHtml::image($item->getImageUrl('thumb'));?>
        </div>
        <?php endif; ?>
		<?php echo $form->labelEx($item,"[$i]image"); ?>
		<?php echo $form->fileField($item,"[$i]image"); ?>
		<?php echo $form->error($item,"image"); ?>
	</div>

	<div class="row product">
		<?php echo $form->labelEx($item,"[$i]product_id"); ?>
        <?php echo $form->hiddenField($item, "[$i]product_id"); ?>
            <?php
            $this->widget('ProductAutoComplete', array(
                'name'=>"Product[$i][name]",
                'value'=>$item->product?$item->product->name:'',
                'url'=>$this->createUrl('product/autoComplete'),
                'options'=>array(
                    'change'=>"js:function(event,ui){ $('#ScrapItem_{$i}_product_id').val((ui.item)?ui.item.id:''); }"
                ),
                'htmlOptions'=>array('size'=>60)
            ));
            ?>
		<?php echo $form->error($item,"product_id"); ?>
	</div>

	<div class="row news">
		<?php echo $form->labelEx($item,"[$i]news_id"); ?>
        <?php echo $form->hiddenField($item, "[$i]news_id"); ?>
            <?php
            $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                'name'=>"News[$i][title]",
                'value'=>$item->news?$item->news->title:'',
                'sourceUrl'=>$this->createUrl('news/autoComplete'),
                'options'=>array(
                    'change'=>"js:function(event,ui){ $('#ScrapItem_{$i}_news_id').val((ui.item)?ui.item.id:''); }"
                ),
                'htmlOptions'=>array('size'=>60)
            ));
            ?>
		<?php echo $form->error($item,"news_id"); ?>
	</div>

    <div class="row brand">
   		<?php echo $form->labelEx($item,"[$i]brand_id"); ?>
           <?php echo $form->hiddenField($item, "[$i]brand_id"); ?>
               <?php
               $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                   'name'=>"Brand[$i][name]",
                   'value'=>$item->brand?$item->brand->name:'',
                   'sourceUrl'=>$this->createUrl('brand/autoComplete'),
                   'options'=>array(
                       'change'=>"js:function(event,ui){ $('#ScrapItem_{$i}_brand_id').val((ui.item)?ui.item.id:''); }"
                   ),
                   'htmlOptions'=>array('size'=>60)
               ));
               ?>
   		<?php echo $form->error($item,"brand_id"); ?>
   	</div>

    <div class="row category">
   		<?php echo $form->labelEx($item,"[$i]category_id"); ?>
           <?php echo $form->hiddenField($item, "[$i]category_id"); ?>
               <?php
               $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                   'name'=>"Category[$i][name]",
                   'value'=>$item->category?$item->category->name:'',
                   'sourceUrl'=>$this->createUrl('category/autoComplete'),
                   'options'=>array(
                       'change'=>"js:function(event,ui){ $('#ScrapItem_{$i}_category_id').val((ui.item)?ui.item.id:''); }"
                   ),
                   'htmlOptions'=>array('size'=>60)
               ));
               ?>
   		<?php echo $form->error($item,"category_id"); ?>
   	</div>

    <div class="row promotion">
   		<?php echo $form->labelEx($item,"[$i]promotion_id"); ?>
           <?php echo $form->hiddenField($item, "[$i]promotion_id"); ?>
               <?php
               $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
                   'name'=>"Promotion[$i][title]",
                   'value'=>$item->promotion?$item->promotion->title:'',
                   'sourceUrl'=>$this->createUrl('promotion/autoComplete'),
                   'options'=>array(
                       'change'=>"js:function(event,ui){ $('#ScrapItem_{$i}_promotion_id').val((ui.item)?ui.item.id:''); }"
                   ),
                   'htmlOptions'=>array('size'=>60)
               ));
               ?>
   		<?php echo $form->error($item,"promotion_id"); ?>
   	</div>


	<div class="row content">
		<?php echo $form->labelEx($item,"[$i]content"); ?>
        <?php $this->widget('ElRTE', array(
            'model'=>$item,
            'attribute'=>"[$i]content",
            'options' => array(
                'height' => '100',
            ),
        ));?>
		<?php echo CHtml::error($item,"content"); ?>
	</div>

</div>

<?php endforeach; ?>

<div class="row buttons">
    <?php echo CHtml::submitButton('Сохранить', array('class'=>'save_button')); ?>
</div>

<?php
$has=array();
foreach($model->templates as $template)
    $has[$template->id]=$template->getHasList();

Yii::app()->clientScript->registerScript('form-template', "
    $('.form-template').change(function(){
        var row=$(this).parent().parent();
        var has=".CJavaScript::encode($has).";
        row.find('.row').hide();

        if($(this).find('option').length>1)
            $(this).show();

        $.each(has[$(this).val()], function(key, val){
            row.find('.'+val).show();
        });
    }).change();
");
?>

<?php $this->endWidget(); ?>
</div>
<?php endif; ?>