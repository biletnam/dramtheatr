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
if( ! ini_get('date.timezone') )
{
    date_default_timezone_set('Europe/Kiev');
}

$next_month = date("m")+1 > 12 ? 1 : date("m")+1;
    if ($next_month<10){

    $isnol='0'.$next_month;

    }

else {
   $isnol=$next_month;
}

$i=1;
$result=mysql_query("SELECT * FROM dt_group_afisha WHERE start LIKE '_____$isnol%' ORDER BY id DESC",$db);
$myrow=mysql_fetch_array($result);
do{ $int = $myrow["photozag"];
$start = $myrow["start"];
if ($myrow[id_rep==2]){
	$children='children/';
}
else{
	$children='';
}
    if ($i==1 or $i==2){
    printf("<!-- block -->
		<div class='reper-block reper-block-img' style='position: relative;'>
			<div style='opacity: 1; background: url(/img/spectacle/$children$int/banner.jpg); height:325px; width:350px;'><!--photozag-->
				<div class='opaline'><p>$start</p></div>
			</div>
		</div><!-- end reper-block -->
		<a href='/pages/spectacle.php?id=%s'>
			<div class='reper-block reper-block-text'>
				<figure>
					<article>%s</article><br /><!--nazva-->
					<span>%s</span><br /><!--avtor-->
					<p>%s</p><br /><!--tip-->
					<p>%s</p><br /><!--times-->
				</figure>
			</div><!-- end reper-block -->
		</a>
		<!-- end block -->
		<!-- ####################################### -->", $myrow["id_af"], $myrow["nazva"], $myrow["avtor"], $myrow["tip"], $myrow["times"]);
        $i=$i+1;
        }
    else {
       printf("<!-- block -->
		<a href='/pages/spectacle.php?id=%s'>
			<div class='reper-block reper-block-text'>
				<figure>
					<article>%s</article><br /><!--nazva-->
					<span>%s</span><br /><!--avtor-->
					<p>%s</p><br /><!--tip-->
					<p>%s</p><br /><!--times-->
				</figure>
			</div><!-- end reper-block -->
		</a>
        <div class='reper-block reper-block-img'>
			<div style='background: url(/img/spectacle/$children$int/banner.jpg); height:325px; width:350px;'><!--photozag-->
				<div class='opaline'><p style='opacity: 1;'>$start</p></div>
			</div>
		</div><!-- end reper-block -->
		<!-- end block -->
		<!-- ####################################### -->", $myrow["id_af"], $myrow["nazva"], $myrow["avtor"], $myrow["tip"], $myrow["times"]);
        $i=$i+1;
    }
        if ($i==5) {$i=1;}
}
while ($myrow=mysql_fetch_array($result));
?>

	</div><!-- end reper-list -->

	<!-- ####################################### -->

	<div class="reper-list reper-list-for-children" id="next">

      <?php
$i=1;
$result=mysql_query("SELECT * FROM dt_group_afisha WHERE start LIKE '_____$isnol%' ORDER BY id DESC",$db);
$myrow=mysql_fetch_array($result);
do{ $int = $myrow["photozag"];
if ($myrow[id_rep==2]){
	$children='children/';
}
else{
	$children='';
}
    if ($i==1 or $i==2){
    printf("<!-- block -->
		<div class='reper-block reper-block-img'>
			<div style='background: url(/img/spectacle/$children$int/banner.jpg); height:325px; width:365px;'><!--photozag-->
				<div class='opaline'><p style='opacity: 1;'>$start</p></div>
			</div>
		</div><!-- end reper-block -->
		<a href='/pages/spectacle.php?id=%s'>
			<div class='reper-block reper-block-text'>
				<figure>
					<article>%s</article><br /><!--nazva-->
					<span>%s</span><br /><!--avtor-->
					<p>%s</p><br /><!--tip-->
					<p>%s</p><br /><!--times-->
				</figure>
			</div><!-- end reper-block -->
		</a>
		<!-- end block -->
		<!-- ####################################### -->", $myrow["id_af"], $myrow["nazva"], $myrow["avtor"], $myrow["tip"], $myrow["times"]);
        $i=$i+1;
        }
    else {
       printf("<!-- block -->
		<a href='/pages/spectacle.php?id=%s'>
			<div class='reper-block reper-block-text'>
				<figure>
					<article>%s</article><br /><!--nazva-->
					<span>%s</span><br /><!--avtor-->
					<p>%s</p><br /><!--tip-->
					<p>%s</p><br /><!--times-->
				</figure>
			</div><!-- end reper-block -->
		</a>
        <div class='reper-block reper-block-img'>
			<div style='background: url(/img/spectacle/$children$int/banner.jpg); height:325px; width:365px;'><!--photozag-->
				<div class='opaline'><p style='opacity: 1;'>$start</p></div>
			</div>
		</div><!-- end reper-block -->
		<!-- end block -->
		<!-- ####################################### -->", $myrow["id_af"], $myrow["nazva"], $myrow["avtor"], $myrow["tip"], $myrow["times"]);
        $i=$i+1;
    }
        if ($i==5) {$i=1;}
}
while ($myrow=mysql_fetch_array($result));
?>

	</div><!-- end reper-list -->

</section><!-- end theatre -->

<?php include 'footer.php' ?>
