<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title><?php echo $this->metaTitle; ?></title>
    <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/css/receipt.css" />
</head>

<body>

<div class="center">
	<div class="body">
    	<div class="top">
            <p style="margin:15px 0 0 316px; font-size:14px;"><?php echo $recipient; ?></p>
            <p style="margin:50px 0 0 316px; font-size:14px;"><?php echo $inn; ?></p>
            <p style="margin:50px 0 0 531px; font-size:14px;"><?php echo $account; ?></p>
            <p style="margin:89px 0 0 316px; font-size:14px;"><?php echo $bank; ?></p>
            <p style="margin:128px 0 0 350px; font-size:14px;"><?php echo $bik; ?></p>
            <p style="margin:128px 0 0 550px; font-size:14px;"><?php echo $correspondent_account; ?></p>
            <p style="margin:163px 0 0 430px; font-size:14px;"><?php echo $order_id; ?></p>
            <p style="margin:163px 0 0 553px; font-size:14px;"></p>
            <p style="margin:200px 0 0 459px; font-size:13px;"><?php echo $name; ?></p>
            <p style="margin:222px 0 0 459px; font-size:13px;"><?php echo $address; ?></p>
            <p style="margin:246px 0 0 685px; font-size:13px;"><?php echo $cost_banknote.' '.$banknote; ?> <?php echo $cost_pense.' '.$pense; ?></p>
            <p style="margin:267px 0 0 683px; font-size:14px;"><?php echo $cost_banknote.' '.$banknote; ?> <?php echo $cost_pense.' '.$pense; ?></p>
        </div>
        <div class="bottom">
        	<p style="margin:15px 0 0 316px; font-size:14px;"><?php echo $recipient; ?></p>
            <p style="margin:50px 0 0 316px; font-size:14px;"><?php echo $inn; ?></p>
            <p style="margin:50px 0 0 531px; font-size:14px;"><?php echo $account; ?></p>
            <p style="margin:89px 0 0 316px; font-size:14px;"><?php echo $bank; ?></p>
            <p style="margin:128px 0 0 350px; font-size:14px;"><?php echo $bik; ?></p>
            <p style="margin:128px 0 0 550px; font-size:14px;"><?php echo $correspondent_account; ?></p>
            <p style="margin:163px 0 0 430px; font-size:14px;"><?php echo $order_id; ?></p>
            <p style="margin:163px 0 0 553px; font-size:14px;"></p>
            <p style="margin:200px 0 0 459px; font-size:13px;"><?php echo $name; ?></p>
            <p style="margin:222px 0 0 459px; font-size:13px;"><?php echo $address; ?></p>
            <p style="margin:246px 0 0 685px; font-size:13px;"><?php echo $cost_banknote.' '.$banknote; ?> <?php echo $cost_pense.' '.$pense; ?></p>
            <p style="margin:267px 0 0 683px; font-size:14px;"><?php echo $cost_banknote.' '.$banknote; ?> <?php echo $cost_pense.' '.$pense; ?></p>
        </div>
    </div>
</div>

</body>
</html>