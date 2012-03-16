<tr id="Image_id-<?php echo $model->id; ?>">
    <td><img src="<?php echo $this->assetsUrl; ?>/images/move.png" alt="Переместить" width="16" height="16" class="move"></td>
    <td><img width="100" src="<?php echo $model->getImageUrl('thumb'); ?>"></td>
    <td><?php echo CHtml::textArea("Image[$model->id][description]", $model->description, array('style'=>'width:100%;height:70px;'))?></td>
    <td><img src="<?php echo $this->assetsUrl; ?>/images/delete.png" alt="Удалить" width="16" height="16" class="delete"></td>
</tr>