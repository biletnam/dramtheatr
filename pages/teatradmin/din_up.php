<?php
header("Location: /pages/protected.php");
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['updateWorkerId'])) {
  $updateWorkerId = $_POST['updateWorkerId'];
  if ($updateWorkerId == '') unset($updateWorkerId);
}
if (isset($_POST['updateWorkerCategory'])) {
  $updateWorkerCategory = $_POST['updateWorkerCategory'];
  if ($updateWorkerCategory == '') unset($updateWorkerCategory);
}
if (isset($_POST['updateWorkerMerit'])) {
  $updateWorkerMerit = $_POST['updateWorkerMerit'];
  if ($updateWorkerMerit == '') unset($updateWorkerMerit);
}
if (isset($_POST['updateWorkerName'])) {
  $updateWorkerName = $_POST['updateWorkerName'];
  if ($updateWorkerName == '') unset($updateWorkerName);
}
if (isset($_POST['updateWorkerPosition'])) {
  $updateWorkerPosition = $_POST['updateWorkerPosition'];
  if ($updateWorkerPosition == '') unset($updateWorkerPosition);
}
if (isset($_POST['updateWorkerRank'])) {
  $updateWorkerRank = $_POST['updateWorkerRank'];
  if ($updateWorkerRank == '') unset($updateWorkerRank);
}
if (isset($_POST['oldWorkerRank'])) {
  $oldWorkerRank = $_POST['oldWorkerRank'];
  if ($oldWorkerRank == '') unset($oldWorkerRank);
}
if (isset($_POST['oldWorkerImage'])) {
  $oldWorkerImage = $_POST['oldWorkerImage'];
  if ($oldWorkerImage == '') unset($oldWorkerImage);
}

if (is_uploaded_file($_FILES["updateWorkerImage"]["tmp_name"])) {
  $uploaddir='../img/';
  unlink($uploaddir.$oldWorkerImage);
  $temp = explode(".", $_FILES["updateWorkerImage"]["name"]);
  $extension = end($temp);
  $imageFileName = uniqid() . "." . $extension;
  move_uploaded_file($_FILES['updateWorkerImage']['tmp_name'], $uploaddir.$imageFileName);
} else {
  $imageFileName = $oldWorkerImage;
}

if ($oldWorkerRank != $updateWorkerRank) {
  if ($updateWorkerRank < $oldWorkerRank) {
    $sql = "UPDATE dt_actors SET sort = sort + 1 WHERE id_n = $updateWorkerCategory AND sort >= $updateWorkerRank AND sort <= $oldWorkerRank;
    UPDATE dt_actors SET sort = $updateWorkerRank WHERE id = $updateWorkerId;";
  } else {
    $sql = "UPDATE dt_actors SET sort = sort - 1 WHERE id_n = $updateWorkerCategory AND sort <= $updateWorkerRank AND sort >= $oldWorkerRank;
    UPDATE dt_actors SET sort = $updateWorkerRank WHERE id = $updateWorkerId;";
  }
  $result = $db1->prepare($sql);
  $response = $result->execute();
}

if (isset($updateWorkerId)) {

  $sql = 'UPDATE dt_actors
          SET name = :name, posada = :posada, txt = :txt, sort = :sort, id_n = :id_n, photo = :photo
          WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $updateWorkerId, PDO::PARAM_STR);
  $result->bindParam(':id_n', $updateWorkerCategory, PDO::PARAM_STR);
  $result->bindParam(':name', $updateWorkerName, PDO::PARAM_STR);
  $result->bindParam(':posada', $updateWorkerPosition, PDO::PARAM_STR);
  $result->bindParam(':txt', $updateWorkerMerit, PDO::PARAM_STR);
  $result->bindParam(':sort', $updateWorkerRank, PDO::PARAM_STR);
  $result->bindParam(':photo', $imageFileName, PDO::PARAM_STR);
  $response = $result->execute();
}
