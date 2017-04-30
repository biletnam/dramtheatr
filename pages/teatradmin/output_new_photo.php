<?php
include 'block/connect.php';
if(isset($_POST['zminna'])) {$zminna=$_POST['zminna'];}
$result=mysql_query("SELECT * from dt_vistava WHERE id='$zminna'");
$myrow=mysql_fetch_array($result);
do {
	printf ("
	<form name='send' id='send' action=''>
	<input name='ids_s'  id='ids_s' type='text' value='%s' style='display: none;'>
	<input name='idn_n'  id='idn_n' type='text' value='%s' style='display: none;'>
	</form>", $myrow["id"], $myrow["id_rep"]);
}
while ($myrow=mysql_fetch_array($result));
?>
