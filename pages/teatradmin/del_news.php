<?php

include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['articleId'])) {
  $articleId = $_POST['articleId'];
}

if (isset($articleId)) {
  $result = $db1->query("SELECT photo FROM dt_news WHERE id='$articleId'");
  $result->setFetchMode(PDO::FETCH_ASSOC);
  $articleImage = $result->fetch();
  unlink('../img/'.$articleImage['photo']);

  $sql = 'DELETE FROM dt_news WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $articleId, PDO::PARAM_STR);
  $response = $result->execute();
  if ($response) {
    echo "Стаття видалена";
  } else {
    echo "Помилка бази даних";
  }
}
