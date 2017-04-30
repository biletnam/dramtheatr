<?php include 'header.php' ?>

<?php include 'top-line-menu.php' ?>

<?php include 'teatradmin/block/connect.php' ?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">

	<div class="title">

		<h1>Репертуар</h1>

	</div><!-- end title -->

	<div class="menu-line">

		<div class="container">

			<div class="row">

				<div class="col-md-12">

					<nav>
						<ul>
							<li><a href="#now" class="active">Поточний місяць</a></li>
							<li><a href="#next">Наступний місяць</a></li>
						</ul>
					</nav>

				</div>

			</div><!-- end row -->

		</div><!-- end container -->

	</div><!-- end menu-line -->

	<div class="reper-list" id="now">

<?php
$i=1;
$result=mysql_query("SELECT * FROM dt_group_afisha WHERE id_rep='1' AND start !='0000-00-00' ORDER BY id DESC",$db);
$myrow=mysql_fetch_array($result);
do{ $int = $myrow["photozag"];
$start = $myrow["start"];
    if ($i==1 or $i==2){
    printf("<!-- block -->
		<div class='reper-block reper-block-img'>
			<div style='background: url(/img/spectacle/$int/banner.jpg); height:325px; width:325px;'><!--photozag-->
				<div style='height: 50px; opacity: 0.75; background: #F8D69F; color: #010101; position: relative; bottom: 50px; z-index: 10;'> $start</div>
			</div>
		</div><!-- end reper-block -->
		<a href='/pages/spectacle.php?id=%s&id_n=1&int=$int'>
			<div class='reper-block reper-block-text'>
				<figure>  $start
					<article>%s</article><br /><!--nazva-->
					<span>%s</span><br /><!--avtor-->
					<p>%s</p><br /><!--tip-->
					<p>%s</p><br /><!--times-->
				</figure>
			</div><!-- end reper-block -->
		</a>
		<!-- end block -->
		<!-- ####################################### -->", $myrow["id"], $myrow["nazva"], $myrow["avtor"], $myrow["tip"], $myrow["times"]);
        $i=$i+1;
        }
    else {
       printf("<!-- block -->
		<a href='/pages/spectacle.php?id=%s&id_n=1&int=$int'>
			<div class='reper-block reper-block-text'>
				<figure>  $start
					<article>%s</article><br /><!--nazva-->
					<span>%s</span><br /><!--avtor-->
					<p>%s</p><br /><!--tip-->
					<p>%s</p><br /><!--times-->
				</figure>
			</div><!-- end reper-block -->
		</a>
        <div class='reper-block reper-block-img'>
			<img src='/img/spectacle/$int/banner.jpg' height='480' width='480' alt='banner' /> <!--photozag-->
			<div style='height: 50px; opacity: 0.75; background: #F8D69F; color: #010101; position: relative; bottom: 50px; z-index: 10;'>$start</div>
		</div><!-- end reper-block -->
		<!-- end block -->
		<!-- ####################################### -->", $myrow["id"], $myrow["nazva"], $myrow["avtor"], $myrow["tip"], $myrow["times"]);
        $i=$i+1;
    }
        if ($i==5) {$i=1;}
}
while ($myrow=mysql_fetch_array($result));
?>

	</div><!-- end reper-list -->

	<!-- ####################################### -->

	<div class="reper-list reper-list-next" id="next">

      <?php
$i=1;
$result=mysql_query("SELECT * FROM dt_group_afisha WHERE id_rep='2' AND start !='0000-00-00' ORDER BY id DESC",$db);
$myrow=mysql_fetch_array($result);
do{ $int = $myrow["photozag"];
$start = $myrow["start"];

    if ($i==1 or $i==2){
    printf("<!-- block -->
		<div class='reper-block reper-block-img'>
			<img src='/img/spectacle/children/$int/banner.jpg' height='480' width='480' alt='banner' /> <!--photozag-->
		</div><!-- end reper-block -->
		<a href='/pages/spectacle.php?id=%s&id_n=2&int=$int'>
			<div class='reper-block reper-block-text'>
				<figure> $start
					<article>%s</article><br /><!--nazva-->
					<span>%s</span><br /><!--avtor-->
					<p>%s</p><br /><!--tip-->
					<p>%s</p><br /><!--times-->
				</figure>
			</div><!-- end reper-block -->
		</a>
		<!-- end block -->
		<!-- ####################################### -->", $myrow["id"], $myrow["nazva"], $myrow["avtor"], $myrow["tip"], $myrow["times"]);
        $i=$i+1;
        }
    else {
       printf("<!-- block -->
		<a href='/pages/spectacle.php?id=%s&id_n=2&int=$int'>
			<div class='reper-block reper-block-text'>
				<figure> $start
					<article>%s</article><br /><!--nazva-->
					<span>%s</span><br /><!--avtor-->
					<p>%s</p><br /><!--tip-->
					<p>%s</p><br /><!--times-->
				</figure>
			</div><!-- end reper-block -->
		</a>
        <div class='reper-block reper-block-img'>
			<img src='/img/spectacle/children/$int/banner.jpg' height='480' width='480' alt='banner' /> <!--photozag-->
		</div><!-- end reper-block -->
		<!-- end block -->
		<!-- ####################################### -->", $myrow["id"], $myrow["nazva"], $myrow["avtor"], $myrow["tip"], $myrow["times"]);
        $i=$i+1;
    }
        if ($i==5) {$i=1;}
}
while ($myrow=mysql_fetch_array($result));
?>

	</div><!-- end reper-list -->

</section><!-- end theatre -->

<?php include 'footer.php' ?>
