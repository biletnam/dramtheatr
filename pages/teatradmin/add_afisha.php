<?php include 'block/connect.php' ?>

<html>
<head>

<meta charset="utf-8"/>
</head>
<body>

<?php
if(isset($_POST['zminnaid'])) {$zminnaid=$_POST['zminnaid']; if ($zminnaid=='') {unset($zminnaid);} }
if(isset($_POST['zminnanazva'])) {$zminnanazva=$_POST['zminnanazva']; if ($zminnanazva=='') {unset($zminnanazva);} }
if(isset($_POST['zminnastart'])) {$zminnastart=$_POST['zminnastart']; if ($zminnastart=='') {unset($zminnastart);} }
if(isset($_POST['znachphotozag'])) {$znachphotozag=$_POST['znachphotozag']; if ($znachphotozag=='') {unset($znachphotozag);} }
if(isset($_POST['znachavtor'])) {$znachavtor=$_POST['znachavtor']; if ($znachavtor=='') {unset($znachavtor);} }
if(isset($_POST['znachtip'])) {$znachtip=$_POST['znachtip']; if ($znachtip=='') {unset($znachtip);} }
if(isset($_POST['znachtimes'])) {$znachtimes=$_POST['znachtimes']; if ($znachtimes=='') {unset($znachtimes);} }
if(isset($_POST['znachrep'])) {$znachrep=$_POST['znachrep']; if ($znachrep=='') {unset($znachrep);} }


$zminnanazva = mysql_real_escape_string($zminnanazva);

$result=mysql_query("SELECT id, start,themas from dt_group_afisha");
$myrow=mysql_fetch_array($result);
do {
if ( $zminnastart==$myrow['start'] && $zminnanazva==$myrow['themas']){
echo "Такий запис з такою датою вже існує";
return false;
}

}
while ($myrow=mysql_fetch_array($result));




if (isset($zminnaid)   && isset($zminnanazva)&& isset($zminnastart)){



 $mys=mysql_query("INSERT INTO dt_group_afisha (id_af,themas,start,photozag,avtor,tip,times,id_rep) 
 VALUES ('$zminnaid','$zminnanazva','$zminnastart','$znachphotozag','$znachavtor','$znachtip','$znachtimes','$znachrep')");


 if ($mys=='true') {
        echo "Рядок добавлений!";            }
    else {
        echo "Невірний формат дати або такий запис з датою та часом існує";
    }
    }
else {
    echo "РќРµРјР°С” Р·Р°РїРѕРІРЅРµРЅРёС… РґР°РЅРёС…";
}
?>
</body>
</html>
