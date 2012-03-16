<?php
class ConfigComponent extends CApplicationComponent implements ArrayAccess {

    private $config;

    public $tableName='{{config}}';

    public function init() {
        $this->config=Yii::app()->db->createCommand()->from($this->tableName)->queryRow();
    }

   	public function offsetExists($offset)
   	{
   		return isset($this->config[$offset]);
   	}

   	public function offsetGet($offset)
   	{
   		return $this->config[$offset];
   	}

   	public function offsetSet($offset,$item)
   	{
        throw new CException('Нельзя изменять параметры конфиг файла');
   	}

   	public function offsetUnset($offset)
   	{
   		throw new CException('Нельзя удалять параметры конфиг файла');
   	}
}