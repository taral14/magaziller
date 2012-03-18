<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo Yii::app()->seo->metaTitle; ?></title>
    <meta name="description" content="<?php echo Yii::app()->seo->metaDescription; ?>">
    <meta name="keywords" content="<?php echo Yii::app()->seo->metaKeywords; ?>">

    <meta http-equiv="Content-Language" content="<?php echo Yii::app()->language;?>">

	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/form.css" />
</head>

<body>
<div class="header">
	<div class="headerbg">
    	<div class="header-content">
            <a class="logo" href="<?php echo Yii::app()->baseUrl; ?>" title="Zeleny"></a>
            <div class="phone">
            	(063) 833-05-42 <span>(044) 404-60-86</span>
                <a href="#"><p><b>заказать обратный звонок</b></p></a>
            </div>
<form action="<?php echo Yii::app()->createUrl('site/currency'); ?>" method="get">
    <?php echo CHtml::dropDownList('id', Yii::app()->currency->active['id'], CHtml::listData(Currency::model()->findAll(), 'id', 'name'), array('onchange'=>'this.form.submit();')) ?>
    <?php echo CHtml::hiddenField('returnUrl', Yii::app()->request->url) ?>
</form>
            <div id="compare-box"><?php $this->renderPartial('//compare/_view'); ?></div>
            <div id="cart-box"><?php $this->renderPartial('//order/_view'); ?></div>
        </div>
    </div>
</div>
<b class="clearb"></b>
<div class="page-shadow">
	<div class="head-nav">
        <?php foreach(MenuItem::model()->findAll('parent_id=1') as $menuItem): ?>
        <a href="<?php echo $menuItem->url; ?>"><?php echo $menuItem->name; ?></a>
        <?php endforeach; ?>
        <div class="head-search">
            <form name="search" method="get" action="<?php echo $this->createUrl('search/result'); ?>">
            <input name="query" type="text" size="35" value="<?php echo isset($_GET['query'])?CHtml::encode($_GET['query']):''; ?>" />
            <input name="submit" type="submit" class="sbutton" value />
            </form>
        </div>
    </div>
    <b class="clearb"></b>
    <div class="head-menu">
    	<ul>
            <?php foreach(Category::model()->findAll('parent_id=1') as $category): ?>
        	<li><a class="inactive" href="<?php echo $category->url; ?>">Смартфоны <?php echo $category->name; ?></a></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <b class="clearb"></b>
    <div class="submenu">
        <?php foreach(Category::model()->findAll('parent_id=5') as $category): ?>
        <a href="<?php echo $category->url; ?>">Чехлы для <?php echo $category->name; ?></a>
        <?php endforeach; ?>
    </div>
    <b class="clearb"></b>
    <?php echo $content; ?>
    <b class="clearb"></b>

    <div class="footer-menu">
        <?php foreach(MenuItem::model()->findAll('parent_id=1') as $menuItem): ?>
        <a href="<?php echo $menuItem->url; ?>"><?php echo $menuItem->name; ?></a>
        <?php endforeach; ?>
    </div>
    <b class="clearb"></b>
    <div class="footer">
    	<div class="footer-left">
    	<p><b>Главный офис:</b> г. Киев, ул. Викенитя Хвойки 21, оф. 207</p>
        <p>(044) 227-97-57<br />
        Пн-Пт: с 9:00 до 18:00<br />
        Сб-Вс: выходной</p>
        <p>© 2009 Дистрибьютор TM Cerus. Все права защищены Аккумуляторы, батареи  и зарядные утсройства к ноутбукам, фотоаппаратам, видеокамерам. Комлектующие к ноутбукам, оригинальное серверное оборудование</p>
        </div>
        <div class="footer-contacts">
        <p>Мы в социальных сетях</p>
        <a href="#" title="Vkontakte"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/vkont.png" /></a>
        <a href="#" title="Facebook"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/face.png" /></a>
        <a href="#" title="YouTube"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/yout.png" /></a>
        <a href="#" title="Twitter"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/twit.png" /></a>
        </div>
        <div class="brainstorm">
        <p>Создание и продвижение сайта</p>
        <a href="#" title="Brainstorm"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/brain.png" /></a>
        </div>
        <div class="payment">
        <p>Принимаем платежи</p>
        <a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/aval.png" /></a>
        <a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/webmoney.png" /></a>
        <a href="#"><img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/privat.png" /></a>
        </div>
    </div>
</div>
</body>
</html>