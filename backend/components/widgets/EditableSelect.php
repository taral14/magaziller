<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Taral
 * Date: 12.09.11
 * Time: 0:22
 * To change this template use File | Settings | File Templates.
 */

class EditableSelect extends CInputWidget {

    public $options=array();
    public $data=array();

    public function run() {
        list($name,$id)=$this->resolveNameID();

		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;
		if(isset($this->htmlOptions['name']))
			$name=$this->htmlOptions['name'];
        $this->registerClientScript();

		if($this->hasModel())
			echo CHtml::activeDropDownList($this->model,$this->attribute,$this->data,$this->htmlOptions);
		else
			echo CHtml::dropDownList($name,$this->value,$this->data,$this->htmlOptions);
    }

    public function registerClientScript() {
        $id=$this->htmlOptions['id'];

        $options=CJavaScript::encode($this->options);
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'editableSelect';
        $baseUrl=Yii::app()->assetManager->publish($dir);
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
		$cs->registerScriptFile($baseUrl.'/js/jquery.editable-select.pack.js');
		$cs->registerCssFile($baseUrl.'/css/jquery.editable-select.css');
        $cs->registerScript('Yii.EditableSelect#'.$id,"$(\"#{$id}\").editableSelect({$options});");
    }
}