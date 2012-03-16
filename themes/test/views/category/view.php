<?php /*
  *
  * $category - категория
  * $dataProvider - товары текущей категории
  *
  * */ ?>

<?php $this->layout='column1'; ?>
<div class="content-catalog">
<div class="cont-menu">
    <div class="cont-menu-head">
        <b>Меню</b>
    </div>
    <b class="clearb"></b>
    <div class="zeleny"></div>
    <div class="catalog-menu-body">
        <?php $this->widget('Menu', array(
            'items'=>Category::model()->rooted()->findAll()
        ))?>
        <div class="catalog-search">
            <?php $this->renderPartial('_filters', array(
                'sort'=>$dataProvider->sort,
                'category'=>$category,
                'filters'=>$category->filters,
            )); ?>
        </div>
    </div>
</div>
<div class="best">
    <div class="best-head"><?php echo $category->name; ?></div>
    <div class="best-content">
        <?php
            if($category->hasChildren) {
                $this->renderPartial('_children', array(
                    'children'=>$category->children,
                    'category'=>$category,
                ));
            } elseif($category->hasProducts) {
                $this->renderPartial('_products', array(
                    'dataProvider'=>$dataProvider,
                    'category'=>$category,
                ));
            } else {
                echo '<h3>Категория пуста.</h3>';
            }
        ?>
    </div>
</div>
</div>