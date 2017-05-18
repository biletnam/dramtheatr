<?php
header("Location: /pages/protected_rep.php");
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['updateSpectacleId'])) {
  $updateSpectacleId = $_POST['updateSpectacleId'];
  if ($updateSpectacleId == '') unset($updateSpectacleId);
}
if (isset($_POST['updateType'])) {
  $updateType = $_POST['updateType'];
  if ($updateType == '') unset($updateType);
}
if (isset($_POST['updateTitle'])) {
  $updateTitle = $_POST['updateTitle'];
  if ($updateTitle == '') unset($updateTitle);
}
if (isset($_POST['updateDuration'])) {
  $updateDuration = $_POST['updateDuration'];
  if ($updateDuration == '') unset($updateDuration);
}
if (isset($_POST['updateAuthor'])) {
  $updateAuthor = $_POST['updateAuthor'];
  if ($updateAuthor == '') unset($updateAuthor);
}
if (isset($_POST['updateDescription'])) {
  $updateDescription = $_POST['updateDescription'];
  if ($updateDescription == '') unset($updateDescription);
}
if (isset($_POST['oldSpectacleImage'])) {
  $oldSpectacleImage = $_POST['oldSpectacleImage'];
  if ($oldSpectacleImage == '') unset($oldSpectacleImage);
}

if (is_uploaded_file($_FILES["updateImage"]["tmp_name"])) {
  $uploaddir='../img/';
  unlink($uploaddir.$oldSpectacleImage);
  $temp = explode(".", $_FILES["updateImage"]["name"]);
  $extension = end($temp);
  $imageFileName = uniqid() . "." . $extension;
  move_uploaded_file($_FILES['updateImage']['tmp_name'], $uploaddir.$imageFileName);
} else {
  $imageFileName = $oldSpectacleImage;
}

if (isset($updateSpectacleId) &&
    isset($updateAuthor) &&
    isset($updateDuration) &&
    isset($updateTitle) &&
    isset($updateType) &&
    isset($updateDescription)) {
  $sql = 'UPDATE dt_vistava
          SET nazva = :nazva, avtor = :avtor, times = :times,
              photo = :photo, tip = :tip, opis = :opis
          WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $updateSpectacleId, PDO::PARAM_STR);
  $result->bindParam(':nazva', $updateTitle, PDO::PARAM_STR);
  $result->bindParam(':avtor', $updateAuthor, PDO::PARAM_STR);
  $result->bindParam(':times', $updateDuration, PDO::PARAM_STR);
  $result->bindParam(':photo', $imageFileName, PDO::PARAM_STR);
  $result->bindParam(':tip', $updateType, PDO::PARAM_STR);
  $result->bindParam(':opis', $updateDescription, PDO::PARAM_STR);
  $response1 = $result->execute();

  }
