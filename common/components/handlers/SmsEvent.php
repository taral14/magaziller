<?php
class SmsEvent {

    public function newOrder($event) {
        if(!($event->sender instanceof Order))
            return;

        if(!($event->sender instanceof Order))
            return;

        $order=$event->sender;
        $config=Yii::app()->config;
        $swift=Yii::app()->swiftMailer;
        $transport=$swift->mailTransport();
        $mailer=$swift->mailer($transport);

        if($config['smsing_new_order_to_admin'] && $config['smsing_new_order_phones']) {

            preg_match_all('#\((068|039|050|067)\)([0-9]{3})-([0-9]{2})-([0-9]{2})#', $config['smsing_new_order_phones'], $matches, PREG_SET_ORDER);

            $patterns=array(
                '068'=>'38068*@sms.beeline.ua',
                '039'=>'+38039*@sms.gt.com.ua',
                '050'=>'38050*@sms.umc.ua',
                '067'=>'38067*@sms.kyivstar.net',
            );

            $emails=array();
            foreach($matches as $match) {
                if(count($match)==5 || !empty($patterns[$match[1]])) {
                    $email=strtr($patterns[$match[1]], array('*'=>$match[2].$match[3].$match[4]));
                    array_push($emails, $email);
                }
            }

            if(empty($emails)) {
                return;
            }

            $body=Yii::app()->translitFormatter->formatText('№'.$order->id.' '.$order->name.' '.$order->phone);

            $message = $swift->newMessage(date('H:i'))
                ->setFrom(isset($_SERVER['HTTP_HOST'])?'noreply@'.$_SERVER['HTTP_HOST']:'sms@'.$_SERVER['SERVER_NAME'])
                ->setTo($emails)
                ->setBody($body);

            $mailer->send($message);
        }
    }

}
