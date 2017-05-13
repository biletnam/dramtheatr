<?php

include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['zminnadeact'])) {
  $zminnadeact = $_POST['zminnadeact'];
  if ($zminnadeact == '') {
    unset($zminnadeact);
  }
}

$sql = 'UPDATE dt_activated
        SET znach = :znach';
$result = $db1->prepare($sql);
$result->bindParam(':znach', $zminnadeact, PDO::PARAM_STR);
$response = $result->execute();
if ($response) {
  echo "Зміни збережено";
} else {
  echo "Помилка бази даних";
}


// if (isset($zminnadeact)) {
//    $mys = mysql_query("UPDATE dt_activated  SET znach='$zminnadeact' ");
//     if ($mys=='true') {
//         echo "OK";            }
//     else {
//         echo "error";
//     }
//     }
// else {
//     echo "errro1";
// }
