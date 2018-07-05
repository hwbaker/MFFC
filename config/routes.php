<?php
/**
 * Created by PhpStorm.
 * User: hwbaker
 * Date: 2018/5/28
 * Time: 17:08
 */

use NoahBuscher\Macaw\Macaw;

//Macaw::get('/', function() {
//    echo "/";
//});

Macaw::get('/hello', function() {
    echo "hello！";
});

Macaw::get('/warehouse', 'HomeController@warehouse');
Macaw::get('/company', 'HomeController@company');
//Macaw::get('/uploadExcel', 'HomeController@uploadExcel');
//Macaw::get('/phpExcel', 'HomeController@phpExcel');

Macaw::get('/redisHash', 'RedisController@redisHash');
Macaw::get('/redisList', 'RedisController@redisList');
Macaw::get('/redisSort', 'RedisController@redisSort');
Macaw::get('/redisZSort', 'RedisController@redisZSort');
Macaw::get('/redisString', 'RedisController@redisString');

Macaw::get('(:all)', function($fu) {
    echo '未匹配到路由<br>'.$fu;
});

Macaw::dispatch();


