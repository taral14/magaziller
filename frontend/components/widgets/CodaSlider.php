<?php
class CodaSlider extends CWidget {

    public $items;
    public $htmlOptions=array(
        'class'=>'coda-slider',
    );
    public $options=array();
    public $cssFile;

    public function init() {
		if(empty($this->items))
			throw new CException(Yii::t('zii','Параметр "items" не может быть пустым.'));
    }

    public function run() {
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$id=$this->htmlOptions['id']=$this->getId();

        $this->registerScripts();

        echo CHtml::openTag('div', $this->htmlOptions)."\n";

        foreach($this->items as $i=>$item) {
            if($item instanceof ScrapItem==false) {
                continue;
            }
            $content=$item->renderTemplate(array(
                'index'=>$i,
            ));
            echo CHtml::tag('div', array('class'=>'panel'), $content)."\n";
        }
        echo '</div>';
    }

    private function registerScripts() {
        $id=$this->htmlOptions['id'];
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'codaSlider';
        $baseUrl=Yii::app()->assetManager->publish($dir);

        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl."/js/jquery.coda-slider-2.0.js");
        $cs->registerScriptFile($baseUrl."/js/jquery.easing.1.3.js");
		if($this->cssFile===null)
			$cs->registerCssFile($baseUrl.'/css/coda-slider-2.0.css');
		else if($this->cssFile!==false)
			$cs->registerCssFile($this->cssFile);

        $options=CJavaScript::encode($this->options);
        $cs->registerScript(__CLASS__.'#'.$id, "$('#$id').codaSlider($options);");
    }
}