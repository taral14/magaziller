<?php
class JeditableWidget extends CInputWidget {

    public $url='';

    public $options;

    public function run()
    {
        list($name,$id)=$this->resolveNameID();

        if(isset($this->htmlOptions['id']))
            $id=$this->htmlOptions['id'];
        else
            $this->htmlOptions['id']=$id;

        if(isset($this->htmlOptions['name']))
            $name=$this->htmlOptions['name'];

        if($this->hasModel())
            echo CHtml::tag('div', $this->htmlOptions, CHtml::resolveValue($this->model, $this->attribute));
        else
            echo CHtml::tag('div', $this->htmlOptions, $this->value);

        $options=CJavaScript::encode($this->options);

        $url=CJavaScript::encode(CHtml::normalizeUrl($this->url));
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'jeditable';
        $baseUrl=Yii::app()->assetManager->publish($dir);

        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($baseUrl.'/jquery.jeditable.mini.js');
        $cs->registerScript(__CLASS__.'#'.$id, "jQuery('#{$id}').editable($url, $options);");
    }
}