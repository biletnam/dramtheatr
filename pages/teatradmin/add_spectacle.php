<?php
header("Location: /pages/protected_rep.php");
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['audience'])) {
  $audience = $_POST['audience'];
  if ($audience == '') unset($audience);
}
if (isset($_POST['type'])) {
  $type = $_POST['type'];
  if ($type == '') unset($type);
}
if (isset($_POST['title'])) {
  $title = $_POST['title'];
  if ($title == '') unset($title);
}
if (isset($_POST['author'])) {
  $author = $_POST['author'];
  if ($author == '') unset($author);
}
if (isset($_POST['duration'])) {
  $duration = $_POST['duration'];
  if ($duration == '') unset($duration);
}
if (isset($_POST['description'])) {
  $description = $_POST['description'];
  if ($description == '') unset($description);
}

if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
  $uploaddir='../img/';
  $temp = explode(".", $_FILES["image"]["name"]);
  $extension = end($temp);
  $imageFileName = uniqid() . "." . $extension;
  move_uploaded_file($_FILES['image']['tmp_name'], $uploaddir.$imageFileName);
} else {
  $imageFileName = "b6.jpg";
}

if (isset($type) &&
    isset($title) &&
    isset($author) &&
    isset($duration) &&
    isset($description)) {
  $sql = 'INSERT INTO dt_vistava (id_rep, tip, nazva, avtor, times, opis, photo)
          VALUES (:id_rep, :tip, :nazva, :avtor, :times, :opis, :photo)';
  $result = $db1->prepare($sql);
  $result->bindParam(':id_rep', $audience, PDO::PARAM_STR);
  $result->bindParam(':tip', $type, PDO::PARAM_STR);
  $result->bindParam(':nazva', $title, PDO::PARAM_STR);
  $result->bindParam(':avtor', $author, PDO::PARAM_STR);
  $result->bindParam(':times', $duration, PDO::PARAM_STR);
  $result->bindParam(':opis', $description, PDO::PARAM_STR);
  $result->bindParam(':photo', $imageFileName, PDO::PARAM_STR);
  $response = $result->execute();
}
