<?php

include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['zminnaid'])) {
  $zminnaid = $_POST['zminnaid'];
  if ($zminnaid == '') {
    unset($zminnaid);
  }
}
if (isset($_POST['zminnanazva'])) {
  $zminnanazva = $_POST['zminnanazva'];
  if ($zminnanazva == '') {
    unset($zminnanazva);
  }
}
if (isset($_POST['zminnastart'])) {
  $zminnastart = $_POST['zminnastart'];
  if ($zminnastart == '') {
    unset($zminnastart);
  }
}
if (isset($_POST['znachphotozag'])) {
  $znachphotozag = $_POST['znachphotozag'];
  if ($znachphotozag == '') {
    unset($znachphotozag);
  }
}
if (isset($_POST['znachavtor'])) {
  $znachavtor = $_POST['znachavtor'];
  if ($znachavtor == '') {
    unset($znachavtor);
  }
}
if (isset($_POST['znachtip'])) {
  $znachtip = $_POST['znachtip'];
  if ($znachtip == '') {
    unset($znachtip);
  }
}
if (isset($_POST['znachtimes'])) {
  $znachtimes = $_POST['znachtimes'];
  if ($znachtimes == '') {
    unset($znachtimes);
  }
}
if (isset($_POST['znachrep'])) {
  $znachrep = $_POST['znachrep'];
  if ($znachrep == '') {
    unset($znachrep);
  }
}

$sql = 'INSERT INTO dt_group_afisha
        (id_af, themas, start, photozag, avtor, tip, times, id_rep)
        VALUES (:id_af, :themas, :start, :photozag, :avtor, :tip, :times, :id_rep)';
$result = $db1->prepare($sql);
$result->bindParam(':id_af', $zminnaid, PDO::PARAM_STR);
$result->bindParam(':themas', $zminnanazva, PDO::PARAM_STR);
$result->bindParam(':start', $zminnastart, PDO::PARAM_STR);
$result->bindParam(':photozag', $znachphotozag, PDO::PARAM_STR);
$result->bindParam(':avtor', $znachavtor, PDO::PARAM_STR);
$result->bindParam(':tip', $znachtip, PDO::PARAM_STR);
$result->bindParam(':times', $znachtimes, PDO::PARAM_STR);
$result->bindParam(':id_rep', $znachrep, PDO::PARAM_STR);
$response = $result->execute();
