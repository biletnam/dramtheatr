<?php include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['zminnaid'])) {
  $zminnaid = $_POST['zminnaid'];
}

if (isset($zminnaid)) {
  $sql = 'DELETE FROM dt_actors WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $zminnaid, PDO::PARAM_STR);
  $response = $result->execute();
  if ($response == 'true') {
    echo "Рядок видалено";
  } else {
    echo "Помилка";
  }
} else {
  echo "Заповніть всі поля";
}
