<?php
class AnythingSlider extends CWidget {

    public $items;
    public $htmlOptions=array();

    private $defaultOptions=array(
        'hashTags'=>false,
        'autoPlay'=>true,
        'buildStartStop'=>false,
    );

    public $options=array();
    public $attribute;
    public $itemView;
    public $viewData;
    public $cssFile;
    public $itemCssClass='';

    public function init() {
		if($this->itemView===null && $this->attribute===null)
			throw new CException(Yii::t('zii','The property "itemView" or "attribute" cannot be empty.'));

        $this->options=CMap::mergeArray($this->defaultOptions, $this->options);
    }

    public function run() {
		if(isset($this->htmlOptions['id']))
			$id=$this->htmlOptions['id'];
		else
			$id=$this->htmlOptions['id']=$this->getId();

        $this->registerScripts();

        echo CHtml::openTag('ul', $this->htmlOptions)."\n";
        if($this->attribute) {
            foreach($this->items as $item) {
                echo CHtml::tag('li', array(), $item->{$this->attribute});
            }
        } else {
            $owner=$this->getOwner();
			$render=$owner instanceof CController ? 'renderPartial' : 'render';
            foreach($this->items as $i=>$item) {
                $data=$this->viewData;
				$data['index']=$i;
				$data['data']=$item;
				$data['widget']=$this;
                echo CHtml::openTag('li', array('class'=>$this->itemCssClass, 'id'=>$id.'-panel'.$i));
			    $owner->$render($this->itemView,$data);
                echo CHtml::closeTag('li');
            }
        }
        echo CHtml::closeTag('ul');
    }

    private function registerScripts() {
        $id=$this->htmlOptions['id'];
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'anythingSlider';
        $baseUrl=Yii::app()->assetManager->publish($dir);

        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl."/js/jquery.anythingslider.min.js");
		if($this->cssFile===null)
			$cs->registerCssFile($baseUrl.'/css/anythingslider.css');
		else if($this->cssFile!==false)
			$cs->registerCssFile($this->cssFile);

        $options=CJavaScript::encode($this->options);
        $cs->registerScript(__CLASS__.'#'.$id, "$('#$id').anythingSlider($options);");
    }
}