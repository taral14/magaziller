<?php
$this->breadcrumbs=array(
	'Бренды',
);

$this->menu=array(
	array('label'=>'Добавить бренд', 'url'=>array('create')),
);
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiListView.update('brand-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Бренды</h1>

<?php foreach($letters as $letter=>$brands): ?>
    <div class="brand-box">
        <strong><?php echo $letter; ?></strong><br>
        <?php $links=array(); foreach($brands as $brand) $links[]=CHtml::link($brand->name, array('update', 'id'=>$brand->id)); echo implode(' | ', $links); ?>
    </div>
<?php endforeach; ?>
