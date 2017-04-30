
<html>
<head>
	<meta charset="utf-8"/>
</head>
<body>

	<?php include 'block/connect.php' ?>
			<?php
			/*Вивод даних актора*/
			if(isset($_POST['zminna'])) {$zminna=$_POST['zminna'];}
			$result=mysql_query("SELECT * from dt_actors WHERE id='$zminna'");
			$myrow=mysql_fetch_array($result);

			do {
				printf ("<input name='ids'  id='ids' type='text' value='%s' style='display: none;'>", $myrow["id"] );
			}
			while ($myrow=mysql_fetch_array($result));

			?>

</body>
</html>
