<html>
<head>

<meta charset="utf-8"/>
</head>
<body>

<?php include 'block/connect.php' ?>
<?php
if(isset($_POST['zminnaid'])) {$zminnaid=$_POST['zminnaid'];}
$result=mysql_query("SELECT id,nazva,avtor,times, id_rep, tip,photozag, start
  from dt_vistava WHERE id='$zminnaid'");
$myrow=mysql_fetch_array($result);
do {
 printf ("<p><form name='send' id='send' action=''><br>
<input name='idn'  id='idn' type='hidden' value='%s'> <br>
<input name='photozag'  id='photozag' type='hidden' value='%s'>  <input name='avtor'  id='avtor' type='hidden' value='%s'> <input name='times'  id='times' type='hidden' value='%s'> <input name='tip'  id='tip' type='hidden' value='%s'>
<input name='id_rep'  id='id_rep' type='hidden' value='%s'>
 <br>
<input name='nazva'  id='nazva' type='hidden' value='%s'>
<span>Дата початку</span><br>
<input name='start'  id='start' type='datetime' value='%s' size='100'>


 </p></form> ", $myrow["id"], $myrow["photozag"], $myrow["avtor"],$myrow["times"],$myrow["tip"],$myrow["id_rep"], $myrow["nazva"], $myrow["start"] );
}
while ($myrow=mysql_fetch_array($result));
 ?>
