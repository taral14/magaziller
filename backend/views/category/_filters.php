<?php
$filterUrl=$this->createUrl('saveFilters', array('id'=>$category->id));
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery.ui');
$cs->registerScript('sortable-filter', "
$('#sortable-filter tbody').sortable({
    axis: 'y',
	containment:'parent',
	tolerance:'pointer',
    start: function(event, ui) {
        var width = [];
        $('#sortable-filter thead th').each(function(i){
            width[i] = $(this).width();
        });
        ui.helper.find('td').each(function(i){
            $(this).width(width[i]+1);
        });
    },
    handle:'.move'
});
$('#save-filter-position').live('click', function(){
    $.post('$filterUrl', $('#sortable-filter tbody').sortable('serialize'), function(){
        displayMessage('Порядок сохранен', 'success');
    });
});
");
?>

<table id="sortable-filter">
    <thead>
    <tr>
        <th width="18"></th>
        <th>Название</th>
        <th width="36"></th>
    </tr>
    </thead>
    <tbody>
<?php foreach($category->filters as $filter): ?>
    <tr id="Filter_id-<?php echo $filter->id; ?>">
        <td><img src="<?php echo $this->assetsUrl; ?>/images/move.png" alt="Переместить" width="16" height="16" class="move"></td>
        <td><?php echo $filter->name; ?></td>
        <td class="button-column">
            <a title="Редактировать" href="<?php echo Yii::app()->createUrl('filter/update', array('id'=>$filter->id, 'returnUrl'=>$this->createUrl('update', array('id'=>$category->id,'#'=>'filters')))); ?>" class="update">
                <img src="<?php echo $this->assetsUrl; ?>/images/update.png" alt="Удалить" width="16" height="16">
            </a>
        </td>
    </tr>
<?php endforeach; ?>
<?php if(!$category->hasFilters): ?>
    <tr>
        <td colspan="5"><strong>У этой категории нету фильтров</strong></td>
    </tr>
<?php endif; ?>
    </tbody>
</table>

<div class="row buttons">
    <?php echo CHtml::button('Сохранить порядок', array('id'=>'save-filter-position')); ?>
    | <?php echo CHtml::link('Добавить фильтр', array('filter/create', 'returnUrl'=>$this->createUrl('update', array('id'=>$category->id,'#'=>'filters')), 'Filter'=>array('categoryIds[]'=>$category->id))); ?>
</div>