<?php
/**
 * Created by PhpStorm.
 * User: hwbaker
 * Date: 2018/5/29
 * Time: 13:57
 */

class Warehouse
{
    public static function lists()
    {
        $connect =  new mysqli('127.0.0.1','root','12345678', 'jerp');
        if (!$connect) {
            die('Could not connect: ' . mysqli_connect_error());
        }
        mysqli_query($connect, 'set names latin1');

        $sql = "select * from jerp_warehouse where is_enable = 1";
        $result = $connect->query($sql);
        while($row = $result->fetch_array()){
            $list[]=$row;
        }
        $result->close();
        $connect->close();

        return $list;


//        // 链接数据库 选择数据库
//        $connect = mysqli_connect('127.0.0.1','root','12345678','jerp', '3306') or die('Unale to connect');
//        // 设置显示字符集
//        $sql = "set names latin1";
//        // 执行sql语句
//        $res = mysqli_query($connect, $sql);
//        // 选择数据表
//
//        //查询单条数据并以json的格式输出
//        $sql = "select * from jerp_warehouse";
//        // 执行sql语句返回结果集
//        $result = mysqli_query($connect, $sql);
//
//        $row = mysqli_fetch_row($result);
//        echo  json_encode($row);



    }
}