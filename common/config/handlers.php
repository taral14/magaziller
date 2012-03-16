<?php
return array(
    'onOrder'=>array(
        array('MailEvent', 'newOrder'),
        array('SmsEvent', 'newOrder'),
    ),
);