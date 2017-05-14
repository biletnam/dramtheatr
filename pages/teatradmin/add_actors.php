<?php
header("Location: /pages/protected.php");
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['createWorkerName'])) {
  $createWorkerName = $_POST['createWorkerName'];
  if ($createWorkerName == '') unset($createWorkerName);
}
if (isset($_POST['createWorkerCategory'])) {
  $createWorkerCategory = $_POST['createWorkerCategory'];
  if ($createWorkerCategory == '') unset($createWorkerCategory);
} else {
  $createWorkerCategory = 1;
}
if (isset($_POST['createWorkerPosition'])) {
  $createWorkerPosition = $_POST['createWorkerPosition'];
  if ($createWorkerPosition == '') unset($createWorkerPosition);
}
if (isset($_POST['createWorkerMerit'])) {
  $createWorkerMerit = $_POST['createWorkerMerit'];
  if ($createWorkerMerit == '') unset($createWorkerMerit);
}

if (isset($_POST['createWorkerRank'])) {
  $createWorkerRank = $_POST['createWorkerRank'];
  if ($createWorkerRank == '') {
    $result = $db1->query("SELECT
      MAX(sort) AS max
      FROM dt_actors
      WHERE id_n = $createWorkerCategory");
    $row = $result->fetch();
    $createWorkerRank = $row['max'] + 1;
  }
}

if (is_uploaded_file($_FILES["createWorkerImage"]["tmp_name"])) {
  $uploaddir='../img/';
  $temp = explode(".", $_FILES["createWorkerImage"]["name"]);
  $extension = end($temp);
  $imageFileName = uniqid() . "." . $extension;
  move_uploaded_file($_FILES['createWorkerImage']['tmp_name'], $uploaddir.$imageFileName);
} else {
  $imageFileName = "b6.jpg";
}

if (isset($createWorkerName)) {
  $sql = 'INSERT INTO dt_actors (name, id_n, posada, txt, sort, photo)
          VALUES (:name, :id_n, :posada, :txt, :sort, :photo)';
  $result = $db1->prepare($sql);
  $result->bindParam(':name', $createWorkerName, PDO::PARAM_STR);
  $result->bindParam(':id_n', $createWorkerCategory, PDO::PARAM_STR);
  $result->bindParam(':posada', $createWorkerPosition, PDO::PARAM_STR);
  $result->bindParam(':txt', $createWorkerMerit, PDO::PARAM_STR);
  $result->bindParam(':sort', $createWorkerRank, PDO::PARAM_STR);
  $result->bindParam(':photo', $imageFileName, PDO::PARAM_STR);
  $response = $result->execute();
}
