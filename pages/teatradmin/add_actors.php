<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['zminnaname'])) {
  $zminnaname = $_POST['zminnaname'];
  if ($zminnaname == '') unset($zminnaname);
}
if (isset($_POST['zminnww'])) {
  $zminnww = $_POST['zminnww'];
  if ($zminnww == '') unset($zminnww);
}
if (isset($_POST['zminnaposada'])) {
  $zminnaposada = $_POST['zminnaposada'];
  if ($zminnaposada == '') unset($zminnaposada);
}
if (isset($_POST['zminnatxt'])) {
  $zminnatxt = $_POST['zminnatxt'];
  if ($zminnatxt == '') unset($zminnatxt);
}

if (isset($zminnaname)) {
  $sql = 'INSERT INTO dt_actors (name, id_n, posada, txt)
          VALUES (:name, :id_n, :posada, :txt)';
  $result = $db1->prepare($sql);
  $result->bindParam(':name', $zminnaname, PDO::PARAM_STR);
  $result->bindParam(':id_n', $zminnww, PDO::PARAM_STR);
  $result->bindParam(':posada', $zminnaposada, PDO::PARAM_STR);
  $result->bindParam(':txt', $zminnatxt, PDO::PARAM_STR);
  $response = $result->execute();
  if ($response == 'true') {
    echo "Рядок добавлений!";
  } else {
    echo "Помилка";
  }
} else {
  echo "Заповніть всі поля";
}
