<div class="best-head">Результаты поиска</div>
<br>
<div class="best-content">
    <?php $this->widget('zii.widgets.CBreadcrumbs', array(
        'links'=>$this->breadcrumbs,
    )); ?>

<div>
    <span><?php echo $dataProvider->sort->link('model', 'Название'); ?></span>
    <span><?php echo $dataProvider->sort->link('id', 'ID'); ?></span>
    <span><?php echo $dataProvider->sort->link('price', 'Цена'); ?></span>
</div>

<?php foreach($dataProvider->data as $product):?>
    <?php $this->renderPartial('/product/_view', array('product'=>$product)); ?>
<?php endforeach; ?>

<?php if($dataProvider->itemCount==0): ?>
    Поиск не дал результатов.
<?php endif; ?>

<?php $this->widget('CLinkPager', array(
     'pages'=>$dataProvider->pagination,
)); ?>

</div>