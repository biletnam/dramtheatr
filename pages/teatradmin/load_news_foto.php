<?php
include 'block/connect.php';
if (isset($_POST['zminnaid'])) {$zminnaid = $_POST['zminnaid'];}
$result = mysql_query("SELECT * from dt_news WHERE id='$zminnaid'");
$myrow = mysql_fetch_array($result);
do {
  printf ("
  <form name='send' id='send' action=''>
    <input name='idn' id='idn' type='text' value='%s' style='display: none;'>
  </form> ", $myrow["id"]);
}
while ($myrow = mysql_fetch_array($result));
?>
