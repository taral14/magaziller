<?php
class TwigStringComponent extends CComponent {

    private $twig;

    public function init() {
        require_once Yii::getPathOfAlias('common.extensions.twig.lib.Autoloader').'.php';
        Yii::registerAutoloader(array('Twig_Autoloader', 'autoload'), true);
        $loader = new Twig_Loader_String();
        $this->twig=new Twig_Environment($loader, array(
            'autoescape'=>false,
        ));

        $tags = array('if', 'for');
        $filters = array('upper', 'escape');

        $methods = array(
            'Article' => array('getImageUrl', 'getUrl'),
            'Brand' => array('getImageUrl', 'getUrl'),
            'Category' => array('getImageUrl', 'getUrl'),
            'Product' => array('getImageUrl', 'getUrl'),
            'News' => array('getImageUrl', 'getUrl'),
            'Promotion' => array('getImageUrl', 'getUrl'),
            'CWebApplication' => array('createUrl', 'createAbsoluteUrl'),

            'PriceFormatter' => array('format', 'templateFormat'),
            //'Lookup' => Lookup,
        );
        $properties = array(
            'CWebApplication'=>array('theme', 'priceFormatter', 'config'),
            'CTheme'=>array('baseUrl'),
        );
        $functions = array('range');
        $policy = new Twig_Sandbox_SecurityPolicy($tags, $filters, $methods, $properties, $functions);

        $sandbox = new Twig_Extension_Sandbox($policy, true);
        $this->twig->addExtension($sandbox);
    }

    public function render($content, $data=array()) {
        try {
            $data['app']=Yii::app();
            return $this->twig->render($content, $data);
        } catch(Twig_Error $e) {
            return '<p style="color: #990000;">'.$e->getRawMessage().'</p>';
        }
    }

}