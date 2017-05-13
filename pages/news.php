<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();

$currentPage = 1;
if (isset($_POST['currentPage'])) {
  $currentPage = $_POST['currentPage'];
}
if (!$currentPage) {
	$currentPage = 1;
}

$result = $db1->query("SELECT count(id) AS count FROM dt_news");
$result->setFetchMode(PDO::FETCH_ASSOC);
$row = $result->fetch();
$articlesQuantity = $row['count'];
$itemsPerPage = 10;
$pagesQuantity = ceil($articlesQuantity / $itemsPerPage);
$firstPage = 1;
$lastPage = ceil($articlesQuantity / $itemsPerPage) + 1;

if ($pagesQuantity > 5) {
	$paginationWidth = 1;
	$beginPage = $currentPage - 1 - $paginationWidth;
	$endPage = $currentPage + 2 + $paginationWidth;
	if ($beginPage < $firstPage) {
		$beginPage = $firstPage;
		$endPage = 4 + $paginationWidth * 2;
	}
	if ($endPage > $lastPage) {
		$beginPage = $lastPage - 3 - $paginationWidth;
		$endPage = $lastPage;
	}
} else {
	$beginPage = 1;
	$endPage = $pagesQuantity + 1;
}

$paginationOffset = ($currentPage - 1) * $itemsPerPage;
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
	ORDER BY date DESC
	LIMIT $itemsPerPage OFFSET $paginationOffset");
$articles = array();
$i = 0;
while ($row = $result->fetch()) {
	$articles[$i]['id'] = $row['id'];
	$articles[$i]['date'] = $row['date'];
	$articles[$i]['tema'] = $row['tema'];
	$articles[$i]['photo'] = $row['photo'];
	$articles[$i]['short_content'] = $row['short_content'];
	$i++;
}
?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
	<div class="title"><h1>Новини</h1></div>
	<div class="news-list">
		<div class="container">
			<!-- <div id="refreshTable"></div> -->
			<?php foreach ($articles as $article): ?>
			<div class='row'>
				<div class='col-md-3'>
					<div class='new-photo'>
						<!-- <img src='/pages/img/<?php //echo $article["photo"]; ?>'> -->
						<?php $photo = "/pages/img/".$article["photo"]; ?>
						<div style="background: url(<?php echo $photo; ?>)top/cover; height:180px; width:277px;"></div>
						<!-- <div style="background: url(/pages/img/b4.jpg)center/cover; height:277px; width:180px;"></div> -->
						<span class='date'><?php echo $article["date"]; ?></span>
					</div>
				</div>
				<div class='col-md-9'>
					<div class='new-text' style="min-height: 0; padding-bottom: 0; margin-bottom: 0;">
						<span><?php echo $article["tema"]; ?></span>
					</div>
					<div style="color:#000;">
						<?php echo $article['short_content'];?>
					</div>
					<div class="new-text" style="margin-top: 10px;">
						<a href='/pages/news-person.php?id=<?php echo $article["id"]; ?>' class='more'>Читати</a>
					</div>
				</div>
			</div>
			<?php endforeach; ?>

	<?php if ($pagesQuantity > 1): ?>
		<div style="text-align:center;">
			<?php if (($beginPage != $firstPage) && ($pagesQuantity > 5)): ?>
				<form action="news.php" method="post" style="display: inline-block;">
					<input type="text" name="currentPage" value="<?php echo $firstPage; ?>" hidden>
					<input type="submit" class="page" value="<?php echo $firstPage; ?>" style="width: 40px;">
				</form>
				<form action="news.php" method="post" style="display: inline-block;margin: 0 20px 0 20px;">
					<input type="text" name="currentPage" value="<?php echo (($beginPage - 2 - $paginationWidth) < ($firstPage + 1 + $paginationWidth))?($firstPage + 1 + $paginationWidth):($beginPage - 2 - $paginationWidth) ?>" hidden>
					<input type="submit" class="page" value="..." style="width: 40px;">
				</form>
			<?php endif; ?>
			<?php for ($i = $beginPage; $i < $endPage; $i++): ?>
				<form action="news.php" method="post" style="display: inline-block;">
					<input type="text" name="currentPage" value="<?php echo $i; ?>" hidden>
					<?php $pageActive = ($i == $currentPage) ? "page-active" : "" ; ?>
					<input type="submit" class="page <?php echo $pageActive; ?>" value="<?php echo $i; ?>" style="width: 40px;">
				</form>
			<?php endfor; ?>
			<?php if (($endPage != $lastPage) && ($pagesQuantity > 5)): ?>
				<form action="news.php" method="post" style="display: inline-block;margin: 0 20px 0 20px;">
					<input type="text" name="currentPage" value="<?php echo (($endPage + 2 + $paginationWidth) > ($lastPage - 1 - $paginationWidth))?($lastPage - 2 - $paginationWidth):($endPage + 1 + $paginationWidth) ?>" hidden>
					<input type="submit" class="page" value="..." style="width: 40px;">
				</form>
				<form action="news.php" method="post" style="display: inline-block;">
					<input type="text" name="currentPage" value="<?php echo $lastPage - 1; ?>" hidden>
					<input type="submit" class="page" value="<?php echo $lastPage - 1; ?>" style="width: 40px;">
				</form>
			<?php endif; ?>
			<?php //echo $pagesQuantity; ?>
		</div>
	<?php endif; ?>


	</div>
</section>
<?php include 'footer.php' ?>
