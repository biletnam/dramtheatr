<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();

$id = $_GET["id"];
$id_n = $_GET["id_n"];
// $result = mysql_query("SELECT nazva, avtor, times, tip, id, opis FROM dt_vistava WHERE id='$id'",$db);
// $myrow = mysql_fetch_array($result);
// $title = $myrow["nazva"];
// do {
$result = $db1->query("SELECT
  dt_vistava.nazva,
  dt_vistava.avtor,
  dt_vistava.times,
  dt_vistava.tip,
  dt_vistava.id,
  dt_vistava.opis,
  dt_photo.photo
  FROM dt_vistava
  INNER JOIN dt_photo
  ON dt_vistava.id=dt_photo.id_vist
  WHERE dt_vistava.id='$id'");
$result->setFetchMode(PDO::FETCH_ASSOC);
$spectacle = $result->fetch();

$result = $db1->query("SELECT DISTINCT
  dt_actors_vistava.id_v,
  dt_actors_vistava.id_n,
  dt_actors_vistava.sorts,
  dt_actors_vistava.role,
  dt_actors.name
  FROM dt_actors_vistava
  INNER JOIN dt_actors
  ON dt_actors_vistava.id_a=dt_actors.id
  WHERE id_v = '$id'
  ORDER BY dt_actors_vistava.sorts");
$roles = array();
$i = 0;
while ($row = $result->fetch()) {
  $roles[$i]['id_v'] = $row['id_v'];
  $roles[$i]['id_n'] = $row['id_n'];
  $roles[$i]['role'] = $row['role'];
  $roles[$i]['name'] = $row['name'];
  $i++;
}
?>

  <section class="theatre parallax-window-news" data-parallax="scroll"
           data-image-src="/img/news/news-bg.jpg">
    <div class="container">
      <div class='title'>
        <h1><?php echo $spectacle["nazva"]; ?></h1>
        <p><?php echo $spectacle["avtor"]; ?></p>
      </div>
      <div class='personal-inf'>
        <div class='row'>
          <div class='col-md-5 col-sm-5'>
            <figure class='spectacle'>
              <img src='/pages/img/<?php echo $spectacle["photo"]; ?>'
                   height='335' width='223' alt='photo' />
            </figure>
          </div>
          <div class='col-md-7 col-sm-7'>
            <div class='personal-inf-block'>
              <article><?php echo $spectacle["tip"]; ?></article>
              <span><?php echo $spectacle["times"]; ?></span>
              <hr>
              <p><?php echo $spectacle["opis"]; ?></p>
              <table>
                <tbody>
                  <?php foreach ($roles as $role): ?>
                    <tr>
                      <td align="right"><?php echo $role["role"]; ?></td>
                      <td style="padding-left: 20px;">
                        <a class="actor-link"
                           href="/pages/team-person.php?id=<?php echo $role["id_v"]; ?>&id_n=<?php echo $role["id_n"]; ?>">
                          <?php echo $role["name"]; ?>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
              <?php
            //   echo "	<script>
            //   var title='$title';
            //   $(document).attr('title', title);
            //   $(document).$(meta).$(name).$(description).attr('content', title);
            //   </script>";
            // } while ($myrow=mysql_fetch_array($result));
            // $sql = "SELECT DISTINCT id_v, sorts, id_n, role FROM dt_actors_vistava WHERE id_a = '$id' order by sorts ASC";
            // $result = mysql_query($sql) or die(mysql_error());
            // $caption = 'Втілюють в життя: <br><br>';
            //
            // while ($row = mysql_fetch_assoc($result)) {
            //   $id_v = $row['id_v'];
            //   $id_n = $row['id_n'];
            //   $int = 1;
            //
            //   $res = mysql_query("SELECT name, sort FROM dt_actors WHERE id='$id_v'",$db);
            //   $myrow = mysql_fetch_array($res);
            //
            //   if($myrow["name"]) {
            //     echo $caption;
            //     $caption = '';
            //   }
            //   do {
            //     printf("%s - <a class='actor-link' href='/pages/team-person.php?id=$id_v&id_n=$id_n&int=$int'>%s</a><br>", $row["role"], $myrow["name"]);
            //   } while ($myrow=mysql_fetch_array($res));
            // }
            ?>

              <br>
              <div>
                <div class="pluso" data-background="#ebebeb" data-options="medium,round,line,horizontal,counter,theme=06" data-services="vkontakte,odnoklassniki,facebook" data-url="http://teatr.da-wsp.com.ua<?php echo $_SERVER['REQUEST_URI']; ?>"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script type="text/javascript">
  (function() {
    if (window.pluso) {
      if (typeof window.pluso.start == "function") return;
    }
    if (window.ifpluso == undefined) {
      window.ifpluso = 1;
      var d = document,
          s = d.createElement('script'),
          g = 'getElementsByTagName';
      s.type = 'text/javascript';
      s.charset='UTF-8';
      s.async = true;
      s.src = ('https:' == window.location.protocol ? 'https' : 'http') +
               '://share.pluso.ru/pluso-like.js';
      var h = d[g]('body')[0];
      h.appendChild(s);
    }})();
    </script>

  <?php include 'footer.php' ?>
