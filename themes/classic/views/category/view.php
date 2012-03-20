<?php /*
  *
  * $category - категория
  * $dataProvider - товары текущей категории
  *
  * */ ?>
<!--<?php if(false):?>
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
<?php endif; ?>-->



















<div class="content_center">
    <div class="content">
     <div class="content_l_bg">
        <div class="content_l">
            <div class="left_menu_head">
             Обирайте за категорією:
             </div>
             <div class="left_menu">
                <table>
                    <tr><td><a href="<?php echo Yii::app()->createUrl('product/catalog'); ?>">Усі категорії</a></td></tr>
                    <?php foreach(Category::model()->rooted()->findAll() as $f_category): ?>
                    <tr <?php if($f_category->id==$category->id): ?>class="active"<?php endif; ?>><td><a href="<?php echo $f_category->url; ?>"><?php echo $f_category->name; ?></a></td></tr>
                    <?php endforeach; ?>
                 </table>
                 <?php $this->renderPartial('_filters', array(
                     'sort'=>$dataProvider->sort,
                     'category'=>$category,
                     'filters'=>$category->filters,
                 )); ?>
             </div>
         </div>
         <div class="content_r">
             <div class="category_pic">
                 <img src="<?php echo $category->getImageUrl('large'); ?>" />
             </div>
             <div class="category_label">
             НОВАЯ КОЛЛЕКЦИЯ
             </div>
             <div class="category_text">
                 <h1><?php echo $category->name; ?></h1>
             </div>
             <?php $this->widget('zii.widgets.CBreadcrumbs', array(
                 'links'=>$this->breadcrumbs,
             )); ?>
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
 </div>
