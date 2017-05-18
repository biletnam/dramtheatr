<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();

function getSpectaclesByAudience($audience) {
  $db1 = Db::getConnection();
  $result = $db1->query("SELECT id, tip, nazva, avtor, times, photo
    FROM dt_vistava WHERE id_rep = '$audience' ORDER BY id DESC");
  $spectacles = array();
  $i = 0;
  while ($row = $result->fetch()) {
    $spectacles[$i]['id'] = $row['id'];
    $spectacles[$i]['tip'] = $row['tip'];
    $spectacles[$i]['nazva'] = $row['nazva'];
    $spectacles[$i]['avtor'] = $row['avtor'];
    $spectacles[$i]['times'] = $row['times'];
    $spectacles[$i]['photo'] = $row['photo'];
    $i++;
  }
  return $spectacles;
}
?>

<section class="theatre parallax-window-news" data-parallax="scroll"
				 data-image-src="/img/news/news-bg.jpg">
	<div class="title">
		<h1>Репертуар</h1>
	</div>
	<div class="menu-line">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<nav>
						<ul>
							<li><a href="#abstract" class="active">Загальний</a></li>
							<li><a href="#for-children">Вистави для дітей</a></li>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
  <div class="reper-list" id="abstract">
    <?php $adults = getSpectaclesByAudience(1); $i = 0; ?>
    <?php foreach ($adults as $adult): ?>
      <?php if ($i == 0 || $i == 1): ?>
        <a href='/pages/spectacle.php?id=<?php echo $adult['id']; ?>'>
          <div class='reper-block reper-block-img'>
            <div style="opacity: 1; background: url(/pages/img/<?php echo $adult['photo']; ?>)center/cover; height:325px; width:350px;"></div>
          </div>
          <div class='reper-block reper-block-text' style="max-height: 325px;">
            <figure>
              <article><?php echo $adult['nazva']; ?></article><br>
              <span><?php echo $adult['avtor']; ?></span><br>
              <p><?php echo $adult['tip']; ?></p><br>
              <p><?php echo $adult['times']; ?></p><br>
            </figure>
          </div>
        </a>
      <?php endif; ?>
      <?php if ($i == 2 || $i == 3): ?>
        <a href='/pages/spectacle.php?id=<?php echo $adult['id']; ?>'>
          <div class='reper-block reper-block-text' style="max-height: 325px;">
            <figure>
              <article><?php echo $adult['nazva']; ?></article><br>
              <span><?php echo $adult['avtor']; ?></span><br>
              <p><?php echo $adult['tip']; ?></p><br>
              <p><?php echo $adult['times']; ?></p><br>
            </figure>
          </div>
          <div class='reper-block reper-block-img'>
            <div style="opacity: 1; background: url(/pages/img/<?php echo $adult['photo']; ?>)center/cover; height:325px; width:350px;"></div>
          </div>
        </a>
      <?php endif; $i++; ?>
      <?php if ($i == 4) $i = 0; ?>
    <?php endforeach; ?>
  </div>
  <div class="reper-list reper-list-for-children" id="for-children">
    <?php $children = getSpectaclesByAudience(2); $i = 0; ?>
    <?php foreach ($children as $child): ?>
      <?php if ($i == 0 || $i == 1): ?>
        <a href='/pages/spectacle.php?id=<?php echo $child['id']; ?>'>
          <div class='reper-block reper-block-img'>
            <div style="opacity: 1; background: url(/pages/img/<?php echo $child['photo']; ?>)center/cover; height:325px; width:350px;"></div>
          </div>
          <div class='reper-block reper-block-text' style="max-height: 325px;">
            <figure>
              <article><?php echo $child['nazva']; ?></article><br>
              <span><?php echo $child['avtor']; ?></span><br>
              <p><?php echo $child['tip']; ?></p><br>
              <p><?php echo $child['times']; ?></p><br>
            </figure>
          </div>
        </a>
      <?php endif; ?>
      <?php if ($i == 2 || $i == 3): ?>
        <a href='/pages/spectacle.php?id=<?php echo $child['id']; ?>'>
          <div class='reper-block reper-block-text' style="max-height: 325px;">
            <figure>
              <article><?php echo $child['nazva']; ?></article><br>
              <span><?php echo $child['avtor']; ?></span><br>
              <p><?php echo $child['tip']; ?></p><br>
              <p><?php echo $child['times']; ?></p><br>
            </figure>
          </div>
          <div class='reper-block reper-block-img'>
            <div style="opacity: 1; background: url(/pages/img/<?php echo $child['photo']; ?>)center/cover; height:325px; width:350px;"></div>
          </div>
        </a>
      <?php endif; $i++; ?>
      <?php if ($i == 4) $i = 0; ?>
    <?php endforeach; ?>
  </div>
</section>

<?php include 'footer.php'; ?>
