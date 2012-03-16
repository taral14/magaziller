<?php
class CodeMirror extends CInputWidget {

    public $options=array(
        //'mode'=>'application/xml',
        'lineNumbers'=>true,
    );

    public $theme='default';

    public $mode='xml';

    public function run() {
		list($name,$id)=$this->resolveNameID();

		if(empty($this->htmlOptions['id']))
			$this->htmlOptions['id']=$id;

		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];
		else
			$this->htmlOptions['name']=$name;

        $this->registerScripts();

		if($this->hasModel())
			echo CHtml::activeTextArea($this->model,$this->attribute,$this->htmlOptions);
		else
			echo CHtml::textArea($name,$this->value,$this->htmlOptions);
    }

    private function registerScripts() {
        $id=$this->htmlOptions['id'];
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'codeMirror';
        $baseUrl=Yii::app()->assetManager->publish($dir);

        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl."/codemirror.js");
        $cs->registerScriptFile($baseUrl.'/mode/'.$this->mode.'/'.$this->mode.'.js');
        $cs->registerCssFile($baseUrl.'/codemirror.css');
        $cs->registerCssFile($baseUrl.'/theme/'.$this->theme.'.css');

        $this->options['mode']=$this->mode;
        $options=CJavaScript::encode($this->options);
        $cs->registerScript(__CLASS__.'#'.$id, "CodeMirror.fromTextArea(document.getElementById('$id'), $options);");
    }

}