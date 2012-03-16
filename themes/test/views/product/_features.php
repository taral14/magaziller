<?php
$length=ceil(count($features)/2);
$pack_id=null;
?>

<h1>Характеристики <?php echo $product->name; ?></h1>
<b class="clearb"></b>

<div id="spec_tech_component">

    <div class="column_left">
        <?php $this->renderPartial('_column', array('features'=>array_slice($features, 0, $length))); ?>
    </div>
    <div class="column_right">
        <?php $this->renderPartial('_column', array('features'=>array_slice($features, $length))); ?>
    </div>

</div>

<b class="clearb"></b>