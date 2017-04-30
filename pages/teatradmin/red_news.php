<?php

include("block/connect.php");

// Get form data
if (isset($_POST['zmtema'])) {
  $tema = $_POST['zmtema'];
  if ($tema == '') unset($tema);
}
if (isset($_POST['edit_short_content'])) {
  $editShortContent = $_POST['edit_short_content'];
  if ($editShortContent == '') unset($editShortContent);
}
if (isset($_POST['zmtxt'])) {
  $txt = $_POST['zmtxt'];
  if ($txt == '') unset($txt);
}
if (isset($_POST['zmdate'])) {
  $date = $_POST['zmdate'];
  if ($date == '') unset($date);
}
if (isset($_POST['zmid'])) {
  $id = $_POST['zmid'];
}

// Delete special chars from string. Obsolete since PHP 5.5.0
$tema = mysql_real_escape_string($tema);
$editShortContent = mysql_real_escape_string($editShortContent);
$txt = mysql_real_escape_string($txt);

// Insert data into database
if (isset($tema) &&
    isset($editShortContent) &&
    isset($txt) &&
    isset($date) &&
    isset($id)){
  $mys = mysql_query("UPDATE dt_news
                      SET tema='$tema', short_content='$editShortContent',
                          txt='$txt', date='$date'
                      WHERE id='$id'");

    if ($mys == 'true') {
      echo "Дані оновлено";
    } else {
      echo "Помилка оновлення даних";
    }

  }
