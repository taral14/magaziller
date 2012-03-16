<?php
class PriceListFile extends CFormModel {

	public $file;

    private $_rows;

    public function init() {
        parent::init();
        $this->file=CUploadedFile::getInstanceByName('file');
    }

	public function rules()
	{
		return array(
			array('file', 'file', 'types'=>'xls, csv', 'allowEmpty'=>false, 'maxFiles'=>1, 'maxSize'=>2*1024*1024),
		);
	}

    public function getRows() {
        if($this->hasErrors())
            return array();

        if($this->_rows===null) {
            Yii::import('ext.PhpExcelReader');
            $data=new PhpExcelReader($this->file->tempName,true,'utf-8');
            $this->_rows=$data->sheets[0]['cells'];
        }
        return $this->_rows;
    }
}