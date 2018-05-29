<?php
/**
 * Created by PhpStorm.
 * User: hwbaker
 * Date: 2018/5/28
 * Time: 18:34
 */

class HomeController extends BaseController
{

    public function warehouse()
    {
        $ware = Warehouse::lists();
        require dirname(__FILE__).'/../views/warehouse.php';
    }

    public function company()
    {
        $company = Company::all();
//        foreach ($company as $flight) {
//            echo $flight->system_name;
//        }

        require dirname(__FILE__) . '/../views/company.php';
    }
}