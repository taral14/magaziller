<?php
class Masonry extends COutputProcessor {

    public $options=array();

    public function processOutput($output)
   	{
        $id=$this->getId();
        echo CHtml::openTag('div', array('id'=>$id));
        parent::processOutput($output);
        echo CHtml::closeTag('div');
        $this->registerClientScript();
   	}

    protected function registerClientScript() {
        $id=$this->getId();
        $options=CJavaScript::encode($this->options);
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'masonry';
        $baseUrl=Yii::app()->assetManager->publish($dir);
      	$cs = Yii::app()->clientScript;
      	$cs->registerCoreScript('jquery');
      	$cs->registerScriptFile($baseUrl.'/jquery.masonry.min.js');
        $cs->registerScript(__CLASS__.'#'.$id, "$('#$id').masonry($options);");
    }
}