<div class="best-head">Каталог</div>
<br>
<div class="best-content">

<b>Сортировать</b>
<a href="<?php echo $dataProvider->sort->createUrl($this, array('browse'=>true)); ?>">По популярности</a>
<a href="<?php echo $dataProvider->sort->createUrl($this, array('price'=>false)); ?>">По цене (сначала дешёвые)</a>
<a href="<?php echo $dataProvider->sort->createUrl($this, array('price'=>true)); ?>">По цене (сначала дорогие)</a>
<a href="<?php echo $dataProvider->sort->createUrl($this, array('name'=>false)); ?>">По названию</a>

<ul>
    <?php foreach($dataProvider->data as $product): ?>
        <?php $this->renderPartial('/product/_view', array('product'=>$product)); ?>
    <?php endforeach; ?>
</ul>

<b class="clearb"></b>

<?php $this->widget('CLinkPager', array(
     'pages'=>$dataProvider->pagination,
)); ?>

</div>







