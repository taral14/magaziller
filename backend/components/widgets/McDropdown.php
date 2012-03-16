<?php
class McDropdown extends CInputWidget {

    public $options=array();

    public $nesting;

    public $data;

    public $template='{name}';

    public $without;

    private $templateParams;

    public function init() {
        preg_match_all('#{([a-z]+)}#i', $this->template, $matches);
        $this->templateParams = isset($matches[1])?$matches[1]:array();
        is_array($this->without) || $this->without=array($this->without);

        if(!isset($this->options['allowParentSelect']))
            $this->options['allowParentSelect']=true;

        if(!isset($this->options['valueAttr']))
            $this->options['valueAttr']='rel';
    }

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
			echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
		else
			echo CHtml::textField($name,$this->value,$this->htmlOptions);
        echo CHtml::openTag('ul', array('class'=>'mcdropdown_menu', 'id'=>$id.'_data'))."\n";
        echo $this->saveAsHtml($this->data, 1);
        echo CHtml::closeTag('ul');
    }

    public function registerClientScript() {
        $id=$this->htmlOptions['id'];

        $options=CJavaScript::encode($this->options);
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'mcDropdown';
        $baseUrl=Yii::app()->assetManager->publish($dir);
        $cs = Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
		$cs->registerScriptFile($baseUrl.'/js/jquery.mcdropdown.js');
		$cs->registerCssFile($baseUrl.'/css/jquery.mcdropdown.min.css');
        $cs->registerScript('Yii.McDropdown#'.$id,"$(\"#{$id}\").mcDropdown('#{$id}_data', {$options});");
    }

    protected function saveAsHtml($items, $level) {
        $html='';
        foreach($items as $model) {
            if(in_array($model['id'], $this->without)) continue;
            $text=$this->template;
            foreach($this->templateParams as $param) {
                if(isset($model[$param]))
                    $text = str_replace('{'.$param.'}', CHtml::encode($model[$param]), $text);
            }
            $html.=CHtml::tag('li', array($this->options['valueAttr']=>$model['id']), $text, false);

            $childrenHtml='';
            if(($this->nesting===null || $this->nesting>$level) && isset($model['hasChildren']) && $model['hasChildren']) {
                $childrenHtml=$this->saveAsHtml($model['children'], $level+1);
            }
            if(!empty($childrenHtml))
                $html.="\n<ul>\n{$childrenHtml}</ul>\n" ;

            $html.="</li>\n";
        }
        return $html;
    }
}