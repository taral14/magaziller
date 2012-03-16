<?php

return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',

	'name'=>'Magaziller',
    'language' => 'ru',

	'import'=>array(
		'application.models.*',
		'application.components.*',
        'application.components.behaviors.*',
        'application.components.helpers.*',
        'application.components.widgets.*',
        'application.components.handlers.*',

        'common.models.*',
        'common.components.*',
        'common.components.helpers.*',
        'common.components.behaviors.*',
        'common.components.widgets.*',
    ),



	'components'=>array(
        'file'=>array(
            'class'=>'CFile',
        ),

        'image'=>array(
            'class'=>'ext.image.CImageComponent',
            'driver'=>'GD',
        ),

		'urlManager'=>array(
			'urlFormat'=>CUrlManager::PATH_FORMAT,
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/update',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),

        'frontendUrlManager'=>array(
            'class'=>'FrontendUrlManager',
        ),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
            'errorAction'=>'site/error',
        ),

        'widgetFactory'=>array(
            'widgets'=>array(
                'ElRTE'=>array(
                    'elFinder'=>array(
                        'urlExpression'=>"Yii::app()->createUrl('elfinder')",
                        'width'=>'850',
                    )
                ),
            ),
        ),
	),

	'params'=>array(),
);