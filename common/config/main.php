<?php

return array(
	'name'=>'Magaziller',
    'language' => 'ru',

    'import'=>array(
        'common.models.*',
        'common.components.*',
        'common.components.helpers.*',
        'common.components.behaviors.*',
        'common.components.widgets.*',
        'common.components.handlers.*',
        'common.components.payments.*',
    ),

    'runtimePath'=>dirname(dirname(dirname(__FILE__))).DIRECTORY_SEPARATOR.'runtime',

	// preloading 'log' component
	'preload'=>array('log'),

	// application components
	'components'=>array(
        'priceFormatter'=>array(
            'class'=>'PriceFormatter',
        ),

        'translitFormatter'=>array(
            'class'=>'TranslitFormatter',
        ),

        'config'=>array(
            'class'=>'ConfigComponent',
        ),

        'swiftMailer'=>array(
            'class'=>'common.extensions.swiftMailer.SwiftMailer',
        ),

        'currency'=>array(
            'class'=>'CurrencyComponent',
        ),

        'twig'=>array(
            'class'=>'common.extensions.twig.TwigStringComponent',
        ),

		'user'=>array(
            'class'=>'WebUser',
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),

        'authManager' => array(
            'class' => 'PhpAuthManager',
        ),

		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=brainsto_base',
			'emulatePrepare' => true,
            'username' => 'brainsto_root',
         	'password' => 'cM7pJimMUUBA',
			'charset' => 'utf8',
            'tablePrefix' => 'tbl_',
		),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array(
					'class'=>'CFileLogRoute',
					'levels'=>'error, warning',
				),
			),
		),
	),

	'params'=>array(),
);