<?php
// Uncomment to enable debug mode. Recommended for development.
defined('YII_DEBUG') or define('YII_DEBUG', true);
defined('YII_ENV_DEV') or define('YII_ENV_DEV', true);

// Uncomment to enable dev environment. Recommended for development
defined('YII_ENV') or define('YII_ENV', 'prod');

return [
    'components' => [
        'db' => [
            'dsn'       => isset($_ENV['WALLE_DB_DSN'])  ? $_ENV['WALLE_DB_DSN']  : 'mysql:host=10.10.15.118;dbname=walle',
            'username'  => isset($_ENV['WALLE_DB_USER']) ? $_ENV['WALLE_DB_USER'] : 'walle',
            'password'  => isset($_ENV['WALLE_DB_PASS']) ? $_ENV['WALLE_DB_PASS'] : 'walle',
        ],
        'mail' => [
            'transport' => [
                'host'       => isset($_ENV['WALLE_MAIL_HOST']) ? $_ENV['WALLE_MAIL_HOST'] : '10.11.50.63',     # smtp 发件地址
                'username'   => isset($_ENV['WALLE_MAIL_USER']) ? $_ENV['WALLE_MAIL_USER'] : 'mbd_admin',  # smtp 发件用户名
                'password'   => isset($_ENV['WALLE_MAIL_PASS']) ? $_ENV['WALLE_MAIL_PASS'] : 'Alan_201705',       # smtp 发件人的密码
//                'port'       => isset($_ENV['WALLE_MAIL_PORT']) ? $_ENV['WALLE_MAIL_PORT'] : 465,                       # smtp 端口
//                'encryption' => isset($_ENV['WALLE_MAIL_ENCRYPTION']) ? $_ENV['WALLE_MAIL_ENCRYPTION'] : 'ssl',                    # smtp 协议
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
