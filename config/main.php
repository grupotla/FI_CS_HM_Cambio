<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');
//Yii::setPathOfAlias('bootstrap', dirname(__FILE__).'/../extensions/bootstrap'); //it works fine with giiplus

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	'name'=>'Cambia Contraseña v1.2',
	'theme'=>'abound',
	
	'language'=>'es', // user language (for Locale)
    'sourceLanguage'=>'es', //language for messages and views
    'charset'=>'utf-8',    	
	
	
	// preloading 'log' component
	'preload'=>array('log'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.Accesos.models.*',
		'application.modules.Master.models.*',
	),
	
	'defaultController'=>'site/login',

	'modules'=>array(
		// uncomment the following to enable the Gii tool
		/*
		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',		
			//'generatorPaths' => array('ext.giiplus',), it works fine with bootstrap
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','::1'),
		),
		//'Accesos',
		//'Master',
		*/
	),

	// application components
	'components'=>array(
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
		/* it works fine with giiplus
		'bootstrap' => array(
            'class'=>'bootstrap.components.Bootstrap'
       	),
       	*/
                		
		// uncomment the following to enable URLs in path-format
		/*
		'urlManager'=>array(
			'urlFormat'=>'path',
			'rules'=>array(
				'<controller:\w+>/<id:\d+>'=>'<controller>/view',
				'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
				'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
			),
		),
		*/
		/*
		'db'=>array(
			'connectionString' => 'sqlite:'.dirname(__FILE__).'/../data/testdrive.db',
		),
		*/
		// uncomment the following to use a MySQL database		
		
		///////////////////////////////////////LOCAL////////////////////////
		
		/*
		'accesos'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=localhost;dbname=catalogos',
			'emulatePrepare' => true,
			'username' => 'root',
			'password' => '',
			'charset' => 'utf8',
		),
		*/
		
		/*
		'acceso'=>array(
			'class'=>'CDbConnection',			
			'emulatePrepare' => true,
			'connectionString' => 'pgsql:host=localhost;port=5432;dbname=master-aimar',			
			'username' => 'postgres',
			'password' => '123456',			
			
			//'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=bk_master-aimar',
			//'username' => 'dbmaster',
			//'password' => 'aimargt',
			
			'charset' => 'utf8',
		),

		'division'=>array(
			'class'=>'CDbConnection',			
			'emulatePrepare' => true,
			'connectionString' => 'mysql:host=10.10.1.18;dbname=db_aereo',			
			'username' => 'DbAereo',
			'password' => 'aereoaimar',
			'charset' => 'utf8',
		),
		*/
		///////////////////////////////////////MASTER////////////////////////
		'db'=>array(
			'class'=>'CDbConnection',
			/*
			'connectionString' => 'pgsql:host=localhost;port=5432;dbname=master-aimar',			
			'username' => 'postgres',
			'password' => '123456',
			*/			
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=master-aimar',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			
			'charset' => 'utf8',
		),	
		
		/*
		///////////////////////////////////////CUSTOMER////////////////////////
		'customer'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=10.10.1.18;dbname=customer',
			'emulatePrepare' => true,
			'username' => 'us3r_cUstomer',
			'password' => 'cUst0m3R',
			'charset' => 'utf8',
		),		
		
		///////////////////////////////////////WMS////////////////////////
		'wms'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=10.10.1.18;dbname=WMS_AIMAR',
			'emulatePrepare' => true,
			'username' => 'user_WMS',
			'password' => 'us3r_WM5',
			'charset' => 'utf8',
		),		

		///////////////////////////////////////AEREO////////////////////////
		'aereo'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=10.10.1.18;dbname=db_aereo',
			'emulatePrepare' => true,
			'username' => 'DbAereo',
			'password' => 'aereoaimar',
			'charset' => 'utf8',
		),
	
		///////////////////////////////////////TERRESTRE////////////////////////
		'terrestre'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=10.10.1.18;dbname=db_terrestre',
			'emulatePrepare' => true,
			'username' => 'DbTerrestre',
			'password' => 'terrestreaimar',
			'charset' => 'utf8',
		),		
		///////////////////////////////////////CAJA////////////////////////
		'caja'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'mysql:host=10.10.1.22;dbname=caja_regional',
			'emulatePrepare' => true,
			'username' => 'user_manager',
			'password' => 'uS3rr0daRts1niMda',
			'charset' => 'utf8',
		),					
		////////////////////////AIMAR////////////////////////
		'bk_gt'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=bk_ventas_gt',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),	
		'bk_cr'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=bk_ventas_cr',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),				
		'v_gt'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_gt',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),		
		'v_sv'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_sv',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),	
		'v_hn'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_hn',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),	
		'v_ni'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_ni',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),	
		'v_cr'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_cr',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),			
		'v_pa'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_pa',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),	
		'v_mx'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_mx',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),				
		
		
		/////////////////////////////GRH///////////////////
		'v_nigrh'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_ni_grh',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),
		*/
		
		
		/*
	
				
		//////////////////////////////////////LTF//////////////////////////
		'v_gtltf'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_gtltf',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),
		'v_svltf'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_svltf',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),		
		'v_hnltf'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_hnltf',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),		
		'v_niltf'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_niltf',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),		
		'v_crltf'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_crltf',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),
		'v_paltf'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_paltf',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),		
		
		//////////////////////////////////////APL//////////////////////////
		'v_gtapl'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_gtapl',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),		
		'v_niapl'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_niapl',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),		
		'v_svapl'=>array(
			'class'=>'CDbConnection',
			'connectionString' => 'pgsql:host=10.10.1.20;port=5432;dbname=ventas_svapl',
			'username' => 'dbmaster',
			'password' => 'aimargt',
			'charset' => 'utf8',
		),		
			
		*/	
				
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
				// uncomment the following to show log messages on web pages
				/*
				array(
					'class'=>'CWebLogRoute',
				),
				*/
			),
		),
		
			
			
	//...
	    'ePdf' => array(
	        'class'         => 'ext.yii-pdf.EYiiPdf',
	        'params'        => array(	        	
	            'HTML2PDF' => array(
	                'librarySourcePath' => 'application.vendor.html2pdf.*',
	                'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
	                'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
	                    'orientation' => 'P', // landscape or portrait orientation
	                    'format'      => 'A4', // format A4, A5, ...
	                    'language'    => 'en', // language: fr, en, it ...
	                    'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
	                    'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
	                    'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
	                )
	            )
	        ),
	    ),
	    //...
	    		
	),

	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>array(
		// this is used in contact page
		'adminEmail'=>'soporte7@aimargroup.com',
	),
);