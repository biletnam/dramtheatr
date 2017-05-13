<?php

include 'block/connect.php';
$db1 = Db::getConnection();

// Get form data
if (isset($_POST['articleId'])) {
  $articleId = $_POST['articleId'];
  if ($articleId == '') unset($articleId);
}
if (isset($_POST['updateArticleTitle'])) {
  $updateArticleTitle = $_POST['updateArticleTitle'];
  if ($updateArticleTitle == '') unset($updateArticleTitle);
}
if (isset($_POST['updateShortContent'])) {
  $updateShortContent = $_POST['updateShortContent'];
  if ($updateShortContent == '') unset($updateShortContent);
}
if (isset($_POST['updateFullContent'])) {
  $updateFullContent = $_POST['updateFullContent'];
  if ($updateFullContent == '') unset($updateFullContent);
}
if (isset($_POST['updateDate'])) {
  $updateDate = $_POST['updateDate'];
  if ($updateDate == '') unset($updateDate);
}

$sql = 'UPDATE dt_news
        SET tema = :tema, short_content = :short_content,
            txt = :txt, date = :date
        WHERE id = :id';
$result = $db1->prepare($sql);
$result->bindParam(':id', $articleId, PDO::PARAM_STR);
$result->bindParam(':tema', $updateArticleTitle, PDO::PARAM_STR);
$result->bindParam(':short_content', $updateShortContent, PDO::PARAM_STR);
$result->bindParam(':txt', $updateFullContent, PDO::PARAM_STR);
$result->bindParam(':date', $updateDate, PDO::PARAM_STR);
$response = $result->execute();
if ($response) {
  echo "Зміни збережено";
} else {
  echo "Помилка бази даних";
}
