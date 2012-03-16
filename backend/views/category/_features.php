<?php
$featuresUrl=$this->createUrl('saveFeatures', array('id'=>$category->id));
$deleteUrl=$this->createUrl('feature/unbind', array('ajax'=>true, 'category_id'=>$category->id));
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery');
$cs->registerCoreScript('jquery.ui');
$cs->registerScript('sortable-feature', "
$('#sortable-feature tbody').sortable({
    axis: 'y',
	containment:'parent',
	tolerance:'pointer',
    start: function(event, ui) {
        var width = [];
        $('#sortable-feature thead th').each(function(i){
            width[i] = $(this).width();
        });
        ui.helper.find('td').each(function(i){
            $(this).width(width[i]+1);
        });
    },
    handle:'.move'
});
$('#save-feature').click(function() {
    var data=$('#sortable-feature tbody').sortable('serialize')+'&'+$('#sortable-feature input').serialize();
    $.post('$featuresUrl', data, function(){
        displayMessage('Характеристики сохранены', 'success');
    });
});
");
?>

<table id="sortable-feature">
    <thead>
    <tr>
        <th width="18"></th>
        <th>Группа</th>
        <th>Название</th>
        <th width="60">Видимость</th>
    </tr>
    </thead>
    <tbody>
<?php foreach($features as $i=>$feature): ?>
    <tr id="Feature_id-<?php echo $feature->id; ?>">
        <td><img src="<?php echo $this->assetsUrl; ?>/images/move.png" alt="Переместить" width="16" height="16" class="move"></td>
        <td><?php echo $feature->pack->name; ?></td>
        <td><?php echo $feature->name; ?></td>
        <td>
            <?php echo CHtml::checkBox("Feature[$feature->id][in_detail]", $category->isFeatureEnabled($feature, Feature::IN_DETAIL), array('title'=>'В детальном', 'uncheckValue'=>null)) ?>
            <?php echo CHtml::checkBox("Feature[$feature->id][in_summary]", $category->isFeatureEnabled($feature, Feature::IN_SUMMARY), array('title'=>'В кратком', 'uncheckValue'=>null)) ?>
            <?php echo CHtml::checkBox("Feature[$feature->id][in_compare]", $category->isFeatureEnabled($feature, Feature::IN_COMPARE), array('title'=>'В сравнении', 'uncheckValue'=>null)) ?>
        </td>
    </tr>
<?php endforeach; ?>
    </tbody>
</table>

	<div class="row buttons">
		<?php echo CHtml::button('Сохранить характеристики', array('id'=>'save-feature')); ?> | <?php echo CHtml::link('Добавить характеристику', array('feature/create', 'returnUrl'=>$this->createUrl('update', array('id'=>$category->id,'#'=>'features')), 'Feature'=>array('categoryIds'=>array($category->id)))); ?>
	</div>