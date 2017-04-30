<?php

header("Location: /pages/photo.php");

$db = mysql_connect("localhost","cdda-ws15137","e812129988") or die ("die");
$res = mysql_select_db("cdda-ws15137",$db);
if(isset($_POST['ids'])) {$ids=$_POST['ids'];}
if(isset($_POST['idn'])) {$idn=$_POST['idn'];}
if(isset($_POST['ids_s'])) {$ids_s=$_POST['ids_s'];}
if(isset($_POST['category'])) {$category=$_POST['category'];}

$result=mysql_query("SELECT photo FROM dt_photo");
$myrow=mysql_fetch_array($result);

do {    $araay[]=$myrow["photo"] ;    }


while ($myrow=mysql_fetch_array($result));
//		 print_r($araay);


					$uploaddir='../img/';

					$fot = $_FILES['uploadfile']['name'];
if (in_array($fot,$araay)){
    echo "Таке фото вже існує!!!";

} else {

				//	if ($fot!=$myrow['photo']) {
					 move_uploaded_file($_FILES['uploadfile']['tmp_name'], $uploaddir.$fot);
					$res= mysql_query ("INSERT INTO dt_photo (photo,id_act,id_vist,id_new,category)
															VALUES ('$fot','$ids','$ids_s','$idn','$category')");
					if ($res=='true') {echo "Рядок успішно добавлений";}

}

while ($myrow=mysql_fetch_array($result));


?>
