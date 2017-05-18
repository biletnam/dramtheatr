<?php
header("Location: /pages/protected_1.php");
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['createArticleTitle'])) {
  $createArticleTitle = $_POST['createArticleTitle'];
  if ($createArticleTitle == '') unset($createArticleTitle);
}
if (isset($_POST['createArticleShortContent'])) {
  $createArticleShortContent = $_POST['createArticleShortContent'];
  if ($createArticleShortContent == '') unset($createArticleShortContent);
}
if (isset($_POST['createArticleFullContent'])) {
  $createArticleFullContent = $_POST['createArticleFullContent'];
  if ($createArticleFullContent == '') unset($createArticleFullContent);
}
if (isset($_POST['createArticleDate'])) {
  $createArticleDate = $_POST['createArticleDate'];
  if ($createArticleDate == '') unset($createArticleDate);
}

if (is_uploaded_file($_FILES["createArticleImage"]["tmp_name"])) {
  $uploaddir='../img/';
  $temp = explode(".", $_FILES["createArticleImage"]["name"]);
  $extension = end($temp);
  $imageFileName = uniqid() . "." . $extension;
  move_uploaded_file($_FILES['createArticleImage']['tmp_name'], $uploaddir.$imageFileName);
} else {
  $imageFileName = "b6.jpg";
}

if (isset($createArticleTitle) &&
    isset($createArticleShortContent) &&
    isset($createArticleFullContent) &&
    isset($createArticleDate)) {
  $sql = 'INSERT INTO dt_news (tema, short_content, date, txt, photo)
          VALUES (:tema, :short_content, :date, :txt, :photo)';
  $result = $db1->prepare($sql);
  $result->bindParam(':tema', $createArticleTitle, PDO::PARAM_STR);
  $result->bindParam(':short_content', $createArticleShortContent, PDO::PARAM_STR);
  $result->bindParam(':txt', $createArticleFullContent, PDO::PARAM_STR);
  $result->bindParam(':date', $createArticleDate, PDO::PARAM_STR);
  $result->bindParam(':photo', $imageFileName, PDO::PARAM_STR);
  $response = $result->execute();

  // $result = $db1->query("SELECT id FROM dt_news WHERE tema = '$createArticleTitle'");
  // $result->setFetchMode(PDO::FETCH_ASSOC);
  // $articleId = $result->fetch();
  //
  // $sql = 'INSERT INTO dt_photo (photo, id_act, id_vist, id_new, category)
  //         VALUES (:photo, :id_act, :id_vist, :id_new, :category)';
  // $result = $db1->prepare($sql);
  // $photo = 'b6.jpg';
  // $actorId = '0';
  // $spectacleId = '0';
  // $category = '1';
  // $result->bindParam(':photo', $photo, PDO::PARAM_STR);
  // $result->bindParam(':id_act', $actorId, PDO::PARAM_STR);
  // $result->bindParam(':id_vist', $spectacleId, PDO::PARAM_STR);
  // $result->bindParam(':id_new', $articleId['id'], PDO::PARAM_STR);
  // $result->bindParam(':category', $category, PDO::PARAM_STR);
  // $response = $result->execute();

  if ($response == 'true') {
    echo "Рядок добавлений!";
  } else {
    echo "Помилка";
  }
} else {
  echo "Заповніть всі поля";
}
