<?php
defined('TWITS') or exit('Access denied');

define('HOST','localhost');
define('USER','root');
define('PASSWORD','');
define('DB_NAME','twits_list');

define('CONTROLLER','core/controller');
define('MODEL','core/model');
define('VIEW','template/');
define('SITE_URL','/');

$settings = array(
    'oauth_access_token' => "956602845528248322-pVww19Bd71NuFe2xKuR7YmYldNScFTv",
    'oauth_access_token_secret' => "UDIUpKMWWi9ME2y98ekufsnEflbWPNhBuTxmPZ38CUXPz",
    'consumer_key' => "5kIcOxPoKjCpo0f31wk1AmCVF",
    'consumer_secret' => "DI2lCWJc6F9IHGPoygm7ycAWXVJ5jFoBFhIzZP1Ugb5HsUJqF7"
);

$conf = array(
    'styles' => array(
        'css/style.css',
        'css/font-awesome.css',
        'fonts/FontAwesome.eot',
        'fonts/FontAwesome.svg',
        'fonts/FontAwesome.ttf',
        'fonts/FontAwesome.woff',
        'fonts/FontAwesome.woff2',
    ),
    'scripts' => array(
        'JS/jquery-3.3.1.min.js',
        'JS/script.js',
    )
);