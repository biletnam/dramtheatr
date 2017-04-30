
<html>
<head>

<meta charset="utf-8"/>
</head>
<body>

<?php
include("block/connect.php");
?>

<?php
if(isset($_POST['zmid'])) {$zmid=$_POST['zmid']; if ($zmid=='') {unset($zmid);} }
if(isset($_POST['ztemastart'])) {$ztemastart=$_POST['ztemastart']; if ($ztemastart=='') {unset($ztemastart);} }
if(isset($_POST['ztemaends'])) {$ztemaends=$_POST['ztemaends']; if ($ztemaends=='') {unset($ztemaends);} }
$ztemastart = mysql_real_escape_string($ztemastart);
$ztemaend = mysql_real_escape_string($ztemaend);

if (isset($ztemastart)   && isset($ztemaend)&& isset($zmid)){
   $mys=mysql_query("UPDATE dt_vistava SET start='$ztemastart', end='$ztemaends'  WHERE id='$zmid'");
    if ($mys=='true') {
        echo "Рядок добавлений!";            }
    else {
        echo "error";
    }
    }
else {
    echo "Немає заповнених даних";
}
?>
</body>
</html>
