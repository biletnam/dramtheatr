<?php
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['zminnaids'])) {
  $id_a = $_POST['zminnaids'];
  if ($id_a == '') unset($id_a);
}
if (isset($_POST['checkedSpectacles'])) {
  $checkedSpectacles = $_POST['checkedSpectacles'];
  if ($checkedSpectacles == '') unset($checkedSpectacles);
}

if (isset($checkedSpectacles) &&
    isset($id_a)) {
  $sql = '';
  foreach ($checkedSpectacles as $key => $value) {
    $sql .= "INSERT INTO dt_vistava_actors (id_a, id_v, id_n)
             VALUES (:id_a$key, :id_v$key, :id_n$key);";
  }
  $result = $db1->prepare($sql);
  foreach ($checkedSpectacles as $key => $value) {
    $result->bindParam(":id_a$key", $id_a, PDO::PARAM_STR);
    $result->bindParam(":id_v$key", $value[0], PDO::PARAM_STR);
    $result->bindParam(":id_n$key", $value[1], PDO::PARAM_STR);
  }
  $response = $result->execute();
  if ($response == 'true') {
    echo "Рядок добавлений!";
  } else {
    echo "Помилка";
  }
} else {
  echo "Заповніть всі поля";
}
