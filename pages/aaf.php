<html>
<head>
  <meta charset="utf-8"/>
</head>
<body>

  <?php include 'teatradmin/block/connect.php'; ?>
  <?php
  if( ! ini_get('date.timezone') )
  {
    date_default_timezone_set('GMT');
  }
  $next_month = date("m")+1 > 12 ? 1 : date("m")+1;
  if ($next_month<10){
    $isnol='0'.$next_month;
  }

  else {
    $isnol=$next_month;
  }
  $i=1;

  $result=mysql_query("SELECT * from dt_group_afisha WHERE start LIKE '_____$isnol%' ");
  $myrow=mysql_fetch_array($result);

  do{
    $start=substr($myrow["start"],0,16);


    if ($myrow[id_rep]==2){

      $children='children/'.$myrow["photozag"];
    }
    else{
      $children=$myrow["photozag"];
    }
    if ($i==1 or $i==2){
      printf("<!-- block -->
      <div class='reper-block reper-block-img' style='position: relative;'>
      <div style='background: url(/img/spectacle/$children/banner.jpg); height:325px; width:350px;'><!--photozag-->
      <div class='opaline'><p style='opacity: 1;'>$start</p></div>
      </div>
      </div><!-- end reper-block -->
      <a href='/pages/spectacle.php?id=%s&id_n=$myrow[id_rep]&int=$myrow[photozag]'>
      <div class='reper-block reper-block-text'>
      <figure>
      <article>%s</article><br /><!--nazva-->
      <span>%s</span><br /><!--avtor-->
      <p>%s</p><br /><!--tip-->
      <p>%s</p><br /><!--times-->
      </figure>
      </div><!-- end reper-block -->
      </a>
      <!-- end block -->
      <!-- ####################################### -->", $myrow["id_af"], $myrow["themas"], $myrow["avtor"], $myrow["tip"], $myrow["times"]);
      $i=$i+1;
    }
    else {
      printf("<!-- block -->
      <a href='/pages/spectacle.php?id=%s&id_n=$myrow[id_rep]&int=$myrow[photozag]'>
      <div class='reper-block reper-block-text'>
      <figure>
      <article>%s</article><br /><!--nazva-->
      <span>%s</span><br /><!--avtor-->
      <p>%s</p><br /><!--tip-->
      <p>%s</p><br /><!--times-->
      </figure>
      </div><!-- end reper-block -->
      </a>
      <div class='reper-block reper-block-img' style='position: relative;'>
      <div style='background: url(/img/spectacle/$children/banner.jpg); height:325px; width:350px;'><!--photozag-->
      <div class='opaline'><p style='opacity: 1;'>$start</p></div>
      </div>
      </div><!-- end reper-block -->
      <!-- end block -->
      <!-- ####################################### -->", $myrow["id_af"], $myrow["themas"], $myrow["avtor"], $myrow["tip"], $myrow["times"]);
      $i=$i+1;
    }
    if ($i==5) {$i=1;}
  }
  while ($myrow=mysql_fetch_array($result));
  ?>

</div><!-- end reper-list -->

<!-- ####################################### -->

<div class="reper-list reper-list-for-children" id="next">

</body>

</html>
