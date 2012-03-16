<?php /*
  *
  * $category - категория
  * $dataProvider - товары текущей категории
  *
  * */ ?>

<ul>
    <?php foreach($dataProvider->data as $product): ?>
        <?php $this->renderPartial('/product/_view', array('product'=>$product)); ?>
    <?php endforeach; ?>
</ul>

<?php $this->widget('CLinkPager', array(
     'pages'=>$dataProvider->pagination,
)); ?>