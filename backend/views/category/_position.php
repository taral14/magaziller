<?php
$orderUrl=$this->createUrl('saveOrder');
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('jquery.ui');
$cs->registerScript('sortable-category', "
$('#sortable-category tbody').sortable({
    axis: 'y',
	containment:'parent',
	tolerance:'pointer',
    start: function(event, ui) {
        var width = [];
        $('#sortable-category thead th').each(function(i){
            width[i] = $(this).width();
        });
        ui.helper.find('td').each(function(i){
            $(this).width(width[i]+1);
        });
    },
    handle:'.move'
});
$('#save-category').click(function(){
    $.post('$orderUrl', $('#sortable-category tbody').sortable('serialize'), function(){
        displayMessage('Порядок сохранен', 'success');
    });
});
");
?>

<table id="sortable-category">
    <thead>
    <tr>
        <th width="18"></th>
        <th>Название</th>
    </tr>
    </thead>
    <tbody>
<?php foreach($categories as $category): ?>
    <tr id="Category_id-<?php echo $category->id; ?>">
        <td><img src="<?php echo $this->assetsUrl; ?>/images/move.png" alt="Переместить" width="16" height="16" class="move"></td>
        <td><?php echo $category->name; ?></td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>

<div class="row buttons">
    <?php echo CHtml::button('Сохранить порядок', array('id'=>'save-category')); ?>
</div>