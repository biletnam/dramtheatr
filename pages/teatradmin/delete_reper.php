<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['zminnaid'])) {
  $zminnaid = $_POST['zminnaid'];
}
if (isset($_POST['zminnaiddel'])) {
  $zminnaiddel = $_POST['zminnaiddel'];
}

if (isset($zminnaid) ||
    isset($zminnaiddel)) {
  $sql = 'DELETE FROM dt_vistava WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $zminnaid, PDO::PARAM_STR);
  $result->execute();
  $sql = 'DELETE FROM dt_group_afisha WHERE id_af = :id_af';
  $result = $db1->prepare($sql);
  $result->bindParam(':id_af', $zminnaiddel, PDO::PARAM_STR);
  $result->execute();
} else {
  echo "Заповніть всі поля";
}
