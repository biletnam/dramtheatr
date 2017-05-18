<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();

$actor_id = $_GET["id"];

$result = $db1->query("SELECT name, posada, txt, photo FROM dt_actors WHERE id = '$actor_id'");
$result->setFetchMode(PDO::FETCH_ASSOC);
$worker = $result->fetch();

$result = $db1->query("SELECT
  dt_roles.spectacle_id,
  dt_roles.role,
  dt_vistava.nazva
  FROM dt_roles
  INNER JOIN dt_vistava
  ON dt_roles.spectacle_id = dt_vistava.id
  WHERE dt_roles.actor_id = '$actor_id'");
$spectacles = array();
$i = 0;
while ($row = $result->fetch()) {
  $spectacles[$i]['spectacle_id'] = $row['spectacle_id'];
  $spectacles[$i]['role'] = $row['role'];
  $spectacles[$i]['nazva'] = $row['nazva'];
  $i++;
}
?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
  <div class='title'>
    <h1><?php echo $worker["name"] ?></h1>
  </div>
  <div class='personal-inf'>
    <div class='row' id='director'>
      <div class='col-md-5 col-sm-5'>
        <figure class='team'>
          <img src='/pages/img/<?php echo $worker["photo"] ?>' height='335' width='223' alt='photo' />
        </figure>
      </div>
      <div class='col-md-7 col-sm-7'>
        <div class='personal-inf-block'>
          <article><?php echo $worker["posada"] ?></article>
          <hr>
          <p><?php echo $worker["txt"]?></p>
          <center style="margin-bottom: 100px;">
            <?php if ($spectacles): ?>
              <p>Ролі та вистави</p>
            <?php endif; ?>
            <table>
              <tbody>
                <?php foreach ($spectacles as $spectacle): ?>
                  <tr>
                    <td align="right"><?php echo $spectacle["role"]; ?></td>
                    <td style="padding-left: 20px;">
                      <a class="actor-link"
                         href="/pages/spectacle.php?id=<?php echo $spectacle["spectacle_id"]; ?>">
                        <?php echo $spectacle["nazva"]; ?>
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </center>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php' ?>
