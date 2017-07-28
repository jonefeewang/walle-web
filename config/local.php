<?php
// Uncomment to enable debug mode. Recommended for development.
defined('YII_DEBUG') or define('YII_DEBUG', false);
defined('YII_ENV_DEV') or define('YII_ENV_DEV', false);

// Uncomment to enable dev environment. Recommended for development
defined('YII_ENV') or define('YII_ENV', 'prod');

return [
    'components' => [
        'db' => [
//            'dsn'       => isset($_ENV['WALLE_DB_DSN'])  ? $_ENV['WALLE_DB_DSN']  : 'mysql:host=10.10.15.118;dbname=walle',
        ],
        'mail' => [
            'transport' => [
            ],
            'messageConfig' => [
                'charset' => 'UTF-8',
                'from'    => [
                  (isset($_ENV['WALLE_MAIL_EMAIL']) ? $_ENV['WALLE_MAIL_EMAIL'] : 'mbd_admin@qiyi.com') => (isset($_ENV['WALLE_MAIL_NAME']) ? $_ENV['WALLE_MAIL_NAME'] : 'mbd_admin'),
                ],  # smtp 发件用户名(须与mail.transport.username一致)
            ],
        ],
        'request' => [
            'cookieValidationKey' => 'PdXWDAfV5-gPJJWRar5sEN71DN0JcDRV',
        ],
    ],
    'language'   => isset($_ENV['WALLE_LANGUAGE']) ? $_ENV['WALLE_LANGUAGE'] : 'zh-CN', // zh-CN => 中文,  en => English
];
