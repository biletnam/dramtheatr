<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();

$id = $_GET["id"];

$result = $db1->query("SELECT name, posada, txt, photo FROM dt_actors WHERE id = '$id'");
$result->setFetchMode(PDO::FETCH_ASSOC);
$worker = $result->fetch();

$result = $db1->query("SELECT DISTINCT
  dt_vistava_actors.id_v,
  dt_vistava_actors.id_n,
  dt_vistava.nazva
  FROM dt_vistava_actors
  INNER JOIN dt_vistava
  ON dt_vistava_actors.id_v=dt_vistava.id
  WHERE id_a = '$id'
  ORDER BY id_n DESC");
$spectacles = array();
$i = 0;
while ($row = $result->fetch()) {
  $spectacles[$i]['id_v'] = $row['id_v'];
  $spectacles[$i]['id_n'] = $row['id_n'];
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
          <?php foreach ($spectacles as $spectacle): ?>
            <a href='/pages/spectacle.php?id=<?php echo $spectacle['id_v']; ?>&id_n=<?php echo $spectacle['id_n']; ?>'>
              <?php echo $spectacle['nazva']; ?>
            </a><br>
          <?php endforeach; ?>
          <br>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'footer.php' ?>
