<?php
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('jquery.ui');
$cs->registerScript('sortable-menu-item', "
$('#sortable-menu-item tbody').sortable({
    axis: 'y',
	containment:'parent',
	tolerance:'pointer',
    start: function(event, ui) {
        var width = [];
        $('#sortable-menu-item thead th').each(function(i){
            width[i] = $(this).width();
        });
        ui.helper.find('td').each(function(i){
            $(this).width(width[i]+1);
        });
    },
    handle:'.move'
});
$('#save-menu-item').click(function(){
    $.post('saveOrder', $('#sortable-menu-item tbody').sortable('serialize'), function(){
        displayMessage('Порядок сохранен', 'success');
    });
});
");
?>

<table id="sortable-menu-item">
    <thead>
    <tr>
        <th width="18"></th>
        <th>Название</th>
        <th>URL</th>
    </tr>
    </thead>
    <tbody>
<?php foreach($menuItems as $menuItem): ?>
    <tr id="MenuItem_id-<?php echo $menuItem->id; ?>">
        <td><img src="<?php echo $this->assetsUrl; ?>/images/move.png" alt="Переместить" width="16" height="16" class="move"></td>
        <td><?php echo $menuItem->name; ?></td>
        <td><?php echo $menuItem->url; ?></td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>

	<div class="row buttons">
		<?php echo CHtml::button('Сохранить порядок', array('id'=>'save-menu-item')); ?>
	</div>