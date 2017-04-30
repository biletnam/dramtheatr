<?php include 'teatradmin/block/connect.php' ?>

<html>
<head>
</head>
<body>

  <?php
  if (isset($_POST['zminnaw'])) {
    $zminnaw = $_POST['zminnaw'];
    if ($zminnaw == '') unset($zminnaw);
  }
  if (isset($_POST['zminnam'])) {
    $zminnam = $_POST['zminnam'];
    if ($zminnam == '') unset($zminnam);
  }
  if (isset($_POST['zminnarole'])) {
    $zminnarole = $_POST['zminnarole'];
    if ($zminnarole == '') unset($zminnarole);
  }

  $result = mysql_query("SELECT * FROM dt_actors ORDER BY id DESC LIMIT 1");
  $myrow = mysql_fetch_array($result);

  $id_a = $myrow["id"];

  $mys = mysql_query("INSERT INTO dt_vistava_actors (id_a, id_v, id_n, role)
                      VALUES ('$id_a', '$zminnaw', '$zminnam', '$zminnarole')");

  if ($mys == 'true') {
    echo "Рядок добавлений!";
  } else {
    echo "error";
  }
  ?>

</body>
</html>
