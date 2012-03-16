<?php
class Receipt extends PayHandler {

    public $recipient;
    public $inn;
    public $account;
    public $bank;
    public $bik;
    public $correspondent_account;
    public $banknote;
    public $pense;


    public function renderPayForm() {
        $form=CHtml::beginForm(array('order/receipt', 'key'=>$this->order->getEncodeKey()));
        $form.='<label>Имя плательщика<br>';
        $form.=CHtml::textField('Receipt[name]', $this->order->name, array('size'=>60,'maxlength'=>255));
        $form.='</label><br>';
        $form.='<label>Адрес плательщика<br>';
        $form.=CHtml::textField('Receipt[address]', $this->order->address, array('size'=>60,'maxlength'=>255));
        $form.='</label>';
        $form.='<br>';
        $form.=CHtml::submitButton('Получить чек');
        $form.=CHtml::endForm();
        return $form;
    }

    public function checkPayResponse($data) {
        return true;
    }
}