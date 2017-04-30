<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();
?>
<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
	<div class="title">
		<h1>Працівники</h1>
	</div><!-- end title -->
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
			</div><!-- end row -->
		</div><!-- end container -->
	</div><!-- end menu-line -->
	<div class="container">
		<div class="team-list" id="art-dir-team">
			<?php
			$result = $db1->query("SELECT name, posada, sort, dt_actors.id, dt_photo.photo
														 FROM dt_actors INNER JOIN dt_photo
														 ON dt_actors.id=dt_photo.id_act WHERE id_n='1'
														 ORDER BY sort ASC");
			// $result = $db1->query("SELECT name, posada, id
			// 											 FROM dt_actors
			// 											 WHERE id_n='1'");
			$myrows = array();
 			$i = 0;
 			while ($row = $result->fetch()) {
 			  $myrows[$i]['id'] = $row['id'];
 			  $myrows[$i]['name'] = $row['name'];
 			  $myrows[$i]['posada'] = $row['posada'];
 			  $myrows[$i]['photo'] = $row['photo'];
 			  $i++;
 			}
			$i = 1;
			$d = 1;
			foreach ($myrows as $myrow) {
				if ($i == 1) printf("<div class='row'>");
				if ($d == 1) {
					$i++;
					printf("<div class='col-md-3 col-sm-6'></div>");
				}
				?>
				<div class='col-md-3 col-sm-6'>
					<a href='/pages/team-person.php?id=<?php echo $myrow['id'];?>'>
						<figure class='team'>
							<img src='/pages/img/<?php echo $myrow['photo']; ?>'
									 height='335'
									 width='223'
									 alt='photo'>
							<p><?php echo $myrow['name'];?></p>
							<span><?php echo $myrow['posada'];?></span>
						</figure>
					</a>
				</div>
				<?php
				if ($d == 2) {
					$i++;
					printf("<div class='col-md-3 col-sm-6'></div>");
				}
				if ($i == 4) {
					printf("</div><!-- end row -->");
				}
				$i++;
				$d++;
				if ($i == 5) $i = 1;
			}
			if ($i != 1) printf("</div><!-- end row -->");
				?>
			</div><!-- end row -->
		</div><!-- end team-list -->
		<!-- ##################################################### -->
		<div class="team-list" id="actors">
			<?php
			// $result = $db1->query("SELECT name, posada, id
			// 											 FROM dt_actors
			// 											 WHERE id_n='2'");
			$result = $db1->query("SELECT name, posada, sort, dt_actors.id, dt_photo.photo
														 FROM dt_actors INNER JOIN dt_photo
														 ON dt_actors.id=dt_photo.id_act WHERE id_n='2'
														 ORDER BY sort ASC");
			$myrows = array();
 			$i = 0;
 			while ($row = $result->fetch()) {
 			  $myrows[$i]['id'] = $row['id'];
 			  $myrows[$i]['name'] = $row['name'];
 			  $myrows[$i]['posada'] = $row['posada'];
				$myrows[$i]['photo'] = $row['photo'];
 			  $i++;
 			}
			$i=1;
			foreach ($myrows as $myrow) {
				if ($i==1){printf("<div class='row'>");}
				?>
				<div class='col-md-3 col-sm-6'>
					<a href='/pages/team-person.php?id=<?php echo $myrow["id"];?>'>
						<figure class='team'>
							<img src='/pages/img/<?php echo $myrow['photo']; ?>'
									 height='335'
									 width='223'
									 alt='photo'>
							<p><?php echo $myrow["name"];?></p>
							<span><?php echo $myrow["posada"];?></span>
						</figure>
					</a>
				</div>
				<?php
				if ($i==4){printf("</div><!-- end row -->");}
				$i=$i+1;
				if ($i==5) {$i=1;}
			}
			if ($i==4) {
			} else {
				printf("</div><!-- end row -->");
			}
			?>
		</div><!-- end team-list -->
		<!-- ##################################################### -->
		<div class="team-list" id="balet">
			<?php
			// $result = $db1->query("SELECT name, posada, id
			// 											 FROM dt_actors
			// 											 WHERE id_n='3'");
			$result = $db1->query("SELECT name, posada, sort, dt_actors.id, dt_photo.photo
														 FROM dt_actors INNER JOIN dt_photo
														 ON dt_actors.id=dt_photo.id_act WHERE id_n='3'
														 ORDER BY sort ASC");
			$myrows = array();
 			$i = 0;
 			while ($row = $result->fetch()) {
 			  $myrows[$i]['id'] = $row['id'];
 			  $myrows[$i]['name'] = $row['name'];
 			  $myrows[$i]['posada'] = $row['posada'];
				$myrows[$i]['photo'] = $row['photo'];
 			  $i++;
 			}
			$i=1;
			foreach ($myrows as $myrow) {
				if ($i==1){printf("<div class='row'>");}
				?>
				<div class='col-md-3 col-sm-6'>
					<a href='/pages/team-person.php?id=<?php echo $myrow["id"];?>'>
						<figure class='team'>
							<img src='/pages/img/<?php echo $myrow['photo']; ?>'
									 height='335'
									 width='223'
									 alt='photo'>
							<p><?php echo $myrow["name"];?></p>
							<span><?php echo $myrow["posada"];?></span>
						</figure>
					</a>
				</div><?php
				if ($i==4){printf("</div><!-- end row -->");}
				$i=$i+1;
				if ($i==5) {$i=1;}
			}
			if ($i==1) {}
				else {printf("</div><!-- end row -->");}
				?>
			</div><!-- end team-list -->
			<!-- ##################################################### -->
			<div class="team-list" id="orkestr">
				<?php
				// $result = $db1->query("SELECT name, posada, id
				// 											 FROM dt_actors
				// 											 WHERE id_n='4'");
				$result = $db1->query("SELECT name, posada, sort, dt_actors.id, dt_photo.photo
															 FROM dt_actors INNER JOIN dt_photo
															 ON dt_actors.id=dt_photo.id_act WHERE id_n='4'
															 ORDER BY sort ASC");
				$myrows = array();
	 			$i = 0;
	 			while ($row = $result->fetch()) {
	 			  $myrows[$i]['id'] = $row['id'];
	 			  $myrows[$i]['name'] = $row['name'];
	 			  $myrows[$i]['posada'] = $row['posada'];
					$myrows[$i]['photo'] = $row['photo'];
	 			  $i++;
	 			}
				$i=1;
				foreach ($myrows as $myrow) {
					if ($i==1){printf("<div class='row'>");}
					?>
					<div class='col-md-3 col-sm-6'>
						<a href='/pages/team-person.php?id=<?php echo $myrow["id"];?>'>
							<figure class='team'>
								<img src='/pages/img/<?php echo $myrow['photo']; ?>'
										 height='335'
										 width='223'
										 alt='photo'>
								<p><?php echo $myrow["name"];?></p>
								<span><?php echo $myrow["posada"];?></span>
							</figure>
						</a>
					</div><?php
					if ($i==4){printf("</div><!-- end row -->");}
					$i=$i+1;
					if ($i==5) {$i=1;}
				}
				if ($i==4) {}
					else {printf("</div><!-- end row -->");}
					?>
					<div class="col-md-3">
						<!-- пустой блок для сдвига по центру последних двух портретов -->
					</div>
				</div><!-- end team-list -->
			</div><!-- end container -->
		</section><!-- end theatre -->
		<?php include 'footer.php' ?>
