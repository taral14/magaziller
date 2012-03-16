<?php if(empty($model->hasChildren)):?>
    Это меню пустое
<?php endif;?>
<?php $this->widget('CTreeView', array(
	'data'=>$model->children,
)); ?>