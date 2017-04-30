<?php include 'teatradmin/block/connect.php' ?>

<?php
if (isset($_POST['zminnaids'])) {
  $zminnaids = $_POST['zminnaids'];
  if ($zminnaids == '') unset($zminnaids);
}

if (isset($_POST['zminnaw'])) {
  $zminnaw = $_POST['zminnaw'];
  if (($zminnaw == '') or ($zminnaw == 0)) unset($zminnaw);
}

if (isset($_POST['zminnam'])) {
  $zminnam = $_POST['zminnam'];
  if (($zminnam == '') or ($zminnam == 0)) unset($zminnam);
}

if (isset($_POST['zminnaroles'])) {
  $zminnaroles = $_POST['zminnaroles'];
  if ($zminnaroles == '') unset($zminnaroles);
}

if (isset($_POST['sortss'])) {
  $sortss = $_POST['sortss'];
  if ($sortss == '') unset($sortss);
}

$result = mysql_query("SELECT * FROM dt_vistava");
$myrow = mysql_fetch_array($result);
$id_a = $myrow["id"];

$mys = mysql_query("UPDATE dt_actors_vistava
                    SET sorts='$sortss', id_a='$zminnaids', id_v='$zminnaw',
                        id_n='$zminnam', role='$zminnaroles'
                    WHERE id_a='$zminnaids' and id_v='$zminnaw'");

?>
