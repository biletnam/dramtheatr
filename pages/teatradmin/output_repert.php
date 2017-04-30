<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['spectacle'])) {
	$spectacle = $_POST['spectacle'];
}

$result = $db1->query("SELECT * FROM dt_vistava WHERE id='$spectacle'");
$spectacleInfo = $result->fetch();

$result = $db1->query("SELECT dt_actors_vistava.sorts, dt_actors_vistava.role,
											 				dt_actors_vistava.id_v,  dt_actors_vistava.id_a,
															dt_actors.id, dt_actors.name, dt_actors.id_n
											 FROM  	dt_actors_vistava, dt_actors
											 WHERE 	dt_actors_vistava.id_a='$spectacle'
											 AND   	dt_actors_vistava.id_v=dt_actors.id");
$roles = $result->fetch();

$result = $db1->query("SELECT * FROM dt_actors");
$actors = array();
$i = 0;
while ($row = $result->fetch()) {
  $actors[$i]['id'] = $row['id'];
  $actors[$i]['id_n'] = $row['id_n'];
  $actors[$i]['name'] = $row['name'];
  $actors[$i]['sorts'] = $row['sorts'];
  $i++;
}
?>

<div class="container">
	<div class="row">
		<form name='send' id='send'>
		<input name='ids_s' id='ids_s' type='hidden'
					 value='<?php echo $spectacleInfo['id']; ?>'>
		<input name='idn_n' id='idn_n' type='hidden'
					 value='<?php echo $spectacleInfo['id_rep']; ?>'>
		<br><p>Назва вистави:</p>
		<input type='text' id='nazvas' name='nazvas' size='100'
					 value='<?php echo $spectacleInfo['nazva']; ?>'>
		<br><p>Автор вистави:</p>
		<input type='text' id='avtors' name='avtors' size='100'
					 value='<?php echo $spectacleInfo['avtor']; ?>'>
		<br><p>Тип вистави:</p>
		<input type='text' id='tips' name='tips' size='100'
					 value='<?php echo $spectacleInfo['tip']; ?>'>
		<br><p>Тривалість вистави:</p>
		<input type='text' id='timess' name='timess' size='100'
					 value='<?php echo $spectacleInfo['times']; ?>'>
		<br><p>Опис та Актори:</p>
		<div id='txtt'><?php echo $spectacleInfo['opis']; ?></div>

		<?php if ($roles['role']): ?>
			<div class='col-md-6 col-sm-6'>
				<input type='text' size='2' name='idska'
							 class='idska' id='idska'
							 value='<?php echo $roles['sorts']; ?>'>
				<input type='text' size='10' class='mytxt'
							 id='<?php echo $roles['id_v']; ?>'
							 value='<?php echo $roles['role']; ?>'>
				<input alt='<?php echo $roles['id_n']; ?>' name='checkbox1'
							 id='<?php echo $roles['id']; ?>' class='my-checkbox'
							 type='checkbox'
							 value='<?php echo $roles['name']; ?>'>
					<?php echo $roles['name']; ?>
				</input>
			</div>
			</form>
		<?php else: ?>
			<div class='col-md-4 col-sm-6'>
				<input type='text' size='2' name='idska'
							 class='idska' id='idska'
							 value='<?php echo $roles['sorts']; ?>'>
				<input type='text' size='10' class='mytxt'
							 id='<?php echo $roles['id_v']; ?>'
							 value='<?php echo $roles['role']; ?>'>
				<input alt='<?php echo $roles['id_n']; ?>' name='checkbox1'
							 id='<?php echo $roles['id']; ?>' class='my-checkbox'
							 type='checkbox'
							 value='<?php echo $roles['name']; ?>'>
					<?php echo $roles['name']; ?>
				</input>
			</div>
			</form>
		<?php endif; ?>

		<?php foreach ($actors as $actor): ?>
			<div  class='col-md-6 col-sm-6'>
				<input type='text' size='2' name='idska' class='idska'
							 id='idska' value='<?php echo $actor['sorts']; ?>'>
				<input type='text' size='15' class='mytxt'
							 id='<?php echo $actor['id']; ?>'>
				<input alt='<?php echo $actor['id_n']; ?>' name='checkbox'
							 id='<?php echo $actor['id']; ?>' class='my-checkbox'
							 type='checkbox'>
					<?php echo $actor['name']; ?>
				</input>
			</div>
		<?php endforeach; ?>

	</div>
</div>

<script>
$(document).ready(function() {
	$('#txtt').summernote({
		height: 300
	});
});
</script>
