<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();
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

<?php
$result = $db1->query("SELECT * FROM dt_vistava WHERE id_rep='1' ORDER BY id DESC");
$myrows = array();
$i = 0;
while ($row = $result->fetch()) {
	$myrows[$i]['id'] = $row['id'];
	$myrows[$i]['tip'] = $row['tip'];
	$myrows[$i]['nazva'] = $row['nazva'];
	$myrows[$i]['avtor'] = $row['avtor'];
	$myrows[$i]['times'] = $row['times'];
	$i++;
}
$i = 1;
foreach ($myrows as $myrow) {
if ($i == 1 or $i == 2) {
?>

				<a href='/pages/spectacle.php?id=<?php echo $myrow["id"]; ?>&id_n=1&int=$int'>
					<div class='reper-block reper-block-img'>
						<img src='/pages/img/<?php select_photo(id_vist, $myrow['id'], 2) ?>'
								 height='480' width='480' alt='photo'>
					</div>
					<div class='reper-block reper-block-text'>
						<figure>
							<article><?php echo $myrow["nazva"]; ?></article><br>
							<span><?php echo $myrow["avtor"]; ?></span><br>
							<p><?php echo $myrow["tip"]; ?></p><br>
							<p><?php echo $myrow["times"]; ?></p><br>
						</figure>
					</div>
				</a>

<?php
$i++;
} else {
?>

				<a href='/pages/spectacle.php?id=<?php echo $myrow["id"]; ?>&id_n=1&int=$int'>
					<div class='reper-block reper-block-text'>
						<figure>
							<article><?php echo $myrow["nazva"]; ?></article><br>
							<span><?php echo $myrow["avtor"]; ?></span><br>
							<p><?php echo $myrow["tip"]; ?></p><br>
							<p><?php echo $myrow["times"]; ?></p><br>
						</figure>
					</div>
					<div class='reper-block reper-block-img'>
						<img src='/pages/img/<?php select_photo(id_vist, $myrow['id'], 2) ?>'
								 height='480' width='480' alt='photo'>
					</div>
				</a>

<?php
$i++;
}
if ($i == 5) $i = 1;
}
?>

	</div>
	<div class="reper-list reper-list-for-children" id="for-children">

<?php
$result = $db1->query("SELECT * FROM dt_vistava WHERE id_rep='2' ORDER BY id DESC");
$myrows = array();
$i = 0;
while ($row = $result->fetch()) {
	$myrows[$i]['id'] = $row['id'];
	$myrows[$i]['nazva'] = $row['nazva'];
	$myrows[$i]['avtor'] = $row['avtor'];
	$myrows[$i]['tip'] = $row['tip'];
	$myrows[$i]['times'] = $row['times'];
	$i++;
}
$i = 1;
foreach ($myrows as $myrow) {
if ($i == 1 or $i == 2) {
?>

				<a href='/pages/spectacle.php?id=<?php echo $myrow["id"]; ?>&id_n=2&int=$int'>
					<div class='reper-block reper-block-img'>
						<img src='/pages/img/<?php select_photo(id_vist, $myrow['id'], 2) ?>'
								 height='480' width='480' alt='photo' /> <!-- photo -->
					</div>
					<div class='reper-block reper-block-text'>
						<figure>
							<article><?php echo $myrow["nazva"]; ?></article><br>
							<span><?php echo $myrow["avtor"]; ?></span><br>
							<p><?php echo $myrow["tip"]; ?></p><br>
							<p><?php echo $myrow["times"]; ?></p><br>
						</figure>
					</div>
				</a>

<?php
$i++;
} else {
?>

				<a href='/pages/spectacle.php?id=<?php echo $myrow["id"]; ?>&id_n=2&int=$int'>
					<div class='reper-block reper-block-text'>
						<figure>
							<article><?php echo $myrow["nazva"]; ?></article><br>
							<span><?php echo $myrow["avtor"]; ?></span><br>
							<p><?php echo $myrow["tip"]; ?></p><br>
							<p><?php echo $myrow["times"]; ?></p><br>
						</figure>
					</div>
					<div class='reper-block reper-block-img'>
						<img src='/pages/img/<?php select_photo(id_vist, $myrow['id'], 2) ?>'
								 height='480' width='480' alt='photo'>
					</div>
				</a>

<?php
$i++;
}
if ($i == 5) $i = 1;
}
?>

	</div>
</section>
<?php include 'footer.php' ?>
