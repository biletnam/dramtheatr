<?php include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['workerCategory'])) {
  $workerCategory = $_POST['workerCategory'];
  if ($workerCategory == '') unset($workerCategory);
}
if (isset($_POST['workerId'])) {
  $workerId = $_POST['workerId'];
  if ($workerId == '') unset($workerId);
}

$result = $db1->query("SELECT * FROM dt_actors WHERE id_n = ($workerCategory) ORDER BY name ASC");
echo "<option>Виберіть працівника</option>";
while ($row = $result->fetch()) {
  if ($workerId == $row["id"]) {
    printf ("<option value='%s' selected>%s</option>", $row["id"],$row["name"]);
  } else {
    printf ("<option value='%s'>%s</option>", $row["id"],$row["name"]);
  }
}
