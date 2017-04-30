<?php include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['countryId'])) {
  $countryId = $_POST['countryId'];
  if ($countryId == '') unset($countryId);
}

$result = $db1->query("SELECT * FROM dt_actors
                       WHERE id_n = ($countryId)");
while ($row = $result->fetch()) {
  printf ("<option value='%s'>%s</option>", $row["id"],$row["name"]);
}
