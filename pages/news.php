<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();
?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
	<div class="title"><h1>Новини</h1></div>
	<div class="news-list">
		<div class="container">

<?php
$result = $db1->query("SELECT
	dt_news.tema,
	dt_news.txt,
	dt_news.short_content,
	dt_news.date,
	dt_news.id,
	dt_photo.photo
	FROM dt_news
	INNER JOIN dt_photo
	ON dt_news.id=dt_photo.id_new
	ORDER BY date DESC");
$myrows = array();
$i = 0;
while ($row = $result->fetch()) {
	$myrows[$i]['id'] = $row['id'];
	$myrows[$i]['date'] = $row['date'];
	$myrows[$i]['tema'] = $row['tema'];
	$myrows[$i]['txt'] = $row['txt'];
	$myrows[$i]['short_content'] = $row['short_content'];
	$myrows[$i]['photo'] = $row['photo'];
	$i++;
}
foreach ($myrows as $myrow) {
?>

<div class='row'>
	<div class='col-md-3'>
		<div class='new-photo'>
			<img src='/pages/img/<?php echo $myrow["photo"]; ?>'>
			<span class='date'><?php echo $myrow["date"]; ?></span>
		</div>
	</div>
	<div class='col-md-9'>
		<div class='new-text' style="min-height: 0; padding-bottom: 0; margin-bottom: 0;">
			<span><?php echo $myrow["tema"]; ?></span>
		</div>
		<div style="color:#000;">
			<?php echo $myrow['short_content'];?>
		</div>
		<div class="new-text">
			<a href='/pages/news-person.php?id=<?php echo $myrow["id"]; ?>' class='more'>Читати</a>
		</div>
	</div>
</div>

<?php
}
?>

		</div>
	</div>
</section>
<?php include 'footer.php' ?>
