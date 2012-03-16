<?php
class PriceFormatter extends CApplicationComponent  {

    public function format($price, $params=false) {
        return $this->templateFormat('{prefix}{price}{suffix}', $price, $params);
    }

    public function templateFormat($template, $price, $params=false) {
        is_array($params) or $params=array('currency'=>$params);

        $params=CArray::overwrite(array(
            'price_accuracy'=>Yii::app()->config['price_accuracy'],
            'currency'=>false,
        ), $params);

        $c=Yii::app()->currency->get($params['currency']);
        $price=$this->convert($price, $params['currency']);
        $pense=end(explode('.',number_format($price, $params['price_accuracy'], '.','')));

        return strtr($template, array(
            '{price}'    => number_format($price, $params['price_accuracy'], ',', ' '),
            '{fract}'    => $pense,
            '{int}'      => floor($price),
            '{pense}'    => $pense,
            '{banknote}' => floor($price),
            '{suffix}'   => $c['suffix'],
            '{prefix}'   => $c['prefix'],
            '{currency}' => empty($c['suffix'])?$c['prefix']:$c['suffix'],
        ));
    }

    public function convert($price, $to=false, $from=true) {
        $c=Yii::app()->currency->get($to);
        $b=Yii::app()->currency->get($from);

        if($c!=$b)
            $price=$price*($b['ratio_to'] * $c['ratio_from'] / $b['ratio_from'] / $c['ratio_to']);

        return $price;
    }

    public function toBasic($price) {
        return $this->convert($price, true, false);
    }
}