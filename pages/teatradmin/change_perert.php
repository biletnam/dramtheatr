<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['zminnaids'])) {
  $zminnaids=$_POST['zminnaids'];
  if ($zminnaids=='') unset($zminnaids);
}
if (isset($_POST['zminnatip'])) {
  $zminnatip=$_POST['zminnatip'];
  if ($zminnatip=='') unset($zminnatip);
}
if (isset($_POST['zminnaphotozag'])) {
  $zminnaphotozag=$_POST['zminnaphotozag'];
  if ($zminnaphotozag=='') unset($zminnaphotozag);
}
if (isset($_POST['zminnanazva'])) {
  $zminnanazva=$_POST['zminnanazva'];
  if ($zminnanazva=='') unset($zminnanazva);
}
if (isset($_POST['zminnatimes'])) {
  $zminnatimes=$_POST['zminnatimes'];
  if ($zminnatimes=='') unset($zminnatimes);
}
if (isset($_POST['zminnaavtor'])) {
  $zminnaavtor=$_POST['zminnaavtor'];
  if ($zminnaavtor=='') unset($zminnaavtor);
}
if (isset($_POST['zminnaopis'])) {
  $zminnaopis=$_POST['zminnaopis'];
  if ($zminnaopis=='') unset($zminnaopis);
}
// $zminnatip = mysql_real_escape_string($zminnatip);
// $zminnanazva = mysql_real_escape_string($zminnanazva);
// $zminnaavtor = mysql_real_escape_string($zminnaavtor);
// $zminnatimes = mysql_real_escape_string($zminnatimes);
// $zminnaopis = mysql_real_escape_string($zminnaopis);

if (isset($zminnaids) &&
    isset($zminnaavtor) &&
    isset($zminnatimes) &&
    isset($zminnanazva) &&
    isset($zminnatip) &&
    isset($zminnaphotozag) &&
    isset($zminnaopis)) {
  $sql = 'UPDATE dt_vistava
          SET nazva = :nazva, avtor = :avtor, times = :times,
              photozag = :photozag, tip = :tip, opis = :opis
          WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $zminnaids, PDO::PARAM_STR);
  $result->bindParam(':nazva', $zminnanazva, PDO::PARAM_STR);
  $result->bindParam(':avtor', $zminnaavtor, PDO::PARAM_STR);
  $result->bindParam(':times', $zminnatimes, PDO::PARAM_STR);
  $result->bindParam(':photozag', $zminnaphotozag, PDO::PARAM_STR);
  $result->bindParam(':tip', $zminnatip, PDO::PARAM_STR);
  $result->bindParam(':opis', $zminnaopis, PDO::PARAM_STR);
  $response1 = $result->execute();

  if ($response1) {
    echo "Рядок видалено";
  } else {
    echo "Помилка";
  }

  // $mys=mysql_query("UPDATE dt_vistava
  //                   SET    nazva='$zminnanazva', avtor='$zminnaavtor',
  //                          times='$zminnatimes', photozag='$zminnaphotozag',
  //                          tip='$zminnatip', opis='$zminnaopis'
  //                   WHERE  id='$zminnaids'");
  //   if ($mys == 'true') echo "Рядок успішно редагований";
  //   else echo "error";
  }
