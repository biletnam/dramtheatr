<?php
session_start();
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['login'])) {
  $login = $_POST['login'];
  if ($login == '') unset($login);
}
if (isset($_POST['pass'])) {
  $pass = $_POST['pass'];
  if ($pass == '') unset($pass);
}

$currentUserLogin = $_SESSION['login'];
$currentUserPassword = $_SESSION['pass'];
$result = $db1->query("SELECT * FROM dt_userlist
                       WHERE login='$currentUserLogin'
                       AND pass='$currentUserPassword'");
$result->fetch();
if ($result->rowCount() != 1) Header("Location: admin.php");
include 'header-admin.php';
include 'top-line-menu-admin.php';
