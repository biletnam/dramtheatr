<div class="container">
	<div class="row">
		<?php
		include 'block/connect.php';
		$db1 = Db::getConnection();
		if (isset($_POST['workerId'])) {
			$workerId = $_POST['workerId'];
		}

		$result = $db1->query("SELECT * from dt_actors WHERE id='$workerId'");
		while ($row = $result->fetch()) {

?>

<form action="teatradmin/din_up.php" method="post" enctype="multipart/form-data">
	<input name="updateWorkerId" type="text" hidden value="<?php echo $row['id']; ?>">
	<input name="oldWorkerImage" type="text" hidden value="<?php echo $row['photo']; ?>">
	<p>Категорія працівника:</p>
	<select name="updateWorkerCategory" style="width: 100%">
		<option value="1" <?php echo ($row['id_n'] == 1)?"selected":""; ?>>Художньо-керівний склад</option>
		<option value="2" <?php echo ($row['id_n'] == 2)?"selected":""; ?>>Актори</option>
		<option value="3" <?php echo ($row['id_n'] == 3)?"selected":""; ?>>Балет</option>
		<option value="4" <?php echo ($row['id_n'] == 4)?"selected":""; ?>>Оркестр</option>
	</select>
	<p style="margin-top: 5px;">Зображення:</p>
	<input type="file" name="updateWorkerImage">
	<p style="margin-top: 5px;">Порядок сортування:</p>
	<input type="text" name="oldWorkerRank" value="<?php echo $row['sort']; ?>" hidden>
	<input type="text" name="updateWorkerRank" value="<?php echo $row['sort']; ?>" style="width: 100%">
	<p style="margin-top: 5px;">Прізвище та Імя:</p>
	<input type="text" name="updateWorkerName" value="<?php echo $row['name']; ?>" style="width: 100%">
	<p style="margin-top: 5px;">Посада:</p>
	<input type="text" name="updateWorkerPosition" value="<?php echo $row['posada']; ?>" style="width: 100%">
	<p style="margin-top: 5px;">Заслуги:</p>
	<textarea name="updateWorkerMerit" id="updateWorkerMerit"><?php echo $row['txt']; ?></textarea>
	<input type="submit" name="updateWorkerButton" value="Оновити">
</form>

<?php } ?>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#updateWorkerMerit').summernote({
		height: 300
	});
});
</script>
