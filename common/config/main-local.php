<?php

return array(
    'modules'=>array(
        'gii'=>array(
            'class'=>'system.gii.GiiModule',
            'password'=>'password',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters'=>array('127.0.0.1','::1'),
        ),
    ),
    'components'=>array(
		'db'=>array(
			'connectionString' => 'mysql:host=localhost;dbname=magaziller',
			'username' => 'root',
			'password' => '',
            'enableProfiling'=>true,
            'enableParamLogging' => true,
		),
        'log'=>array(
            'routes'=>array(
                /*array( // configuration for the toolbar
                    'class'=>'webroot.common.extensions.yiidebugtb.XWebDebugRouter',
                    'config'=>'alignLeft, opaque, runInDebug, fixedPos,  collapsed, yamlStyle',
                    //'levels'=>'error, warning, trace, profile, info',
                    'levels'=>'error, warning, trace, info',
                    'allowedIPs'=>array('127.0.0.1','::1','192.168.1.54','192\.168\.1[0-5]\.[0-9]{3}'),
                ),*/
                array(
                    'class'=>'common.extensions.yii-debug-toolbar.YiiDebugToolbarRoute',
                    'ipFilters'=>array('127.0.0.1'),
                ),
                /*array(
                    'class'=>'CWebLogRoute',
                    'categories' => 'application',
                    'levels'=>'error, warning, trace, profile, info',
                    'showInFireBug' => true
                ),*/
                /*array(
                    'class'=>'ext.db_profiler.DbProfileLogRoute',
                    'countLimit' => 1, // How many times the same query should be executed to be considered inefficient
                    'slowQueryMin' => 0.01, // Minimum time for the query to be slow
                ),*/
                /*array(
                    // направляем результаты профайлинга в ProfileLogRoute (отображается внизу страницы)
                    'class'=>'CProfileLogRoute',
                    'levels'=>'profile',
                    'enabled'=>true,
                ),*/
            )
        ),

    ),
);