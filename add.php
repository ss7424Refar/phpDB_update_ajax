<?php
/**
 * Created by PhpStorm.
 * User: refar
 * Date: 18-5-1
 * Time: 上午11:56
 */

$name = $_POST['name'];
$sex = $_POST['sex'];
$age= $_POST['age'];

// echo $name. "--". $age .$sex;

require_once "connection.php";

$sql = "insert into `student` (`id`, `name`, `age`, `sex`) VALUES (null, '${name}', '${age}', '${sex}')";

if (mysqli_query($conn, $sql)) {
    // insert success
    echo "success";
} else {
    echo "error". "<br>". $sql;
}