<?php
$imagesUrl=$this->createUrl('saveImage', array('ajax'=>true));
$deleteUrl=$this->createUrl('deleteImage', array('ajax'=>true));
$cs=Yii::app()->clientScript;
$cs->registerCoreScript('jquery.ui');
$cs->registerScript('sortable-images', "
$('#sortable-images tbody').sortable({
    axis: 'y',
	containment:'parent',
	tolerance:'pointer',
    start: function(event, ui) {
        var width = [];
        $('#sortable-images thead th').each(function(i){
            width[i] = $(this).width();
        });
        ui.helper.find('td').each(function(i){
            $(this).width(width[i]+1);
        });
    },
    handle:'.move'
});
$('#save-images').click(function() {
    var data=$('#sortable-images tbody').sortable('serialize')+'&'+$('#sortable-images textarea').serialize();
    $.post('$imagesUrl', data, function(){
        displayMessage('Изображения сохранены', 'success');
    });
});
$('#sortable-images .delete').live('click', function() {
    if(confirm('Вы уверены, что хотите удалить изображение?')==false) return;
    var image=$(this).parent().parent();
    var id=image.attr('id').match(/Image_id-([0-9]+)/)[1];
    $.get('$deleteUrl', {image_id:id}, function(){
        displayMessage('Изображение удалено', 'success');
        image.remove();
        if($('#sortable-images tbody tr').length==1) {
            $('#empty-images').show();
        }
    });
});
");
?>

<table id="sortable-images">
    <thead>
    <tr>
        <th width="16"></th>
        <th width="100">Изображение</th>
        <th>Описание</th>
        <th width="18"></th>
    </tr>
    </thead>
    <tbody>

        <tr id="empty-images" <?php if($model->hasImages): ?>style="display: none;"<?php endif; ?> >
            <td colspan="4">У этого товара нету изображений</td>
        </tr>

        <?php foreach($model->images as $image): ?>
            <?php $this->renderPartial('_image_view', array('model'=>$image)); ?>
        <?php endforeach; ?>
    </tbody>
</table>

<b class="clearb"></b>

<div class="row buttons">
    <table>
        <tr>
            <td width="90" valign="top">
                <?php echo CHtml::button('Сохранить изображения', array('id'=>'save-images', 'class'=>'save_button', 'style'=>'width:210px;')); ?>
            </td>
            <td valign="top">
                <?php $this->widget('Uplodify', array(
                	'name'=>'ProductImage[filename]',
                	'uploadUrl'=>$this->createUrl('uploadImage', array('id'=>$model->id)),
                	'options'=>array(
                		'onUploadSuccess'=>'js:function(event, data){ $("#sortable-images tbody").append(data); $("#empty-images").hide(); }',
                        'uploadLimit'=>999,
                		'fileTypeExts'=>'*.jpg;*.gif;*.jpeg;*.png;',
                		'fileTypeDesc'=>'Изображение',
                	),
                )); ?>
            </td>
        </tr>
    </table>
</div>