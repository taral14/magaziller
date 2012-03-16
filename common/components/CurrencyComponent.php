<?php
class CurrencyComponent extends CApplicationComponent  {

    private $basic;
    private $active;
    private $data=array();

    public $tableName='{{currency}}';

    public function init() {
        $this->basic=Yii::app()->config['currency_basic'];
        $this->active=Yii::app()->config['currency_default'];

        if(Yii::app()->user->hasState(__CLASS__))
            $this->active=Yii::app()->user->getState(__CLASS__);

        $this->data=Yii::app()->db->createCommand()->from($this->tableName)->queryAll();
    }

    public function get($id) {
        if($id===false)
            $id=$this->active;

        if($id===true)
            $id=$this->basic;

        $currency=false;
        foreach($this->data as $row) {
            if($row['id']==$id || (preg_match('#[A-Z]{3}#', $id) && $row['code']==$id)) {
                $currency=$row;
            }
        }
        return $currency;
    }

    public function getActive() {
        return $this->get(false);
    }

    public function getBasic($column=null) {
        return $this->get(true);
    }

    public function setActive($id) {
        $this->active=$id;
        Yii::app()->user->setState(__CLASS__, $id);
    }

}