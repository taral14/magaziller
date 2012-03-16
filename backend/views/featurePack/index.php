<?php
$this->breadcrumbs=array(
	'Группы характеристик',
);

$this->menu=array(
	array('label'=>'Добавить группу', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiListView.update('user-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Группы характеристик</h1>

<?php $i=1; foreach($letters as $letter=>$parameters): ?>
    <div class="brand-box">
        <strong><?php echo $letter; ?></strong><br>
        <?php $links=array(); foreach($parameters as $parameter) $links[]=CHtml::link($parameter->name, array('update', 'id'=>$parameter->id)); echo implode(' | ', $links); ?>
    </div>
    <?php if($i%3==0) echo '<b class="clearb"></b>'; ?>
<?php $i++; endforeach; ?>
