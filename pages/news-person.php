<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();

$id = $_GET["id"];

$result = $db1->query("SELECT
	dt_news.tema,
	dt_news.txt,
	dt_news.date,
	dt_news.id,
	dt_photo.photo
	FROM dt_news
	INNER JOIN dt_photo
	ON dt_news.id=dt_photo.id_new
  WHERE dt_news.id='$id'");
$result->setFetchMode(PDO::FETCH_ASSOC);
$article = $result->fetch();
?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
	<div class="title"><h1>Новини</h1></div>
	<div class="news-list">
		<div class="container">
			<div class='row'>
				<div class='col-md-6'>
					<div class='new-photo'>
						<img src='/pages/img/<?php echo $article['photo'] ?>'
								 height='193'
								 width='617'
								 alt='photo'
								 style="-webkit-box-reflect: below 4px -webkit-gradient(linear, left top, left bottom, from(transparent), color-stop(.8, transparent), to(white));">
						<span class='date'><?php echo $article["date"]; ?></span>
					</div>
				</div>
				<div class='col-md-6'>
					<div class='new-text' style="min-height: 0;padding-bottom: 0;margin-bottom: 0;">
						<span><?php echo $article["tema"]; ?></span>
					</div>
					<div style="color:#000;">
						<p><?php echo $article["txt"]; ?></p>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>

<?php include 'footer.php' ?>
