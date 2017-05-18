  <?php

  if( !ini_get('date.timezone')) {
    date_default_timezone_set('GMT');
  }

  $next_month = (date("m") + 1 > 12) ? 1 : date("m") + 1;
  if ($next_month < 10) {
    $isnol = '0' . $next_month;
  } else {
    $isnol = $next_month;
  }

  switch ($next_month) {
    case 1: $m = 'Січня'; break;
    case 2: $m = 'Лютого'; break;
    case 3: $m = 'Березня'; break;
    case 4: $m = 'Квітня'; break;
    case 5: $m = 'Травня'; break;
    case 6: $m = 'Червня'; break;
    case 7: $m = 'Липня'; break;
    case 8: $m = 'Серпня'; break;
    case 9: $m = 'Вересня'; break;
    case 10: $m = 'Жовтня'; break;
    case 11: $m = 'Листопада'; break;
    case 12: $m = 'Грудня'; break;
  }

  $result = $db1->query("SELECT * FROM dt_group_afisha
    WHERE start LIKE '_____$isnol%' ORDER BY start ASC");

  $i = 1;
  while ($myrow = $result->fetch()) {
    $time = substr($myrow["start"], 11, 5);
    $day = substr($myrow["start"], 8, 2);
    // if ($myrow['id_rep'] == 2) {
    //   $children = 'children/' . $myrow["photozag"];
    // } else {
    //   $children = $myrow["photozag"];
    // }
    if ($i == 1 or $i == 2){
      printf("
      <div class='reper-block reper-block-img' style='position: relative;'>
      <div style='opacity: 1; background: url(/pages/img/$myrow[photozag])center/cover; height:325px; width:350px;'>
      <div class='opaline'><p>$day $m $time</p></div>
      </div>
      </div>
      <a href='/pages/spectacle.php?id=%s&id_n=$myrow[id_rep]&int=$myrow[photozag]'>
      <div class='reper-block reper-block-text'>
      <figure>
      <article>%s</article><br />
      <span>%s</span><br />
      <p>%s</p><br />
      <p>%s</p><br />
      </figure>
      </div>
      </a>", $myrow["id_af"] , $myrow["themas"], $myrow["avtor"], $myrow["tip"], $myrow["times"]);
      $i++;
    } else {
      printf("
      <a href='/pages/spectacle.php?id=%s&id_n=$myrow[id_rep]&int=$myrow[photozag]'>
      <div class='reper-block reper-block-text'>
      <figure>
      <article>%s</article><br />
      <span>%s</span><br />
      <p>%s</p><br />
      <p>%s</p><br />
      </figure>
      </div>
      </a>
      <div class='reper-block reper-block-img' style='position: relative;'>
      <div style='opacity: 1; background: url(/pages/img/$myrow[photozag])center/cover; height:325px; width:350px;'>
      <div class='opaline'><p>$day $m $time</p></div>
      </div>
      </div>", $myrow["id_af"], $myrow["themas"], $myrow["avtor"], $myrow["tip"], $myrow["times"]);
      $i++;
    }
    if ($i == 5) $i = 1;
  }
?>
