<?php
Yii::import('zii.widgets.jui.CJuiInputWidget');
class ElRTE extends CJuiInputWidget {

    public $elFinder;

    public function run() {
		list($name,$id)=$this->resolveNameID();

		if(empty($this->htmlOptions['id']))
			$this->htmlOptions['id']=$id;

		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];
		else
			$this->htmlOptions['name']=$name;

        if(empty($this->options['lang']))
            $this->options['lang']=Yii::app()->language;

        $this->registerScripts();

		if($this->hasModel())
			echo CHtml::activeTextArea($this->model,$this->attribute,$this->htmlOptions);
		else
			echo CHtml::textArea($name,$this->value,$this->htmlOptions);
    }

    private function registerScripts() {
        $language=$this->options['lang'];
        $id=$this->htmlOptions['id'];
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'elrte';
        $baseUrl=Yii::app()->assetManager->publish($dir);

        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl."/js/elrte.full.js");
        $cs->registerScriptFile($baseUrl."/js/i18n/elrte.{$language}.js");
        $cs->registerCssFile($baseUrl.'/css/elrte.min.css');

        if($this->elFinder)
            $this->addElFinder();

        $options=CJavaScript::encode($this->options);
        $cs->registerScript(__CLASS__.'#'.$id, "$('#$id').elrte($options);");
    }

    protected function addElFinder() {
        $language=$this->options['lang'];
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'elfinder';
        $baseUrl=Yii::app()->assetManager->publish($dir);
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl."/js/elfinder.full.js",CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl."/js/i18n/elfinder.{$language}.js",CClientScript::POS_END);
        $cs->registerCssFile($baseUrl.'/css/elfinder.full.css');
        $cs->registerCssFile($baseUrl.'/css/elfinder.theme.css');

        if(isset($this->elFinder['urlExpression'])) {
            $this->elFinder['url']=$this->evaluateExpression($this->elFinder['urlExpression']);
            //$this->elFinder['url']='http://localhost/elfinder-2.0-beta2/php/connector.php';
            unset($this->elFinder['urlExpression']);
        }

        $this->elFinder['commandsOptions']['getfile']['oncomplete']='destroy';
        $this->elFinder['getFileCallback']="js:function(file, fm){ return callback(file.url); }";
        $this->elFinder['lang']=$language;

        $elFinder=CJavaScript::encode($this->elFinder);

        $this->options['fmOpen']="js:function(callback){ $('<div />').dialogelfinder({$elFinder}); }";
    }

}