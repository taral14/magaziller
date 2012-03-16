<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="language" content="en" />

	<!-- blueprint CSS framework -->
	<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/screen.css" media="screen, projection" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/print.css" media="print" />
	<!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/ie.css" media="screen, projection" />
	<![endif]-->

	<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/main.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo $this->assetsUrl; ?>/css/form.css" />

	<title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body>
<div class="info-message" style="display: none;"></div>
<div class="container" id="page">

    <?php if(!Yii::app()->user->isGuest && $this->isSimplePassword): ?>
    <div class="warning-simple-password" align="center">
        В целях безопасности настоятельно рекомендуем <a href="<?php echo Yii::app()->createUrl('user/update', array('id'=>Yii::app()->user->id)); ?>">сменить пароль</a>
    </div>
    <?php endif; ?>

	<div id="header">
		<div id="logo"><?php echo CHtml::encode(Yii::app()->config['shop_name']); ?></div>
	</div><!-- header -->

	<?php $this->widget('application.extensions.mbmenu.MbMenu', array('items'=>$this->topMenu)); ?>
	<!-- mainmenu -->

	<?php $this->widget('zii.widgets.CBreadcrumbs', array(
		'links'=>$this->breadcrumbs,
	)); ?><!-- breadcrumbs -->

	<?php echo $content; ?>

	<div id="footer">
		Copyright &copy; <?php echo date('Y'); ?> by <a href="http://brainstorm.com.ua/">brainstorm.com.ua</a>.
	</div><!-- footer -->

</div><!-- page -->
</body>
</html>