<?php
class MiniColors extends CInputWidget {

    public $hidden = false;
    public $options=array();

    public function run() {
        list($name,$id)=$this->resolveNameID();

        if(empty($this->htmlOptions['id']))
            $this->htmlOptions['id']=$id;

        if(isset($this->htmlOptions['name']))
            $name=$this->htmlOptions['name'];
        else
            $this->htmlOptions['name']=$name;

        $this->registerScripts();

        if($this->hasModel()) {
            if($this->hidden)
                echo CHtml::activeHiddenField($this->model,$this->attribute,$this->htmlOptions);
            else
                echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
        } else {
            if($this->hidden)
                echo CHtml::hiddenField($name,$this->value,$this->htmlOptions);
            else
                echo CHtml::textField($name,$this->value,$this->htmlOptions);
        }
    }

    protected function registerScripts() {
        $id=$this->htmlOptions['id'];
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'miniColors';
        $baseUrl=Yii::app()->assetManager->publish($dir);
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($baseUrl.'/jquery.miniColors.min.js');
        $cs->registerCssFile($baseUrl.'/jquery.miniColors.css');

        $options = CJavaScript::encode($this->options);

        $cs->registerScript(__CLASS__.'#'.$id, "$('#$id').miniColors($options);");
    }

}