<?php


namespace App\Shop\Core;

class ShopApp
{
    public static $app;

    public static function get_Instance(){
        self::$app = Registry::instance();
        self::getParams();
        return self::$app;
    }

    protected static function getParams(){
        $params = require  CONF . '/params.php';

        if (!empty($params)){
            foreach ($params as $param => $val){
                self::$app->setProperty($param, $val);
            }
        }
    }


}