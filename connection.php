<?php
/**
 * Created by PhpStorm.
 * User: refar
 * Date: 18-4-14
 * Time: 下午2:35
 */

$host = "localhost";
$username = "root";
$password = "123456";
$database = "ctrl";
$port = "3306";

$conn = mysqli_connect($host, $username, $password, $database, $port);

if (!$conn) {
    die('could not connect'. mysqli_connect_error());
}
mysqli_set_charset($conn,"utf8");
