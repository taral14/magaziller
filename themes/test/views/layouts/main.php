<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo Yii::app()->seo->metaTitle; ?></title>
    <meta name="description" content="<?php echo Yii::app()->seo->metaDescription; ?>">
    <meta name="keywords" content="<?php echo Yii::app()->seo->metaKeywords; ?>">

    <meta http-equiv="Content-Language" content="ru">

	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/reset.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" />
</head>

<body>
<div class="header_bg">
    <div class="header_center">
        <div class="header">
            <div class="header_l">
                <div class="logo">
                    <a href="<?php echo Yii::app()->homeUrl; ?>" title="Прищепка"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo.png" /></a>
                </div>
                <div class="phone">
                    <ul>
                        <li><span>(044) </span>205 16 22</li>
                        <li><span>(044) </span>205 16 22</li>
                    </ul>
                </div>
                <div class="search">
                    <input class="main_sbutton" type="submit" value="Поиск" />
                    <div class="search_bg">
                        <select>
                            <option>Женская одежда</option>
                        </select>
                        <div class="search_separator">
                        </div>
                        <input class="search_text" type="text" placeholder="Поиск..." />
                        <input class="search_submit" type="submit" value />
                    </div>
                </div>
                <div class="header_nav">
                    <ul>
                        <li><a href="#">О нас</a></li>
                        <li><a href="#">Оплата и Доставка</a></li>
                        <li><a href="#">Контакты</a></li>
                    </ul>
                </div>
            </div>
            <div class="header_r">
                <div class="cart_bg">
                    <div class="enter">
                        <a href="#">Войти</a>
                    </div>
                    <a href="#"><div class="cart">
                        <div class="cart_head">
                        Корзина
                        </div>
                        <p>1 товар,</p>
                        <p>перейти</p>
                    </div></a>
                    <b class="clearb"></b>
                    <div class="social">
                        <ul>
                            <li><a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/pic/soc1.png" /></a></li>
                            <li><a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/pic/soc2.png" /></a></li>
                            <li><a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/pic/soc3.png" /></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="content_bg">
    <?php echo $content; ?>
</div>
<div class="footer_bg">
	<div class="footer_center">
    	<div class="footer">
        	<div class="footer_logo">
            	<a href="<?php echo Yii::app()->homeUrl; ?>"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/logo_footer.png" /></a>
            </div>
            <div class="footer_r">
            	<div class="footer_nav">
                    <?php $this->widget('Menu', array('items'=>MenuItem::model()->findAll('parent_id=2'))); ?>
                </div>
                <div class="footer_menu">
                	<div class="footer_menu_head">
                    Обирайте за категорією:
                    </div>
                    <table>
                    	<tr><td><a href="<?php echo Yii::app()->createUrl('product/catalog'); ?>">Усі категорії</a></td></tr>
                        <?php foreach(Category::model()->rooted()->findAll() as $category): ?>
                        <tr><td><a href="<?php echo $category->url; ?>"><?php echo $category->name; ?></a></td></tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <div class="footer_text">
                	<strong>Главный офис: </strong>Красноармейская 42б, тел. <strong>(044) </strong>239-88-22
                </div>
                <div class="footer_social">
                	<ul>
                        <li><a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/pic/footer_social1.png" /></a></li>
                        <li><a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/pic/footer_social2.png" /></a></li>
                        <li><a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/pic/footer_social3.png" /></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>
