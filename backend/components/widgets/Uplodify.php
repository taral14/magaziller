<?php
class Uplodify extends CWidget  {

    public $name;
	public $options=array();
    public $uploadUrl;
    public $htmlOptions=array();

    public function run() {
	    if(empty($this->uploadUrl))
			throw new CException(Yii::t('yii','В классе Uplodify должно быть определено свойство uploadUrl'));

        if(empty($this->htmlOptions['id']))
            $this->htmlOptions['id']=$this->id;

        $this->registerClientScript();

	    echo CHtml::fileField('Uplodify_'.$this->id,'',$this->htmlOptions);
    }

    public function registerClientScript() {
        $id=$this->htmlOptions['id'];

        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'uploadify';
        $baseUrl=Yii::app()->assetManager->publish($dir);

        if(empty($this->options['checkExisting']))
            $this->options['checkExisting']=false;

        if(empty($this->options['buttonText']))
            $this->options['buttonText']='Обзор...';

        if(empty($this->options['width']))
            $this->options['width']=90;

        if(empty($this->options['auto']))
            $this->options['auto']=true;

        $this->options['fileObjName']=empty($this->name)?'file':$this->name;

        if(empty($this->options['postData']))
            $this->options['postData']=array();

        $this->options['postData']['PHPSESSID']=Yii::app()->session->sessionID;

        $this->options['swf']=$baseUrl.'/swf/uploadify.swf';
        $this->options['cancelImage']=$baseUrl.'/images/uploadify-cancel.png';
        $this->options['uploader']=$this->uploadUrl;
        $options=CJavaScript::encode($this->options);

        $cs=Yii::app()->getClientScript();
        $cs->registerCoreScript('jquery');
        $cs->registerScriptFile($baseUrl.'/js/jquery.uploadify.min.js');
        $cs->registerCssFile($baseUrl.'/css/uploadify.css');
		$cs->registerScript('Yii.Uplodify#'.$id,"$(\"#{$id}\").uploadify({$options});");
    }

}