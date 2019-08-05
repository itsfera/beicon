<?php

use himiklab\sitemap\behaviors\SitemapBehavior;

$params = require __DIR__ . '/params.php';
$db = require __DIR__ . '/db.php';

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'language' => 'ru-RU',
    'modules' => [
        'sitemap' => [
            'class' => 'himiklab\sitemap\Sitemap',
            'models' => [
                'models\Articles',
            ],
            'urls' => [
                // your additional urls
                [
                    'loc' => '/news',
                    'changefreq' => SitemapBehavior::CHANGEFREQ_DAILY,
                    'priority' => 0.8,
                    'news' => [
                        'publication' => [
                            'name' => 'Example Blog',
                            'language' => 'en',
                        ],
                        'access' => 'Subscription',
                        'genres' => 'Blog, UserGenerated',
                        'publication_date' => 'YYYY-MM-DDThh:mm:ssTZD',
                        'title' => 'Example Title',
                        'keywords' => 'example, keywords, comma-separated',
                        'stock_tickers' => 'NASDAQ:A, NASDAQ:B',
                    ],
                    'images' => [
                        [
                            'loc' => 'http://example.com/image.jpg',
                            'caption' => 'This is an example of a caption of an image',
                            'geo_location' => 'City, State',
                            'title' => 'Example image',
                            'license' => 'http://example.com/license',
                        ],
                    ],
                ],
            ],
            'enableGzip' => true, // default is false
            'cacheExpire' => 1, // 1 second. Default is 24 hours
        ]
    ],
    'components' => [
        'socialShare' => [
            'class' => \ymaker\social\share\configurators\Configurator::class,
            'socialNetworks' => [
                'facebook' => [
                    'class' => \ymaker\social\share\drivers\Facebook::class,
                    'label' => Yii::t('app', 'Facebook'),
                    'options' => ['class' => 'fb'],
                ],
                'Vkontakte' => [
                    'class' => \ymaker\social\share\drivers\Vkontakte::class,
                    'label' => Yii::t('app', 'ВКонтакте'),
                    'options' => ['class' => 'vk'],
                ],
                'twitter' => [
                    'class' => \ymaker\social\share\drivers\Twitter::class,
                    'label' => Yii::t('app', 'Twitter'),
                    'options' => ['class' => 'tw'],
                    'config' => [
                        'account' => $params['twitterAccount']
                    ],
                ],
                'Odnoklassniki' => [
                    'class' => \ymaker\social\share\drivers\Odnoklassniki::class,
                    'label' => Yii::t('app', 'Одноклассники'),
                    'options' => ['class' => 'ok'],
                ],

            ],
            'options' => [
                'class' => 'social-network',
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => []
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [],
                ],
            ],
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '1Eg9w2-LX8Q5K5GI_4MN4ZaQqpMnPDjR',
            'baseUrl' => '',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => false,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'image' => [
            'class' => 'yii\image\ImageDriver',
            'driver' => 'GD',  //GD or Imagick
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'response' => [
            'class' => 'yii\web\Response',
            'on beforeSend' => function ($event) {
                if (Yii::$app->response->statusCode == 401) {

                    Yii::$app->response->headers->add('Access-Control-Allow-Origin', '*');
                    Yii::$app->response->statusCode = 401;//I preferred that error code
                }
            },

        ],
        'db' => $db,
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'enableStrictParsing' => true,
            'rules' => [
                // ...
                'OPTIONS <path:.+>' => 'site/index',

                ['class' => 'yii\rest\UrlRule', 'controller' => 'mnus', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'category', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'page', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'gallery', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'galleryitem', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'persons', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'rsocials', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'meta', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'notifies', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'seo', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'marketing', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                'POST api/seodel' => 'seo/del',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'subscribers', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'rss', 'prefix' => 'api', 'only' => ['delete', 'create', 'update', 'view', 'index']],
                //        ['class' => 'yii\rest\UrlRule', 'controller' => 'rss', 'patterns' => ['PUT,PATCH {id}' => 'update', 'DELETE {id}' => 'delete', 'GET,HEAD {id}' => 'view', 'POST' => 'create', 'GET,HEAD' => 'index', '{id}' => 'options', '' => 'options'], 'prefix' => 'api'],
                ['pattern' => 'sitemap', 'route' => 'sitemap/default/index', 'suffix' => '.xml'],
                '/' => 'site/index',
                'login' => 'site/login',
                'logout' => 'site/logout',
                'test' => 'rarticles/test',
                'GET uploadold' => 'image/old',
                'POST api/gis' => 'galleryitem/sorting',
                'POST api/login' => 'page/apilog',
                'GET api/getuser' => 'user/get',
                'GET api/changepass' => 'user/changepass',
                'api/image_upload' => 'image/index',
                'GET api/recomended/<id>' => 'rarticles/recomended',
                'GET api/catSections/<id>' => 'rarticles/categories',
                'GET api/articlerss/<id>' => 'rarticles/rss',
                'POST api/articlerss/<id>' => 'rarticles/rssupdate',
                'POST api/recomended/<id>' => 'rarticles/recupdate',
                'POST api/catupdate/<id>' => 'rarticles/catupdate',

                "search/" => 'articles/search',
                "search/<query>" => 'articles/search',
                'articles/<url>/preview' => 'articles/preview',
                'tags/<url>/' => 'tags/view',
                'rss/<url>/' => 'site/rss',

                'page/<url>/' => 'p/view',
                ['class' => 'yii\rest\UrlRule', 'controller' => 'rsections', 'patterns' => ['PUT,PATCH {id}' => 'update', 'DELETE {id}' => 'delete', 'GET,HEAD {id}' => 'view', 'POST' => 'create', 'GET,HEAD' => 'index', '{id}' => 'options', '' => 'options'], 'prefix' => 'api'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'user', 'only' => ['delete', 'create', 'update', 'view', 'index'], 'prefix' => 'api'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'rtags', 'only' => ['delete', 'create', 'update', 'view', 'index'], 'prefix' => 'api'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'rarticles', 'only' => ['delete', 'create', 'update', 'view', 'index'], 'prefix' => 'api'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'pnews', 'only' => ['delete', 'create', 'update', 'view', 'index'], 'prefix' => 'api'],
                ['class' => 'yii\rest\UrlRule', 'controller' => 'isizes', 'only' => ['delete', 'create', 'update', 'view', 'index'], 'prefix' => 'api'],

                'sitemap.xml' => 'site/sitemap', //карта сайта
                'sitemap' => 'site/sitemap-html', //карта сайта
                'robots.txt' => 'site/robots', //карта сайта
                '<url>.rss' => 'rss/index',
                '<section>/<url>/' => 'articles/view',
                '<url>' => 'sections/view',

            ],
        ],
//        'urlManager' => [
//            'enablePrettyUrl' => true,
//            'showScriptName' => false,
//            'enableStrictParsing' => false,
//            'rules' => [
//            ],
//        ],

    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '178.121.149.245'],
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        // uncomment the following to add your IP if you are not connecting from localhost.
        'allowedIPs' => ['127.0.0.1', '178.121.149.245'],
    ];
}

return $config;
