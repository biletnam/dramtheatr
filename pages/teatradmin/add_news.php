<?php

include 'block/connect.php';

// Get form data
if (isset($_POST['zminnatema'])) {
  $zminnatema = $_POST['zminnatema'];
  if ($zminnatema == '') unset($zminnatema);
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
if (isset($_POST['photo_id'])) {
  $photoId = $_POST['photo_id'];
  if ($photoId == '') unset($photoId);
}

// Delete special chars from string. Obsolete since PHP 5.5.0
$zminnatema = mysql_real_escape_string($zminnatema);
$shortContent = mysql_real_escape_string($shortContent);
$zminnatxt = mysql_real_escape_string($zminnatxt);

// Insert data into database
if (isset($zminnatema) &&
    isset($shortContent) &&
    isset($zminnadate) &&
    isset($zminnatxt)) {
  $mys = mysql_query("INSERT INTO dt_news (tema, short_content, date, txt)
  VALUES ('$zminnatema', '$shortContent', '$zminnadate', '$zminnatxt')");
  if ($mys == 'true') {
    echo "Новина опублікована";
  } else {
    echo "Помилка запису до бази даних";
  }
} else {
  echo "Заповніть всі поля";
}

if (isset($photoId)) {

  // Get article id by title
  $result = mysql_query("SELECT id FROM dt_news WHERE tema='$zminnatema'");
  do {
    $idNew = $row['id'];
  } while ($row = mysql_fetch_array($result));
  echo $idNew;

  // Set id_new by article id
  $sql = mysql_query("UPDATE dt_photo SET id_new='$idNew' WHERE id='$photoId'");
}
