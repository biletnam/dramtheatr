<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['repertoireSpectacleId'])) {
  $repertoireSpectacleId = $_POST['repertoireSpectacleId'];
}
if (isset($_POST['zminnaiddel'])) {
  $zminnaiddel = $_POST['zminnaiddel'];
}

if (isset($zminnaiddel)) {
  $sql = 'DELETE FROM dt_group_afisha WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $zminnaiddel, PDO::PARAM_STR);
  $result->execute();
} else {
  echo "Заповніть всі поля";
}

if (isset($repertoireSpectacleId)) {
  $sql = 'DELETE FROM dt_vistava WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $repertoireSpectacleId, PDO::PARAM_STR);
  $result->execute();
  $sql = 'DELETE FROM dt_group_afisha WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $repertoireSpectacleId, PDO::PARAM_STR);
  $result->execute();
} else {
  echo "Заповніть всі поля";
}
