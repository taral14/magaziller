<?php
class LiqPay extends PayHandler {

    public $merchant_id;
    public $signature;

    public function renderPayForm() {
        $order=$this->order;
        $amount=$amount=$order->cost;
        $server_url=Yii::app()->createAbsoluteUrl('order/setPaidStatus', array('key'=>$order->getEncodeKey()));
        $result_url=Yii::app()->createAbsoluteUrl('order/view', array('key'=>$order->getEncodeKey()));
        $order_id=$order->id.time();
        $description=Yii::app()->translitFormatter->formatText(implode(', ', CHtml::listData($order->products,'id','name')));

        $xml="<request>
            <version>1.2</version>
            <merchant_id>{$this->merchant_id}</merchant_id>
            <result_url>{$result_url}</result_url>
            <server_url>{$server_url}</server_url>
            <order_id>{$order_id}</order_id>
            <amount>{$amount}</amount>
            <currency>UAH</currency>
            <description>{$description}</description>
            <pay_way>card,liqpay</pay_way>
        </request>";

        $xml_encoded = base64_encode($xml);

        $form=CHtml::beginForm('https://www.liqpay.com/?do=clickNbuy');
        $form.=CHtml::hiddenField('operation_xml', $xml_encoded);
        $form.=CHtml::hiddenField('signature', $this->generateSignature($xml_encoded));
        $form.=CHtml::submitButton('Оплатить заказ');
        $form.=CHtml::endForm();
        return $form;
    }

    public function checkPayResponse($data) {
        if(empty($data['operation_xml']) || empty($data['signature'])) {
            return Order::PAYMENT_STATUS_FAILURE;
        }

        $xml_decode=base64_decode($data['operation_xml']);
        $xml=simplexml_load_string($xml_decode);

        if(empty($xml->status)) {
            return Order::PAYMENT_STATUS_FAILURE;
        }

        if($data['signature']!=$this->generateSignature($xml_decode)) {
            return Order::PAYMENT_STATUS_FAILURE;
        }

        switch($xml->status) {
            case 'success':
                return Order::PAYMENT_STATUS_SUCCESS;
                break;
            case 'failure':
                return Order::PAYMENT_STATUS_FAILURE;
                break;
            case 'wait_secure':
                return Order::PAYMENT_STATUS_WAIT_SECURE;
                break;
        }

        return Order::PAYMENT_STATUS_FAILURE;
    }

    public function generateSignature($xml_encoded) {
        return base64_encode(sha1($this->signature.$xml_encoded.$this->signature,1));
    }
}