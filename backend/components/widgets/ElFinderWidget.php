<?php

Yii::import('zii.widgets.jui.CJuiInputWidget');

class ElFinderWidget extends CJuiInputWidget {

    const INPUT=0;
    const DIV=2;

    public $for=self::DIV;
    public $url;
    public $urlExpression;

    public function run() {
        if(isset($this->htmlOptions['id']))
            $id=$this->htmlOptions['id'];
        else
            $id=$this->htmlOptions['id']=$this->getId();

        if($this->urlExpression)
            $this->options['url']=$this->evaluateExpression($this->urlExpression);
        else
            $this->options['url']=$this->url;

        if(isset($this->options['lang']))
            $language=$this->options['lang'];
        else
            $language=$this->options['lang']=Yii::app()->language;
        
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'elfinder';
        $baseUrl=Yii::app()->assetManager->publish($dir);
        $cs = Yii::app()->getClientScript();
        $cs->registerScriptFile($baseUrl."/js/elfinder.full.js",CClientScript::POS_END);
        $cs->registerScriptFile($baseUrl."/js/i18n/elfinder.{$language}.js",CClientScript::POS_END);
        $cs->registerCssFile($baseUrl.'/css/elfinder.full.css');
        $cs->registerCssFile($baseUrl.'/css/elfinder.theme.css');

        switch($this->for) {
            case self::INPUT:
                    list($name, $id)=$this->resolveNameID();
                    if($this->hasModel())
                        echo CHtml::activeTextField($this->model,$this->attribute,$this->htmlOptions);
                    else
                        echo CHtml::textField($name,$this->value,$this->htmlOptions);

                    $this->options['commandsOptions']['getfile']['oncomplete']='destroy';
                    $this->options['getFileCallback']="js:function(img){ $('#$id').val(img.url)}";
                    $options=CJavaScript::encode($this->options);

                    echo CHtml::image($baseUrl.'/img/elfinder.png', 'ElFinder', array('id'=>$id.'-browse', 'width'=>20));

                    $cs->registerScript(__CLASS__.'#'.$id, "$('#$id-browse').click(function(){ $('<div />').dialogelfinder({$options}); });");
                break;

            case self::DIV:
                    $options=CJavaScript::encode($this->options);
                    echo CHtml::tag('div', $this->htmlOptions, '');
                    $cs->registerScript(__CLASS__.'#'.$id, "$('#$id').elfinder($options);");
                break;

            default:
                throw new CException('Параметр for содержит недопустимое значение');
        }
    }
}