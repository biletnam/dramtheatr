<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['zminnww'])) {
  $zminnww = $_POST['zminnww'];
  if ($zminnww == '') unset($zminnww);
}
if (isset($_POST['zminnatip'])) {
  $zminnatip = $_POST['zminnatip'];
  if ($zminnatip == '') unset($zminnatip);
}
if (isset($_POST['zminnanazva'])) {
  $zminnanazva = $_POST['zminnanazva'];
  if ($zminnanazva == '') unset($zminnanazva);
}
if (isset($_POST['zminnaavtor'])) {
  $zminnaavtor = $_POST['zminnaavtor'];
  if ($zminnaavtor == '') unset($zminnaavtor);
}
if (isset($_POST['zminnatimes'])) {
  $zminnatimes = $_POST['zminnatimes'];
  if ($zminnatimes == '') unset($zminnatimes);
}
if (isset($_POST['zminnaopis'])) {
  $zminnaopis = $_POST['zminnaopis'];
  if ($zminnaopis == '') unset($zminnaopis);
}

if (isset($zminnatip) &&
    isset($zminnanazva) &&
    isset($zminnaavtor) &&
    isset($zminnatimes) &&
    isset($zminnaopis)) {
  $sql = 'INSERT INTO dt_vistava (id_rep, tip, nazva, avtor, times, opis)
          VALUES (:id_rep, :tip, :nazva, :avtor, :times, :opis)';
  $result = $db1->prepare($sql);
  $result->bindParam(':id_rep', $zminnww, PDO::PARAM_STR);
  $result->bindParam(':tip', $zminnatip, PDO::PARAM_STR);
  $result->bindParam(':nazva', $zminnanazva, PDO::PARAM_STR);
  $result->bindParam(':avtor', $zminnaavtor, PDO::PARAM_STR);
  $result->bindParam(':times', $zminnatimes, PDO::PARAM_STR);
  $result->bindParam(':opis', $zminnaopis, PDO::PARAM_STR);
  $response = $result->execute();
  if ($response == 'true') {
    echo "Рядок добавлений!";
  } else {
    echo "Помилка";
  }
} else {
  echo "Заповніть всі поля";
}
