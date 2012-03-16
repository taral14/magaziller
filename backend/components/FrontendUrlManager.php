<?php
class FrontendUrlManager extends CUrlManager {

    private $_baseUrl;

    public function __construct() {
        $frontend=include(Yii::getPathOfAlias('frontend.config.main').'.php');

        $config=$frontend['components']['urlManager'];
        unset($config['class']);
        foreach($config as $key=>$value)
			$this->$key=$value;
    }

	public function getBaseUrl()
	{
		if($this->_baseUrl!==null)
			return $this->_baseUrl;
		else
		{
			if($this->showScriptName)
				$this->_baseUrl=Yii::app()->getRequest()->getBaseUrl().'/index.php';
			else
				$this->_baseUrl=Yii::app()->getRequest()->getBaseUrl();
			return $this->_baseUrl;
		}
	}

}