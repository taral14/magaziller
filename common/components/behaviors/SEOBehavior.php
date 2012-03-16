<?php
class SEOBehavior extends CActiveRecordBehavior {

    public $route;

    public $tableName='{{seo}}';

    public $params=array();

    protected $data;

    private function rules() {
		return array(
            array('metaTitle, metaKeywords, metaDescription', 'filter', 'filter'=>'strip_tags'),
			array('metaTitle, metaKeywords, metaDescription', 'length', 'max'=>500),
		);
    }

    public function attach($owner) {
        $validators=$owner->getValidatorList();
        foreach($this->rules() as $rule)
            $validators->add(CValidator::createValidator($rule[1],$owner,$rule[0],array_slice($rule,2)));

        parent::attach($owner);
    }
    
    public function setMetaTitle($metaTitle) {
        $this->load();
        $this->data['metaTitle']=$metaTitle;
    }

    public function setMetaKeywords($metaKeywords) {
        $this->load();
        $this->data['metaKeywords']=$metaKeywords;
    }

    public function setMetaDescription($metaDescription) {
        $this->load();
        $this->data['metaDescription']=$metaDescription;
    }

    public function getMetaTitle() {
        $this->load();
        return $this->data['metaTitle'];
    }

    public function getMetaKeywords() {
        $this->load();
        return $this->data['metaKeywords'];
    }

    public function getMetaDescription() {
        $this->load();
        return $this->data['metaDescription'];
    }

    public function afterSave() {
        if($this->data===null)
            return;

        if($this->isEmpty()) {
            $sql="DELETE FROM $this->tableName WHERE route=:route AND entity=:entity LIMIT 1";
            Yii::app()->db->createCommand($sql)->execute(array(
                ':route'=>$this->route,
                ':entity'=>$this->owner->id,
            ));
        } else {
            $sql="INSERT INTO $this->tableName (route,entity,metaTitle,metaKeywords,metaDescription) VALUES (:r,:e,:t,:k,:d)" .
                 "ON DUPLICATE KEY UPDATE metaTitle=:t, metaKeywords=:k, metaDescription=:d";
            Yii::app()->db->createCommand($sql)->execute(array(
                ':r'=>$this->route,
                ':e'=>$this->owner->id,
                ':t'=>$this->metaTitle,
                ':k'=>$this->metaKeywords,
                ':d'=>$this->metaDescription,
            ));
        }
    }

    protected function load() {
        if($this->data===null) {
            $meta=Yii::app()->db->createCommand()
                ->select('metaTitle,metaKeywords,metaDescription')
                ->from($this->tableName)
                ->where('route=:route AND entity=:entity', array(':route'=>$this->route, ':entity'=>$this->owner->id))
                ->queryRow();
            $this->data=($meta)?$meta:array('metaTitle'=>'', 'metaKeywords'=>'', 'metaDescription'=>'');
        }
    }

    protected function isEmpty() {
        if($this->data===null)
            return true;

        $empty=true;
        foreach($this->data as $val)
            $empty=$empty && empty($val);
        return $empty;
    }

    public function getUrl($params=array()) {
        if(IS_BACKEND)
            $urlManager=Yii::app()->frontendUrlManager;
        else
            $urlManager=Yii::app()->urlManager;
        
        return $urlManager->createUrl($this->route, CMap::mergeArray($this->params, $params));
    }

}