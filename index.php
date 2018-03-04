<?php
define('TWITS',TRUE);//запрещаем прямой доступ к подключаемым файлам

header("Content-Type:text/html;charset=utf-8");

require_once('vendor/j7mbo/twitter-api-php/TwitterAPIExchange.php');
require 'config.php';

set_include_path(get_include_path()
    .PATH_SEPARATOR.CONTROLLER
    .PATH_SEPARATOR.MODEL
);


function __autoload($class_name){

    if(!include $class_name.'.php'){

        try{
            throw new Exception('Не правильный файл для подключения');
        }
        catch (Exception $e){
            echo $e->getMessage();
        }
    }
}

$obj = new Twits_Controller($settings);
$obj->request();

