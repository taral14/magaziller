<?php
class VKComments extends CWidget {

    public $width=496;
    public $attach='*';
    public $limit=10;
    public $apiId;

    public function init() {
        $this->apiId=Yii::app()->config['vkontakte_api_id'];
    }

    public function run() {
        $id=$this->getId();
        $apiId=CJavaScript::encode($this->apiId);
        $options=CJavaScript::encode(array(
            'limit'=>$this->limit,
            'width'=>$this->width,
            'attach'=>$this->attach,
        ));
        echo CHtml::tag('div', array('id'=>$id), '');

        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile('http://userapi.com/js/api/openapi.js?47');
        $cs->registerScript('VK.init', "VK.init({apiId: $apiId, onlyWidgets: true});");
        $cs->registerScript(__CLASS__.'#'.$id, "VK.Widgets.Comments('$id', $options);");
    }
}