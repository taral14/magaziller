<?php
$this->breadcrumbs=array(
	'Товары'=>array('index'),
    $model->category->name=>array('index', 'Product[category_id]'=>$model->category->id),
	empty($model->name)?'#'.$model->id:$model->name
);

$this->menu=array(
	array('label'=>'Каталог товаров', 'url'=>array('index')),
	array('label'=>'Добавить товар', 'url'=>array('create')),
	array('label'=>'Удалить товар', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Вы уверены, что хотите удалить товар "'.$model->name.'"?')),
    array('label'=>'Добавить вариацию', 'url'=>'#', 'linkOptions'=>array(
        'submit'=>array('addVariation','id'=>$model->original_id?$model->original_id:$model->id),
        'confirm'=>'Вы уверены, что хотите добавить вариацию к товару "'.$model->name.'"?'
    )),
    array('label'=>'Создать копию', 'url'=>'#', 'linkOptions'=>array(
        'submit'=>array('copy','id'=>$model->id),
        'confirm'=>'Вы уверены, что хотите скопировать товар "'.$model->name.'"?'
    )),
    array(
        'label'=>'Просмотр',
        'url'=>Yii::app()->frontendUrlManager->createUrl('product/view', array('id'=>$model->id)),
        'linkOptions'=>array('target'=>'_blank'),
        'visible'=>$model->status!=Product::STATUS_DISABLED
    ),
    array('label'=>'Управление товарами', 'url'=>array('admin')),
);
?>

<h1>Товар "<?php echo empty($model->name)?'#'.$model->id:$model->name; ?>"

<?php if($model->hasVariations): ?>
    <select id="variation" name="variation" onchange="js:window.location=$(this).val();" style="max-width: 140px;">
        <?php foreach($model->variations as $variation): ?>
        <option value="<?php echo $variation->id; ?>" <?php if($variation->id==$model->id) echo 'selected="selected"'; ?>><?php echo $variation->variation?$variation->variation:'ID '.$variation->id; ?></option>
        <?php endforeach; ?>
    </select>
<?php endif; ?>

</h1>

<?php echo $this->renderPartial('_form', array(
    'model'=>$model,
)); ?>
