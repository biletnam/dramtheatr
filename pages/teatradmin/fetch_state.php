<?php include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['workerCategory'])) {
  $workerCategory = $_POST['workerCategory'];
  if ($workerCategory == '') unset($workerCategory);
}

$result = $db1->query("SELECT * FROM dt_actors WHERE id_n = ($workerCategory) ORDER BY name ASC");
echo "<option>Виберіть працівника</option>";
while ($row = $result->fetch()) {
  printf ("<option value='%s'>%s</option>", $row["id"],$row["name"]);
}
