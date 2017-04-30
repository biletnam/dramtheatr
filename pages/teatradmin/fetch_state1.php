<?php
 $connect = mysqli_connect("localhost", "cdda-ws15137", "e812129988", "cdda-ws15137");
 $output = '';
 $sql = "SELECT * FROM dt_actors where id_n = '".$_POST["countryId"]."' ORDER BY name";  
 $result = mysqli_query($connect, $sql);
 $output = '<option value="">Select Worker</option>';

 while($row = mysqli_fetch_array($result))
 {
      $output .= '<option value="'.$row["id"].'">'.$row["name"].'</option>';

 }

 echo $output;

 ?>
