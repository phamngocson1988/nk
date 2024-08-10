<?php
// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
//define('DS',DIRECTORY_SEPARATOR);
return array(

	'basePath'=>dirname(__FILE__).DS.'..',
	'name'=>'Nha Khoa 2000 - Management',

    'defaultController' => 'home/index',

    'sourceLanguage'=>'00',
    'language'=>'en',

	// preloading 'log' component
	'preload'=>array('log','booster'),

	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
		'application.modules.itemsBranch.models.*',
		'application.modules.itemsCustomers.models.*',
		'application.modules.itemsLocation.models.*',
		'application.modules.itemsProducts.models.*',
		'application.modules.itemsPost.models.*',
		'application.modules.itemsSchedule.models.*',
		'application.modules.itemsService.models.*',
		'application.modules.itemsUsers.models.*',
		'application.modules.itemsSetting.models.*',
		'application.modules.itemsContact.models.*',
		'application.modules.itemsEmail.models.*',
		'application.modules.itemsSales.models.*',
		'application.modules.itemsOpportunity.models.*',
		'application.modules.itemsSeo.models.*',
		'application.modules.itemsCall.models.*',
		'application.modules.itemsReports.models.*',
		'application.modules.itemsAccounting.models.*',
		'application.modules.itemsMedicalRecords.models.*',
		'application.modules.itemsInventory.models.*',
		'application.modules.itemsCustomerService.models.*',

		'application.extensions.CJuiDateTimePicker.CJuiDateTimePicker',
		'application.extensions.crontab.*',

		'ext.easyimage.EasyImage',
	),

	'modules'=>array(
		// uncomment the following to enable the Gii tool

		'gii'=>array(
			'class'=>'system.gii.GiiModule',
			'password'=>'123456',
			// If removed, Gii defaults to localhost only. Edit carefully to taste.
			'ipFilters'=>array('127.0.0.1','113.161.88.6','::1'),
            'generatorPaths'=>array(
                'booster.gii',
            ),
		),

		'itemsDashBoard',
		'itemsUsers',
		'itemsCustomers',
		'itemsSales',
		'itemsAccounting',
		'itemsSchedule',
		'itemsPost',
		'itemsService',
		'itemsBranch',
		'itemsLocation',
		'itemsProducts',
		'itemsQuestionQuick',
		'itemsSetting',
		'itemsContact',
		'itemsEmail',
		'itemsSeo',
		'itemsOpportunity',
		'itemsCall',
		'itemsReports',
		'itemsMedicalRecords',
		'itemsInventory',
		'itemsCustomerService'
	),

	// application components
	'components'=>array(

		'ePdf' => array(
	        'class'         => 'ext.yii-pdf.EYiiPdf',
	        'params'        => array(
	    		'HTML2PDF' => array(
		     		'librarySourcePath' => 'application.vendors.html2pdf.*',
		     		'classFile'         => 'html2pdf.class.php', // For adding to Yii::$classMap
		     		'defaultParams'     => array( // More info: http://wiki.spipu.net/doku.php?id=html2pdf:en:v4:accueil
						'orientation' => 'P', // landscape or portrait orientation
						'format'      => 'A4', // format A4, A5, ...
						'language'    => 'en', // language: fr, en, it ...
						'unicode'     => true, // TRUE means clustering the input text IS unicode (default = true)
						'encoding'    => 'UTF-8', // charset encoding; Default is UTF-8
						'marges'      => array(5, 5, 5, 8), // margins by default, in order (left, top, right, bottom)
					)/**/
	    		)
	   		),
	  	),

		'simpleimage' => array(
            'class' => 'SimpleImage',
        ),

        'easyImage' => array(
		    'class' => 'application.extensions.easyimage.EasyImage',
		    //'driver' => 'GD',
		    //'quality' => 100,
		    //'cachePath' => '/assets/easyimage/',
		    //'cacheTime' => 2592000,
		    //'retinaSupport' => false,
		    //'isProgressiveJpeg' => false,
		 ),

		'user'=>array(
			// enable cookie-based authentication
            'loginUrl'=>array('admin/login'),
			'allowAutoLogin'=>true,
		),

        'booster'=> array(
            'class' => 'ext.booster.components.Booster',
        ),
		// uncomment the following to enable URLs in path-format

		'urlManager'=>array(
			'urlFormat'=>'path',
			    'showScriptName'=>false,
				'rules'=>array(

					''			=>'admin/login',
					'index.php'		=>'admin/login',
					'admin'			=>'admin/login',

					'/home/'                => array('/home/index/lang/en', 'caseSensitive'=>false),
					'/trang-chu/'           => array('/home/index/lang/vi', 'caseSensitive'=>false),

					'/introduce/'           => array('/introduce/index/lang/en', 'caseSensitive'=>false),
					'/gioi-thieu/'          => array('/introduce/index/lang/vi', 'caseSensitive'=>false),

					'/gioi-thieu/hoat-dong-nha-khoa/lang/<lang:\w+>/'          => array('/introduce/detailhoatdongnhakhoa', 'caseSensitive'=>false),

					'/gioi-thieu/hoat-dong-ngoai-khoa/lang/<lang:\w+>/'          => array('/introduce/detailhoatdongngoaikhoa', 'caseSensitive'=>false),
					'/gioi-thieu/clipchuyende/lang/<lang:\w+>/'          => array('/introduce/clipchuyende', 'caseSensitive'=>false),

					'/gioi-thieu/nha-khoa-nhi/lang/<lang:\w+>/'          => array('/introduce/detailnhakhoanhi', 'caseSensitive'=>false),
					'/gioi-thieu/co-so-vat-chat-1/lang/<lang:\w+>/'          => array('/introduce/detailcosovatchat', 'caseSensitive'=>false),

					'/gioi-thieu/co-so-vat-chat-2/lang/<lang:\w+>/'          => array('/introduce/detailcosovatchat2', 'caseSensitive'=>false),

					// '/service/'           	=> array('/service/index/lang/en', 'caseSensitive'=>false),
					// '/dich-vu/'          	=> array('/service/index/lang/vi', 'caseSensitive'=>false),
					'/lien-he/'				=> array('/contact/index/lang/vi','caseSensitive'=>false),
					'/promotion/'           => array('/promotion/index/lang/en', 'caseSensitive'=>false),
					'/khuyen-mai/'          => array('/promotion/index/lang/vi', 'caseSensitive'=>false),
					'/khuyen-mai/<title:[a-zA-Z0-9-]+>-<id:\d+>/lang/<lang:\w+>/' => array('promotion/detailpromotion','caseSensitive'=>false),

					'/product/'				=> array('/shopping/index/lang/en', 'caseSensitive'=>false),
                	'/san-pham/'				=> array('/shopping/index/lang/vi', 'caseSensitive'=>false),
                	'/san-pham/lamsach/lang/<lang:\w+>/'          => array('/shopping/lamsach', 'caseSensitive'=>false),
                	'/san-pham/chamsocrang/lang/<lang:\w+>/'          => array('/shopping/chamsocrang', 'caseSensitive'=>false),
                	'/san-pham/chinhakhoa/lang/<lang:\w+>/'          => array('/shopping/chinhakhoa', 'caseSensitive'=>false),
                	'/san-pham/sanphamkhac/lang/<lang:\w+>/'          => array('/shopping/sanphamkhac', 'caseSensitive'=>false),
                	'/san-pham/chi-tiet/<title:[a-zA-Z0-9-]+>-<id:\d+>/lang/<lang:\w+>/' => array('shopping/detailproduct','caseSensitive'=>false),

                	'/dang-ky/'           => array('/register/index/lang/vi', 'caseSensitive'=>false),
					'/register/'          => array('/register/index/lang/en', 'caseSensitive'=>false),

                	'/advisory/' 				=> array('/news','caseSensitive'=>false),
                	'/tin-tuc/'				=> array('/news/index/lang/vi','caseSensitive'=>false),
                	'/news/'				=> array('/news/index/lang/en', 'caseSensitive'=>false),
                	'/tin-tuc/tin-moi/'				=> array('/news/listAllNews','caseSensitive'=>false),
                	'/tin-tuc/<newsline:[a-zA-Z0-9-]+>/<title:[a-zA-Z0-9-]+>-<id:\d+>/lang/<lang:\w+>/' => array('/news/detailnews','caseSensitive'=>false),

                	'/tin-tuc/<newsline:[a-zA-Z0-9-]+>-<id:\d+>/lang/<lang:\w+>/' =>array('/news/detailType','caseSensitive'=>false),
                	'/faq/<faqline:[a-zA-Z0-9-]+>-<id:\d+>' =>array('/faq/detail','caseSensitive'=>false),
                	'/bang-gia/<price:[a-zA-Z0-9-]+>-<id:\d+>' => array('/service/price','caseSensitive'=>false),

                	//'/dich-vu/<nameline:[a-zA-Z0-9-]+>/<title:[a-zA-Z0-9-]+>-<id:\d+>/lang/<lang:\w+>/' => array('service/servicedetail','caseSensitive'=>false),

                	'/nghe-nghiep/<title:[a-zA-Z0-9-]+>-<id:\d+>/lang/<lang:\w+>/' =>array('career/detailcareer','caseSensitive'=>false),

                	'/tags/<tags:[a-zA-Z0-9-]+>/lang/<lang:\w+>/' => array('/news/tagspost','caseSensitive'=>false),

                	'home/resetpass/<activation>/<passwordnew>' =>array('/home/confirmpass','caseSensitive'=>false),

                	'/chi-tiet/bacsi-<id:\d+>/lang/<lang:\w+>/' =>array('introduce/DetailBacSi','caseSensitive'=>false),
                	//dich vu
                	'/services/'           	=> array('/services/index/lang/en', 'caseSensitive'=>false),
					'/dich-vu/'          	=> array('/services/index/lang/vi', 'caseSensitive'=>false),
					'/dich-vu/<nameline:[a-zA-Z0-9-]+>-<id:\d+>/lang/<lang:\w+>/' => array('services/serviceType','caseSensitive'=>false),
					'/dich-vu-chi-tiet/<name:[a-zA-Z0-9-]+>-<id:\d+>/lang/<lang:\w+>/' => array('services/detail','caseSensitive'=>false),
					//HOIDAP
					'/faq/'           		=> array('/faq/index/lang/en', 'caseSensitive'=>false),
					'/hoi-dap/'          	=> array('/faq/index/lang/vi', 'caseSensitive'=>false),
					'<controller:\w+>/<id:\d+>'=>'<controller>/view',
					'<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
					'<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
					'model/<id:\d+>-<name>.html'=>'model/view',

				),
		),

		// database settings are configured in database.php
		//'db'=>require(dirname(__FILE__).'/database.php'),
        'db'=>array(
            'connectionString' => 'mysql:host=221.121.12.229;dbname=db_hhh_nhakhoa2000',
            'emulatePrepare' => true,
            'username' => 'c10nhakhoa2000',
            'password' => 'dgmFRw2eZdFQ#',
            'charset' => 'utf8',
            //'tablePrefix' => 'tbl_',
        ),

		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'site/error',
		),

		// 'log' => array(
		// 	'class' => 'CLogRouter',
		// 	'routes' => array(
		// 		array(
		// 			'class' => 'CFileLogRoute',
		// 			'levels' => 'error, warning',
		// 			'except' => 'crontab'
		// 		),
		// 		array(
		// 			'class' => 'CFileLogRoute',
		// 			'logFile' => 'crontab'.date('Ym').'.log',
		// 			'categories' => 'crontab'
		// 		),
		// 	),
		// ),
		/* send mail phpMailer */
		'Smtpmail' =>array(
			'class' =>'ext.smtpmail.PHPMailer',
		),
		/* end mail phpMailer */

		/* START SEND SWIFTMAILER */
        'swiftMailer' => array(
            'class' => 'ext.swiftMailer.SwiftMailer',
        ),


		'metadata'=>array('class'=>'Metadata'),

        'themeManager'=>array('basePath'=>dirname(__FILE__).DS.'..'.DS.'themes'),


	),
    'theme'=>'vsc',
	// application-level parameters that can be accessed
	// using Yii::app()->params['paramName']
	'params'=>require(dirname(__FILE__).'/params.php'),

);
