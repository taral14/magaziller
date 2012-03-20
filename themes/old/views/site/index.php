<br><br><br>

<?php
if($this->hasScrap('Проба')) {
    foreach($this->getScrapItems('Проба') as $item) {
        echo $item->renderTemplate();
    }
}
?>

<b class="clearb"></b>

    <div class="disclaimer">
    	<a class="deliv" href="<?php echo Yii::app()->createUrl('article/view', array('id'=>1)); ?>"><b>ДОСТАВКА</b> В ТЕЧЕНИИ ДНЯ</a>
        <div class="vertline"></div>
        <a class="warant" href="<?php echo Yii::app()->createUrl('article/view', array('id'=>5)); ?>"><b>ГАРАНТИЯ</b> ОТ ПРОИЗВОДИТЕЛЯ</a>
        <div class="vertline"></div>
        <a class="onsale" href="<?php echo Yii::app()->createUrl('article/view', array('id'=>6)); ?>"><b>АКЦИИ И СКИДКИ %</b></a>
    </div>

<b class="clearb"></b>

<div class="content">
    	<div class="cont-menu">
        	<div class="cont-menu-head">
            	<b>Меню</b>
            </div>
            <b class="clearb"></b>
            <div class="zeleny"></div>
            <div class="cont-menu-body">
                <?php foreach(Category::model()->rooted()->findAll() as $category): ?>
            	<a onclick="return false;" href="#"><strong><?php echo $category->name; ?></strong></a>
            		<ul>
                        <?php foreach($category->children as $child): ?>
                    	<li><a href="<?php echo $child->url; ?>"><?php echo $child->name; ?></a></li>
                        <?php endforeach; ?>
                	</ul>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="best">
        	<div class="best-head">
            Лучшие предложения!
            </div>
            <div class="best-content">
            	<ul>
                    <?php foreach(Product::model()->shopwindow()->limit(9)->findAll() as $product): ?>
                    <?php $this->renderPartial('/product/_view', array('product'=>$product)); ?>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>

