<?php
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
    $.post('../filter/saveOrder', $('#sortable-filter tbody').sortable('serialize'), function(){
        displayMessage('Порядок сохранен', 'success');
    });
});
$('#sortable-filter .delete').live('click', function() {
    if(confirm('Вы уверены, что хотите удалить фильтр этой категории?')==false) return;
    var el=$(this).parent().parent();
    var id=el.attr('id').match(/Filter_id-([0-9]+)/)[1];
    $.get('../filter/delete', {id:id}, function(){
        displayMessage('Фильтр удален', 'success');
        el.remove();
        if($('#sortable-filter tbody tr').length==0) {
            $('#empty-filters').show();
        }
    });
    return false;
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
            <a title="Удалить" href="#" class="delete">
                <img src="<?php echo $this->assetsUrl; ?>/images/delete.png" alt="Удалить" width="16" height="16">
            </a>
        </td>
    </tr>
<?php endforeach; ?>
    <tr id="empty-filters" <?php if($category->hasFilters): ?>style="display: none;"<?php endif; ?>  >
        <td colspan="5"><strong>У этой категории нету фильтров</strong></td>
    </tr>

    </tbody>
</table>

<div class="row buttons">
    <?php echo CHtml::button('Сохранить порядок', array('id'=>'save-filter-position')); ?>
    | <?php echo CHtml::link('Добавить фильтр', array('filter/create', 'returnUrl'=>$this->createUrl('update', array('id'=>$category->id,'#'=>'filters')), 'Filter'=>array('category_id'=>$category->id))); ?>
</div>