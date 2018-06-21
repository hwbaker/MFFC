<?php
/**
 * MFFC(My First Framework based on Composer).
 * User: hwbaker
 * Date: 2018/5/28
 * Time: 17:05
 */

use Illuminate\Database\Capsule\Manager as Capsule;

//error_reporting(E_ERROR | E_WARNING | E_NOTICE);
ini_set("display_errors", "On");
// Autoload 自动载入
require '../vendor/autoload.php';

// Eloquent ORM
$capsule = new Capsule;
$capsule->addConnection(require '../config/database.php');
$capsule->bootEloquent();

// 路由配置
require '../config/routes.php';
