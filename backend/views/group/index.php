<?php
$this->breadcrumbs=array(
	'Группы',
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

<h1>Группы</h1>

<?php $i=1; foreach($letters as $letter=>$groups): ?>
    <div class="brand-box">
        <strong><?php echo $letter; ?></strong><br>
        <?php $links=array(); foreach($groups as $group) $links[]=CHtml::link($group->name, array('update', 'id'=>$group->id)); echo implode(' | ', $links); ?>
    </div>
    <?php if($i%3==0) echo '<b class="clearb"></b>'; ?>
<?php $i++; endforeach; ?>