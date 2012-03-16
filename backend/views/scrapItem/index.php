<?php
$this->breadcrumbs=array(
	'Элементы страниц'=>array('scrap/index'),
	$scrap->name=>array('scrap/view', 'id'=>$scrap->id),
    'Шаблоны'
);

$this->menu=array(
    array('label'=>'Элементы страницы', 'url'=>array('view', 'id'=>$scrap->id)),
    array('label'=>'Добавить шаблон', 'url'=>array('create', 'scrap_id'=>$scrap->id)),
);
?>

<h1>Шаблоны элемента страницы "<?php echo $scrap->name; ?>"</h1>

<?php foreach($scrap->items as $item): ?>

<div class="view">

	<b>
	    <?php echo $template->name; ?>
    </b>

    <b class="clearb"></b>

    &nbsp;

    <div class="management">
        <?php echo CHtml::link('Подробнее', array('update', 'id'=>$template->id)); ?>
    </div>

</div>

<?php endforeach; ?>