<?php /*
  *
  * $brand - бренд
  *
  * */ ?>

<div class="brand-upper-bg">
     <?php $this->widget('zii.widgets.CBreadcrumbs', array(
         'links'=>$this->breadcrumbs,
     )); ?>
<div class="more">
    <div class="brand-more-carusel">
         <div class="brand-more-pic">
             <img align="middle" width="200" src="<?php echo $brand->getImageUrl('large')?>">
         </div>
     </div>
     <div class="brand-more-text">
        <h1><?php echo $brand->name; ?></h1>
         <div class="brand-text">
             <?php echo $brand->description; ?>
         </div>
     </div>
 </div>
 </div>
 <div class="brand-nav">
    <ul>
    <?php foreach($brand->categories as $category): ?>
        <li><a href="<?php echo $category->getUrl(array('Product'=>array('brand_id'=>$brand->id))); ?>"><img src="<?php echo $category->getImageUrl('small'); ?>"><b class="clearb"></b><table><tbody><tr><td><?php echo $category->name; ?></td></tr></tbody></table></a></li>
    <?php endforeach; ?>
    </ul>
 </div>
 <b class="clearb"></b>


     <?php $brand->countCategories; ?>