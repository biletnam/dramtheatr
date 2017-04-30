<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';

function getWorkersByDepartment($department) {
  $db1 = Db::getConnection();
  $result = $db1->query("SELECT name, posada, sort, dt_actors.id, dt_photo.photo
                         FROM dt_actors INNER JOIN dt_photo
                         ON dt_actors.id=dt_photo.id_act WHERE id_n='$department'
                         ORDER BY sort ASC");
  $workers = array();
  $i = 0;
  while ($row = $result->fetch()) {
    $workers[$i]['id'] = $row['id'];
    $workers[$i]['name'] = $row['name'];
    $workers[$i]['posada'] = $row['posada'];
    $workers[$i]['photo'] = $row['photo'];
    $i++;
  }
  return $workers;
}
?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
  <div class="title">
    <h1>Працівники</h1>
  </div>
  <div class="menu-line">
    <div class="container">
      <div class="row">
        <div class="col-md-12">
          <nav>
            <ul>
              <li><a href="#art-dir-team" class="active">Художньо-керівний склад</a></li>
              <li><a href="#actors">Актори</a></li>
              <li><a href="#balet">Балет</a></li>
              <li><a href="#orkestr">Оркестр</a></li>
            </ul>
          </nav>
        </div>
      </div>
    </div>
  </div>
  <div class="container">
    <div class="team-list" id="art-dir-team">
      <?php $leaders = getWorkersByDepartment(1); $i = 1; ?>
      <?php foreach ($leaders as $leader): ?>
        <?php if ($i == 1 || $i == 3): ?>
          <div class='col-md-3 col-sm-6' style="min-height: 450px;"></div>
        <?php endif; ?>
        <div class='col-md-3 col-sm-6' style="min-height: 450px;">
					<a href='/pages/team-person.php?id=<?php echo $leader['id'];?>'>
						<figure class='team'>
							<img src='/pages/img/<?php echo $leader['photo']; ?>'
									 height='335'
									 width='223'
									 alt='photo'>
							<p><?php echo $leader['name'];?></p>
							<span><?php echo $leader['posada'];?></span>
						</figure>
					</a>
				</div>
      <?php $i++; endforeach; ?>
    </div>
    <div class="team-list" id="actors">
      <?php $actors = getWorkersByDepartment(2); ?>
      <?php foreach ($actors as $actor): ?>
        <div class='col-md-3 col-sm-6' style="min-height: 450px;">
					<a href='/pages/team-person.php?id=<?php echo $actor['id'];?>'>
						<figure class='team'>
							<img src='/pages/img/<?php echo $actor['photo']; ?>'
									 height='335'
									 width='223'
									 alt='photo'>
							<p><?php echo $actor['name'];?></p>
							<span><?php echo $actor['posada'];?></span>
						</figure>
					</a>
				</div>
      <?php endforeach; ?>
    </div>
    <div class="team-list" id="balet">
      <?php $dancers = getWorkersByDepartment(3); ?>
      <?php foreach ($dancers as $dancer): ?>
        <div class='col-md-3 col-sm-6' style="min-height: 450px;">
					<a href='/pages/team-person.php?id=<?php echo $dancer['id'];?>'>
						<figure class='team'>
							<img src='/pages/img/<?php echo $dancer['photo']; ?>'
									 height='335'
									 width='223'
									 alt='photo'>
							<p><?php echo $dancer['name'];?></p>
							<span><?php echo $dancer['posada'];?></span>
						</figure>
					</a>
				</div>
      <?php endforeach; ?>
    </div>
    <div class="team-list" id="orkestr">
      <?php $musicians = getWorkersByDepartment(4); ?>
      <?php foreach ($musicians as $musician): ?>
        <div class='col-md-3 col-sm-6' style="min-height: 450px;">
					<a href='/pages/team-person.php?id=<?php echo $musician['id'];?>'>
						<figure class='team'>
							<img src='/pages/img/<?php echo $musician['photo']; ?>'
									 height='335'
									 width='223'
									 alt='photo'>
							<p><?php echo $musician['name'];?></p>
							<span><?php echo $musician['posada'];?></span>
						</figure>
					</a>
				</div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include 'footer.php' ?>
