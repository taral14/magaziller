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
                    <?php foreach(Category::model()->rooted()->findAll() as $category): ?>
                    <tr><td><a href="<?php echo $category->url; ?>"><?php echo $category->name; ?></a></td></tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </div>
        <div class="content_r">
            <div class="slider">
                <?php if($this->hasScrap('Слайдер на главной')): ?>
                    <?php $this->widget('BxSlider', array(
                        'items'=>$this->getScrapItems('Слайдер на главной'),
                        'options'=>array(
                            'auto'=>false,
                            'pager'=>true,
                        ),
                        'width'=>'770',
                        'height'=>'355',
                    )); ?>
                <?php endif; ?>
            </div>
        </div>
    </div>
    </div>
    <div class="index_nav">
<?php if($this->hasScrap('4 блока на главной')): ?>
      <?php foreach($this->getScrapItems('4 блока на главной') as $item): ?>
          <?php echo $item->renderTemplate(); ?>
      <?php endforeach; ?>
<?php endif; ?>
    </div>
</div>