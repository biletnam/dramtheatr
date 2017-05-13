<?php

include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['articleId'])) {
	$articleId = $_POST['articleId'];
}

$result = $db1->query("SELECT * from dt_vistava WHERE id='$articleId'");
$result->setFetchMode(PDO::FETCH_ASSOC);
$article = $result->fetch();
?>

<input name='ids_s' id='ids_s' type='text' value="<?php echo $article['id']; ?>" style='display: none;'>
<input name='idn_n' id='idn_n' type='text' value="<?php echo $article['id_rep']; ?>" style='display: none;'>
