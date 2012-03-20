<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/default';

    private $_scraps;

	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function init()
   	{
           $config=require Yii::getPathOfAlias('common.config.handlers').'.php';
           foreach($config as $event=>$handlers) {
               if($this->hasEvent($event)) {
                   foreach($handlers as $handler)
                       $this->attachEventHandler($event, $handler);
               }
           }

           if(Yii::app()->user->hasState('referer')==false) {
               Yii::app()->user->setState('referer', CArray::get($_SERVER, 'HTTP_REFERER', ''));
           }

           parent::init();
   	}

    protected function beforeRender($view) {
        if(parent::beforeRender($view)) {
            $this->registerScripts();

            return true;
        } else {
            return false;
        }
    }

    protected function registerScripts() {
        $cs=Yii::app()->getClientScript();
        $url=Yii::app()->createUrl('order/put');
        $cs->registerScript('PutToCart', "
            $.putToCart=function(productId, quantity){
                if(/^[0-9]+$/.test(quantity)==false) {
                    quantity=$(quantity).val();
                }
                quantity=Math.max(parseInt(quantity), 1) || 1;
                $.get('$url', {
                    id:productId,
                    quantity:quantity
                }, function(html){
                    $('#magaziller-cart-box').html(html);
                })
            }
        ");
        $url=Yii::app()->createUrl('compare/put');
        $cs->registerScript('PutToCompare', "
            $.putToCompare=function(productId){
                $.get('$url', {id:productId}, function(html){
                    $('#magaziller-compare-box').html(html);
                })
            }
        ");
    }

    public function hasScrap($name) {
        $this->loadScraps();
        foreach($this->_scraps as $scrap) {
            if($scrap->name==$name) {
                return true;
            }
        }
        return false;
    }

    public function getScrap($name) {
        $this->loadScraps();
        foreach($this->_scraps as $i=>$scrap) {
            if($scrap->name==$name) {
                unset($this->_scraps[$i]);
                return $scrap;
            }
        }
        return null;
    }

    public function getScrapItems($name) {
        if($this->hasScrap($name)) {
            return $this->getScrap($name)->items;
        } else {
            return array();
        }
    }

    private function loadScraps() {
        if($this->_scraps===null) {
            $this->_scraps=Scrap::model()->findAll("route=:route OR route=''", array(':route'=>$this->getRoute()));
        }
    }

    public function processOutput($output)
   	{
        $output=parent::processOutput($output);
        $output=preg_replace('/(<\\/body\s*>)/is',Yii::app()->config['counters'].'$1',$output,1);
   		return $output;
   	}

}