<?php
/**
 * Created by PhpStorm.
 * User: hwbaker
 * Date: 2018/5/28
 * Time: 18:34
 */

class HomeController extends BaseController
{

    public function home()
    {
        $ware = Warehouse::lists();
        require dirname(__FILE__).'/../views/home.php';
    }
}