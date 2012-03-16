<?php
/**
* PrettyPhoto widget class file
*
* @package pbm.widgets
* @author Chris Yates
* @version 1.0
* @copyright Copyright &copy; 2011 PBM Web Development - All Rights Reserved
* @license BSD 3-Clause License
*
*/
/**
* PrettyPhoto encapsulates the {@link http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/ prettyPhoto} jQuery lightbox clone.
*
* To use the widget put the following code in a view:
* <pre>
* $this->beginWidget('path.to.PrettyPhoto', array
*   id'=>'pretty_photo',
*   // prettyPhoto options
*   'options'=>array(
*     'opacity''=>0.60,
*     'modal'=>true,
*   ),
* ));
*
* echo links to content here;
*
* $this->endWidget('path.to.PrettyPhoto');
* </pre>
*
* Content links do not require the rel="prettyPhoto" attribute; the widget adds this.
*
* By configuring the {@link options} property, you may specify the options that
* need to be passed to prettyPhoto. Please refer to the {@link http://www.no-margin-for-errors.com/projects/prettyphoto-jquery-lightbox-clone/ prettyPhoto}
* documentation for possible options (name=>value pairs).
*/
class PrettyPhoto extends CWidget {
	const THEME_DARK_ROUNDED	= 'dark_rounded';
	const THEME_DARK_SQUARE		= 'dark_square';
	const THEME_FACEBOOK		= 'facebook';
	const THEME_LIGHT_ROUNDED	= 'light_rounded';
	const THEME_LIGHT_SQUARE	= 'light_square';

	/**
	* @property string Name of the CSS file to be published. This must be in the
	* css directory under the assets URL
	*/
	public $cssFile;
	/**
	* @property array HTML options for the enclosing tag
	*/
	public $htmlOptions;
	/**
	* @property boolean Whether PrettyPhoto is in gallery (many items) mode
	*/
	public $gallery=true;
	/**
	* @property array Additional options for PrettyPhoto
	*/
	public $options=array();

	/**
	* @property string The enclosing tag
	*/
	public $tag='div';
	/**
	* @property string The PrettyPhoto theme to use
	*/
	public $theme=self::THEME_FACEBOOK;

	public function init() {
		$this->registerClientScript();
		parent::init();

		$id=$this->getId();
		if (isset($this->htmlOptions['id']))
			$id = $this->htmlOptions['id'];
		else
			$this->htmlOptions['id']=$id;

		echo CHtml::openTag($this->tag,$this->htmlOptions)."\n";

		if (empty($this->options['theme']))
			$this->options['theme']=$this->theme;
		$options=CJavaScript::encode($this->options);

		Yii::app()->clientScript->registerScript(__CLASS__.'#'.$id, "
			$('#$id a:has(img)').attr('rel','prettyPhoto".($this->gallery?'[]':'')."');
			$('#$id a[rel^=\"prettyPhoto\"]').prettyPhoto(".$options.');
		');
	}

	public function run() {
		echo CHtml::closeTag($this->tag);
	}

	protected function registerClientScript(){
        $dir = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'prettyPhoto';
        $baseUrl=Yii::app()->assetManager->publish($dir);
		$cs = Yii::app()->clientScript;
		$cs->registerCoreScript('jquery');
		$cs->registerScriptFile($baseUrl.'/jquery.prettyPhoto.js');

        if($this->cssFile===null)
		    $cs->registerCssFile($baseUrl.'/prettyPhoto.css');
        else if($this->cssFile!==false)
			$cs->registerCssFile($this->cssFile);
	}
}
