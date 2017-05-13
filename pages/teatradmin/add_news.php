<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['articleTitle'])) {
  $articleTitle = $_POST['articleTitle'];
  if ($articleTitle == '') unset($articleTitle);
}
if (isset($_POST['shortcontent'])) {
  $shortContent = $_POST['shortcontent'];
  if ($shortContent == '') unset($shortContent);
}
if (isset($_POST['zminnadate'])) {
  $zminnadate = $_POST['zminnadate'];
  if ($zminnadate == '') unset($zminnadate);
}
if (isset($_POST['zminnatxt'])) {
  $zminnatxt = $_POST['zminnatxt'];
  if ($zminnatxt == '') unset($zminnatxt);
}

if (isset($articleTitle) &&
    isset($shortContent) &&
    isset($zminnadate) &&
    isset($zminnatxt)) {
  $sql = 'INSERT INTO dt_news (tema, short_content, date, txt)
          VALUES (:tema, :short_content, :date, :txt)';
  $result = $db1->prepare($sql);
  $result->bindParam(':tema', $articleTitle, PDO::PARAM_STR);
  $result->bindParam(':short_content', $shortContent, PDO::PARAM_STR);
  $result->bindParam(':date', $zminnadate, PDO::PARAM_STR);
  $result->bindParam(':txt', $zminnatxt, PDO::PARAM_STR);
  $response = $result->execute();

  $result = $db1->query("SELECT id FROM dt_news WHERE tema = '$articleTitle'");
  $result->setFetchMode(PDO::FETCH_ASSOC);
  $articleId = $result->fetch();

  $sql = 'INSERT INTO dt_photo (photo, id_act, id_vist, id_new, category)
          VALUES (:photo, :id_act, :id_vist, :id_new, :category)';
  $result = $db1->prepare($sql);
  $photo = 'b6.jpg';
  $actorId = '0';
  $spectacleId = '0';
  $category = '1';
  $result->bindParam(':photo', $photo, PDO::PARAM_STR);
  $result->bindParam(':id_act', $actorId, PDO::PARAM_STR);
  $result->bindParam(':id_vist', $spectacleId, PDO::PARAM_STR);
  $result->bindParam(':id_new', $articleId['id'], PDO::PARAM_STR);
  $result->bindParam(':category', $category, PDO::PARAM_STR);
  $response = $result->execute();

  if ($response == 'true') {
    echo "Рядок добавлений!";
  } else {
    echo "Помилка";
  }
} else {
  echo "Заповніть всі поля";
}
