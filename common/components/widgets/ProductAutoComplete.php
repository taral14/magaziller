<?php
Yii::import('zii.widgets.jui.CJuiInputWidget');
class ProductAutoComplete extends CJuiInputWidget {

	public $url;

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
			echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
		else
			echo CHtml::textField($name,$this->value,$this->htmlOptions);

		$this->options['source']=CHtml::normalizeUrl($this->url);

		$options=CJavaScript::encode($this->options);

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'productAutoComplete';
        $baseUrl=Yii::app()->assetManager->publish($dir);

		$cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl.'/jquery.productAutoComplete.js', CClientScript::POS_END);
        $cs->registerCssFile($baseUrl.'/productAutoComplete.css');
		$cs->registerScript(__CLASS__.'#'.$id, "jQuery('#{$id}').productAutoComplete($options);");
	}
}