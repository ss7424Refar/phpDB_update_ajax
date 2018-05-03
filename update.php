<?php
/**
 * Created by PhpStorm.
 * User: refar
 * Date: 18-5-3
 * Time: 上午10:51
 */

require_once "connection.php";

$id = $_POST['upId'];
$name = $_POST['upName'];
$sex = $_POST["upSex"];
$age = $_POST['upAge'];

$sql = "update student set name ='{$name}' , sex = '{$sex}', age = '{$age}' where id = {$id}";

if (mysqli_query($conn, $sql)) {
    echo "success";
} else {
    echo "failed";
}