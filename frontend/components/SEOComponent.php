<?php
class SEOComponent extends CComponent {

    public $tableName='{{seo}}';

    protected $_params=array();
    protected $_metaTitle;
    protected $_metaKeywords;
    protected $_metaDescription;

    public function init() {

    }

    protected function load() {
        $route=Yii::app()->controller->route;
        $entity=array_key_exists('id', $_GET)?$_GET['id']:0;
        $row=Yii::app()->db->createCommand()
            ->select('metaTitle,metaKeywords,metaDescription')
            ->from($this->tableName)
            ->where('route=:route AND (entity=:entity OR entity=0)', array(':route'=>$route, ':entity'=>$entity))
            ->order('entity DESC')
            ->queryRow();

        if($this->_metaTitle===null)
            $this->_metaTitle=$row['metaTitle'];

        if($this->_metaKeywords===null)
            $this->_metaKeywords=$row['metaKeywords'];

        if($this->_metaDescription===null)
            $this->_metaDescription=$row['metaDescription'];
    }

    public function getMetaTitle() {
        if($this->_metaTitle===null) {
            $this->load();
        }

        return CHtml::encode(strtr($this->_metaTitle, $this->Params));
    }

    public function getMetaKeywords() {
        if($this->_metaTitle===null) {
            $this->load();
        }

        return CHtml::encode(strtr($this->_metaKeywords, $this->Params));
    }

    public function getMetaDescription() {
        if($this->_metaTitle===null) {
            $this->load();
        }

        return CHtml::encode(strtr($this->_metaDescription, $this->Params));
    }

    public function setMetaTitle($val) {
        $this->_metaTitle=$val;
    }

    public function setMetaKeywords($val) {
        $this->_metaKeywords=$val;
    }

    public function setMetaDescription($val) {
        $this->_metaDescription=$val;
    }

    public function getParams() {
        return CMap::mergeArray($this->_params, array(
            '{shop_name}'=>Yii::app()->config['shop_name'],
        ));
    }

    public function setParam($key, $val=null) {
        if(strpos($key, '{')!==0) {
            $key='{'.$key.'}';
        }
        $this->_params[$key]=$val;
    }

    public function setParams(array $params) {
        foreach($params as $name=>$val) {
            $this->setParam($name, $val);
        }
    }

}