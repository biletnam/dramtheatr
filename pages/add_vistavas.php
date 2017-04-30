<?php
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['zminnaw'])) {
  $zminnaw = $_POST['zminnaw'];
  if (($zminnaw == '') and ($zminnaw == 0)) unset($zminnaw);
}
if (isset($_POST['zminnam'])) {
  $zminnam = $_POST['zminnam'];
  if (($zminnam == '') and ($zminnam == 0)) unset($zminnam);
}
if (isset($_POST['zminnarole'])) {
  $zminnarole = $_POST['zminnarole'];
  if ($zminnarole == '') unset($zminnarole);
}
if (isset($_POST['sorting'])) {
  $sorting = $_POST['sorting'];
  if ($sorting == '') unset($sorting);
}

$result = $db1->query("SELECT * FROM dt_vistava
                       ORDER BY id DESC LIMIT 1");
$row = $result->fetch();
$id_a = $row["id"];

// $result = mysql_query("SELECT * FROM dt_vistava ORDER BY id DESC LIMIT 1");
// $myrow = mysql_fetch_array($result);
// $id_a = $myrow["id"];

if (($zminnaw != 0) &&
    ($zminnam != 0)) {
  $mys = mysql_query("INSERT INTO dt_actors_vistava (id_a, id_v, id_n, role, sorts)
  VALUES ('$id_a', '$zminnaw', '$zminnam', '$zminnarole', '$sorting')");
  if ($mys == 'true') {
    echo "Рядок добавлений!";
  } else {
    echo "error";
  }
}
