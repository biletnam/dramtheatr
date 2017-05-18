<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();

$spectacle_id = $_GET["id"];
$result = $db1->query("SELECT nazva, avtor, times, tip, id, opis, photo
  FROM dt_vistava WHERE id='$spectacle_id'");
$result->setFetchMode(PDO::FETCH_ASSOC);
$spectacle = $result->fetch();

$result = $db1->query("SELECT
  dt_roles.actor_id,
  dt_roles.role,
  dt_actors.name
  FROM dt_roles
  INNER JOIN dt_actors
  ON dt_roles.actor_id = dt_actors.id
  WHERE spectacle_id = '$spectacle_id'
  ORDER BY dt_roles.rank");
$roles = array();
$i = 0;
while ($row = $result->fetch()) {
  $roles[$i]['actor_id'] = $row['actor_id'];
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
                   height='335' width='223' alt='photo'>
            </figure>
          </div>
          <div class='col-md-7 col-sm-7'>
            <div class='personal-inf-block'>
              <article><?php echo $spectacle["tip"]; ?></article>
              <span><?php echo $spectacle["times"]; ?></span>
              <hr>
              <p><?php echo $spectacle["opis"]; ?></p>
              <center>
                <?php if ($roles): ?>
                  <p>Дійові особи та виконавці</p>
                <?php endif; ?>
                <table>
                  <tbody>
                    <?php foreach ($roles as $role): ?>
                      <tr>
                        <td align="right"><?php echo $role["role"]; ?></td>
                        <td style="padding-left: 20px;">
                          <a class="actor-link"
                             href="/pages/team-person.php?id=<?php echo $role["actor_id"]; ?>">
                            <?php echo $role["name"]; ?>
                          </a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </center>
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
