<?php


namespace App\Shop\Core;

use App\Models\Admin\StoreSettings;
use DB;

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
        $params = StoreSettings::all();
        $params->each(function($post){
            self::$app->setProperty($post->param_name, $post->value);
        });
        //orders count on admin panel
        self::$app->setProperty('orders_count', DB::table('orders')->where('status','0')->count());

    }


}