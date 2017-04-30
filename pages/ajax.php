<?php
$db = mysql_pconnect('localhost', 'cdda-ws15137', 'e812129988');
mysql_select_db('cdda-ws15137');

/* для решения проблемы с русскими символами */
mysql_query("SET NAMES 'utf8'");
$start = $_POST['start'];
$end = $_POST['end'];
$type = $_POST['type'];
$op = $_POST['op'];
$id = $_POST['id'];

switch ($op) {
	case 'add':
		$sql = 'INSERT INTO dt_vistava (start, end, type)
      			VALUES ("' . date("Y-m-d H:i:s", strtotime($start)) . '",
      			"' . date("Y-m-d H:i:s", strtotime($end)) . '",
      			"' . $type . ' ")';

		if (mysql_query($sql)) {
			echo mysql_insert_id();
		}
		break;
	case 'edit':
		$sql = 'UPDATE dt_events SET start = "' . date("Y-m-d H:i:s", strtotime($start)) . '",
						end	  = "' . date("Y-m-d H:i:s", strtotime($end)) . '",
						type  = "' . $type . '"
						WHERE id = "' . $id . '"';
		if (mysql_query($sql)) {
			echo $id;
		}
		break;
	case 'source':
		$sql = 'SELECT id, nazva, end, start FROM dt_vistava' ;
		$result = mysql_query($sql);
		$json = Array();
		while ($row = mysql_fetch_assoc($result)) {
		    $json[] = array(
				'id' => $row['id'],
				'title' => $row['nazva'],
				'start' => $row['start'],
				'end' => $row['end'],
				'allDay' => false
			);
		}
		echo json_encode($json);
		break;
	case 'delete':
		$sql = 'DELETE FROM dt_vistava WHERE id = "' . $id . '"';
		if (mysql_query($sql)) {
			echo $id;
		}
		break;
}
