<?php include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['workerId'])) {
  $workerId = $_POST['workerId'];
}

if (isset($workerId)) {
  $result = $db1->query("SELECT photo FROM dt_actors WHERE id='$workerId'");
  $result->setFetchMode(PDO::FETCH_ASSOC);
  $workerImage = $result->fetch();
  unlink('../img/'.$workerImage['photo']);

  $sql = 'DELETE FROM dt_actors WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $workerId, PDO::PARAM_STR);
  $response = $result->execute();
  if ($response == 'true') {
    echo "Рядок видалено";
  } else {
    echo "Помилка";
  }
} else {
  echo "Заповніть всі поля";
}
