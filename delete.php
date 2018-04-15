<?php
/**
 * Created by PhpStorm.
 * User: refar
 * Date: 18-4-15
 * Time: 下午2:21
 */

require_once "connection.php";

$deleteIDArray = $_POST['id'];
$hasError = false;

for ($i = 0; $i < count($deleteIDArray); $i++){
    $sql = "delete from student where id = ". $deleteIDArray[$i];
    mysqli_query($conn, $sql);

    if (mysqli_affected_rows($conn) == 0) {
        $hasError = true;
    }

}
echo json_encode($hasError);