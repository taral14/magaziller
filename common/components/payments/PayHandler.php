<?php
abstract class PayHandler extends CComponent{

    public $order;

    abstract public function checkPayResponse($data);
    abstract public function renderPayForm();
}