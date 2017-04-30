<div class="container">
	<div class="row">
		<?php
		include 'block/connect.php';
		$db1 = Db::getConnection();
		if (isset($_POST['zminna'])) {
			$zminna = $_POST['zminna'];
		}
		
		$result = $db1->query("SELECT * from dt_actors WHERE id='$zminna'");
		while ($row = $result->fetch()) {
			printf ("
			<input name='ids' id='ids' type='hidden' value='%s'>
			<input name='idn' id='idn' type='hidden' value='%s'><br>
			<p>Порядок сортування:</p>
			<input type='text' id='sort' name='sort' size='7' value='%s'/>
			<p>Прізвище та Імя:</p>
			<input type='text' id='nama' name='nama' size='89' value='%s'/>
			<p>Посада:</p>
			<input type='text' id='posad_a' name='posad_a' size='89' value='%s'/>
			<p>Заслуги:</p>
			<div id='txtt'>%s</div>
			<div id='ot1p'></div>
			<p><form name='send' id='send' action=''><br>
			</p></form>", $row["id"], $row["id_n"],$row["sort"],
										$row["name"], $row["posada"], $row["txt"]);
		}

		$result = $db1->query("SELECT * from dt_vistava");
		while ($row = $result->fetch()) {
			printf ("
			<div class='col-md-6 col-sm-6' style='font-size: 12px'>
				<input alt='%s' name='checkbox' id='%s' class='my-checkbox'
							 type='checkbox' value='%s'> %s</input>
			</div>", $row["id_rep"], $row["id"],$row["nazva"],$row["nazva"]);
		}
		?>
	</div>
</div>

<script>
$(document).ready(function() {
	$('#txtt').summernote({
		height: 300
	});
});
</script>
