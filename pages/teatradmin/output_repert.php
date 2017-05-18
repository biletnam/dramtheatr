<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['spectacleId'])) {
	$spectacleId = $_POST['spectacleId'];
}

$result = $db1->query("SELECT * FROM dt_vistava WHERE id='$spectacleId'");
$result->setFetchMode(PDO::FETCH_ASSOC);
$spectacle = $result->fetch();
?>

<form action="teatradmin/update_spectacle.php" method="post" enctype="multipart/form-data">
	<input name="updateSpectacleId" type="text" hidden value="<?php echo $spectacle['id']; ?>">
	<input name="oldSpectacleImage" type="text" hidden value="<?php echo $spectacle['photo']; ?>">
	<p style="margin-top: 5px;">Виберіть аудиторію:</p>
	<select name="audience">
		<option value="1" <?php echo ($spectacle['id_rep'] == 1)?"selected":""; ?>>Для дорослих</option>
		<option value="2" <?php echo ($spectacle['id_rep'] == 2)?"selected":""; ?>>Для дітей</option>
	</select>
	<p style="margin-top: 5px;">Назва вистави:</p>
	<input type="text" name="updateTitle" style="width: 100%" value='<?php echo $spectacle['nazva']; ?>'>
	<p style="margin-top: 5px;">Зображення:</p>
	<input type="file" name="updateImage">
	<p style="margin-top: 5px;">Автор вистави:</p>
	<input type="text" name="updateAuthor" style="width: 100%" value='<?php echo $spectacle['avtor']; ?>'>
	<p style="margin-top: 5px;">Тип вистави:</p>
	<input type="text" name="updateType" style="width: 100%" value='<?php echo $spectacle['tip']; ?>'>
	<p style="margin-top: 5px;">Тривалість вистави:</p>
	<input type="text" name="updateDuration" style="width: 100%" value='<?php echo $spectacle['times']; ?>'>
	<p style="margin-top: 5px;">Опис:</p>
	<textarea name="updateDescription"><?php echo $spectacle['opis']; ?></textarea>
	<input type="submit" value="Оновити">
</form>

<div id="crud_role" style="margin-top: 20px;"></div>

<script>
$(document).ready(function() {
	$("textarea[name='updateDescription']").summernote({
		height: 300
	});
	var spectacleId = $("input[name='updateSpectacleId']").val();
	$.ajax({
		url: "teatradmin/crud_role.php",
		method: "POST",
		data: {
			spectacleId: spectacleId
		},
		dataType: "html",
		success: function(data) {
			$("#crud_role").html(data);
		}
	});
});
</script>
