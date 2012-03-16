<?php
Yii::app()->getClientScript()->registerScript('Menu', "
    $('.more-menu-head a').click(function(){
        var content_id=$(this).attr('href');
        $('.more-menu-head li').removeClass('more-active');
        $(this).parent().addClass('more-active');
        $('.tab-more').hide();
        $(content_id).show();
        return false;
    });
    $('.more-menu-head a:first')
");
?>
<div class="content-more">

       <?php $this->widget('zii.widgets.CBreadcrumbs', array(
           'links'=>$this->breadcrumbs,
           'htmlOptions'=>array('class'=>'bread'),
           'separator'=>'<img src="'.Yii::app()->theme->baseUrl.'/images/bread-arrow.png" />'
       )); ?>

        <b class="clearb"></b>
        <div class="carousel">
            <img height="433" src="<?php echo $product->getImageUrl('large'); ?>" />
        </div>
    
        <div class="more-info">
        	<div class="more-price">
            <?php echo Yii::app()->priceFormatter->templateFormat('{int}<strong>{currency}</strong>', $product->price); ?>
            </div>
            <b class="clearb"></b>
            <h1><?php echo $product->name; ?></h1>
            <p>


               <ul class="summary-reatures">
<?php foreach($product->getFeatures(Feature::IN_SUMMARY) as $feature) : ?>
    <li><?php if(!$feature->hide_name) echo CHtml::tag('strong', array(), $feature->name).': '; ?> <?php echo $feature->value; ?></li>
<?php endforeach; ?>
               </ul>
                <?php echo $product->summary; ?></p>
            <a class="more-buy" onclick="$.putToCart(<?php echo $product->id; ?>)" href="#"></a>

        <?php $this->beginWidget('PrettyPhoto', array(
            'gallery'=>true,
            'options'=>array(
                'overlay_gallery'=>false,
            ),
        )); ?>
            <?php foreach($product->images as $image): ?>

            <a href="<?php echo $image->getImageUrl('large'); ?>"><img height="80" src="<?php echo $image->getImageUrl('small'); ?>" /></a>

            <?php endforeach; ?>
        <?php $this->endWidget(); ?>

        </div>
        <b class="clearb"></b>

    <?php $this->beginClip('accessory'); ?>
        <ul>
            <?php foreach($product->accessories as $accessory): ?>
                <?php $this->renderPartial('/product/_view', array('product'=>$accessory)); ?>
            <?php endforeach; ?>
        </ul>
    <?php $this->endClip(); ?>

    <?php
    $this->widget('CTabView', array(
        'tabs'=>array(
            'tab1'=>array(
                'title'=>'Обзор',
                'content'=>$product->description,
            ),
            'tab2'=>array(
                'title'=>'Характеристики',
                'view'=>'_features',
                'data'=>array(
                    'product'=>$product,
                    'features'=>$product->getFeatures(Feature::IN_DETAIL),
                ),
            ),
            'tab3'=>array(
                'title'=>'Аксессуары',
                'content'=>$this->clips['accessory']
            ),
        ),
        //'cssFile'=>false,
    ));
    ?>

<?php if($product->hasSimilars):  ?>
        <b class="clearb"></b>

        <div class="recommend">
        	<h1>Похожие товары <?php echo $product->name; ?></h1>
            <ul>
                <?php foreach($product->similars as $sProduct): ?>
                    <?php $this->renderPartial('/product/_view', array('product'=>$sProduct)); ?>
                <?php endforeach; ?>
            </ul>
        </div>
<?php endif; ?>
