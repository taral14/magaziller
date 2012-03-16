<?php
class BxSlider extends CWidget {

    public $options=array();
    public $htmlOptions=array();
    public $items;

    public $width;
    public $height;

    public function run() {
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$id=$this->htmlOptions['id']=$this->getId();

        $this->htmlOptions['style']="list-style:none;padding-left:0px;";

        echo CHtml::openTag('ul', $this->htmlOptions);

        foreach($this->items as $item) {
            echo CHtml::tag('li', array(
                'style'=>"width:{$this->width}px;height:{$this->height}px;overflow:hidden;float:left;",
            ), $item->renderTemplate());
        }
        echo CHtml::closeTag('ul');

        $this->registerScripts();
    }

    private function registerScripts() {
        $id=$this->htmlOptions['id'];
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'bxSlider';
        $baseUrl=Yii::app()->assetManager->publish($dir);

        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($baseUrl."/jquery.bxSlider.js");
        $options=CJavaScript::encode($this->options);
        $cs->registerScript(__CLASS__.'#'.$id, "$('#$id').bxSlider($options);");
    }
}