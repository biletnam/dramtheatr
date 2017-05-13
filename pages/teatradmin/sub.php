<?php

header("Location: /pages/photo.php");
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['ids'])) {
	$id_act = $_POST['ids'];
} else {
	$id_act = 0;
}
if (isset($_POST['id_new'])) {
	$id_new = $_POST['id_new'];
} else {
	$id_new = 0;
}
if (isset($_POST['ids_s'])) {
	$id_vist = $_POST['ids_s'];
} else {
	$id_vist = 0;
}
if (isset($_POST['category'])) {
	$category = $_POST['category'];
}

$result = $db1->query("SELECT photo FROM dt_photo");
$filenames = array();
$i = 0;
while ($row = $result->fetch()) {
  $filenames[$i]['photo'] = $row['photo'];
  $i++;
}

$uploaddir='../img/';
$photo = $_FILES['uploadfile']['name'];

if (in_array($photo, $filenames)) {
	echo "Таке фото вже існує!!!";
} else {
	move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploaddir.$photo);

	$result = $db1->query("SELECT id
		FROM dt_photo
		WHERE id_act = '$id_act'
		AND id_vist = '$id_vist'
		AND id_new = '$id_new'");
	$result->setFetchMode(PDO::FETCH_ASSOC);
	$photoId = $result->fetch();

	$sql = 'UPDATE dt_photo
		SET photo = :photo, id_act = :id_act, id_vist = :id_vist,
		id_new = :id_new, category = :category
		WHERE id = :id';
	$result = $db1->prepare($sql);
	$result->bindParam(':id', $photoId['id'], PDO::PARAM_STR);
	$result->bindParam(':photo', $photo, PDO::PARAM_STR);
	$result->bindParam(':id_act', $id_act, PDO::PARAM_STR);
	$result->bindParam(':id_vist', $id_vist, PDO::PARAM_STR);
	$result->bindParam(':id_new', $id_new, PDO::PARAM_STR);
	$result->bindParam(':category', $category, PDO::PARAM_STR);
	$response = $result->execute();
	if ($response) {
	  echo "Фото прикріплене";
	} else {
	  echo "Помилка бази даних";
	}
}
