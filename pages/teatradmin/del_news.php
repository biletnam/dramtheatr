<?php

include 'block/connect.php';

if (isset($_POST['zminnaid'])) {
  $zminnaid = $_POST['zminnaid'];
}

if (isset($zminnaid)) {
  $mys = mysql_query("DELETE FROM dt_news
                      WHERE id='$zminnaid'");
  if ($mys == 'true') {
    echo "Новина видалена";
  } else {
    echo "Помилка видалення з бази даних";
  }
}
