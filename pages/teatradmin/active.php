<?php include 'block/connect.php' ?>

<html>
<head>

<meta charset="utf-8"/>
</head>
<body>

<?php


if(isset($_POST['zminnadeact'])) {$zminnadeact=$_POST['zminnadeact']; if ($zminnadeact=='') {unset($zminnadeact);} }

if (isset($zminnadeact)){
   $mys=mysql_query("UPDATE dt_activated  SET znach='$zminnadeact' ");
    if ($mys=='true') {
        echo "OK";            }
    else {
        echo "error";
    }
    }
else {
    echo "errro1";
}
?>
</body>
</html>
