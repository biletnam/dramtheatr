<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['zminnaids'])) {
  $zminnaids = $_POST['zminnaids'];
  if ($zminnaids == '') unset($zminnaids);
}
if (isset($_POST['zminnatxt'])) {
  $zminnatxt = $_POST['zminnatxt'];
  if ($zminnatxt == '') unset($zminnatxt);
}
if (isset($_POST['zminnaname'])) {
  $zminnaname = $_POST['zminnaname'];
  if ($zminnaname == '') unset($zminnaname);
}
if (isset($_POST['zminnaposada'])) {
  $zminnaposada = $_POST['zminnaposada'];
  if ($zminnaposada == '') unset($zminnaposada);
}
if (isset($_POST['zminnaw'])) {
  $zminnaw = $_POST['zminnaw'];
  if ($zminnaw == '') unset($zminnaw);
}
if (isset($_POST['zminnasort'])) {
  $zminnasort = $_POST['zminnasort'];
  if ($zminnasort == '') unset($zminnasort);
}

if (isset($zminnaids) &&
    isset($zminnaname) &&
    isset($zminnaposada) &&
    isset($zminnatxt) &&
    isset($zminnasort)) {

  $sql = 'UPDATE dt_actors
          SET name = :name, posada = :posada, txt = :txt, sort = :sort
          WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $zminnaids, PDO::PARAM_STR);
  $result->bindParam(':name', $zminnaname, PDO::PARAM_STR);
  $result->bindParam(':posada', $zminnaposada, PDO::PARAM_STR);
  $result->bindParam(':txt', $zminnatxt, PDO::PARAM_STR);
  $result->bindParam(':sort', $zminnasort, PDO::PARAM_STR);
  $response1 = $result->execute();

  $sql = 'DELETE FROM dt_vistava_actors WHERE id_a = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $zminnaids, PDO::PARAM_STR);
  $response2 = $result->execute();

  if ($response1 && $response2) {
    echo "Рядок видалено";
  } else {
    echo "Помилка";
  }
}
