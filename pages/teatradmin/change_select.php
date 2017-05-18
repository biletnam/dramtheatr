<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['spectacleCategory'])) {
  $spectacleCategory = $_POST['spectacleCategory'];
  if ($spectacleCategory == '') unset($spectacleCategory);
  echo $spectacleCategory;
}

$result = $db1->query("SELECT * FROM dt_vistava
                       WHERE id_rep='$spectacleCategory'");
echo "<option>Виберіть виставу</option>";
while ($row = $result->fetch()) {
  printf ("<option value='%s'>%s</option>", $row["id"],$row["nazva"]);
}
