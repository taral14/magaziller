<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'theme'=>isset($_GET['System']['theme'])?$_GET['System']['theme']:'classic',

	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.components.behaviors.*',
        'application.components.helpers.*',
        'application.components.widgets.*',
        'application.components.handlers.*',
    ),

	'components'=>array(

		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
                'sitemap.xml'=>'sitemap/index',
                '<name:\w+>.xml'=>'market/view',

				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

        'compare'=>array(
            'class'=>'CompareComponent',
        ),

        'seo'=>array(
            'class'=>'SEOComponent',
        ),

        'cart'=>array(
            'class'=>'CartComponent',
        ),

        'widgetFactory'=>array(
            'widgets'=>array(
                'CLinkPager'=>array(
                    'header'=>'',
                    'cssFile'=>false,
                ),
            ),
        ),
    ),
);