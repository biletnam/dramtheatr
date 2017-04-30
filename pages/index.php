
<?php
session_start();
include 'teatradmin/block/connect.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
	<script src="myform/jquery.js"></script>
	<script>
	$(function() {
		$("a[rel]").overlay(function() {
			var wrap = this.getContent().find("div.wrap");
			if (wrap.is(":empty")) {
				wrap.load(this.getTrigger().attr("href"));
			}
		});
	});
	</script>
	<meta charset="utf-8" />
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="admin" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="/libs/bootstrap/bootstrap-grid-3.3.1.min.css" />
	<title>
		Чернівецький академічний обласний український
		музично-драматичний театр імені Ольги Кобилянської
	</title>
	<meta name="description" content="" />
	<meta name="keywords" content="" />
	<link rel="shortcut icon" href="/img/favicon/favicon.ico" type="image/x-icon" />
	<link rel="apple-touch-icon" href="/img/favicon/favicon.png" />
	<link rel="apple-touch-icon" sizes="16x16" href="/img/favicon/favicon.png" />
	<link rel="stylesheet" href="/libs/fancybox/jquery.fancybox.css" />
	<link rel="stylesheet" href="/libs/slick/slick.css" />
	<link rel="stylesheet" href="/libs/slick/slick-theme.css" />
	<link rel="stylesheet" href="/libs/nprogress/nprogress.css" />
	<link rel="stylesheet" href="/main.css" />
	<link rel="stylesheet" href="/fonts.css" />
	<link rel="stylesheet" href="/media.css" />
	<link rel="stylesheet" href="/animated.css" />
	<link rel="stylesheet" href="/hamburgers.css" />
	<link rel="stylesheet" href="/admin.css" />
	<link rel="stylesheet" type="text/css" href="myform/style.css"/>
</head>

<body>
	<div id="wrapper" class="wrapper out">
		<div class="top-line-menu">
			<a href="/index.php" class="logo-page">
				<img src="/img/logo.png" height="617" width="1083" alt="logo" />
			</a>
			<div class="under-menu">
				<div class="container">
					<div class="row">
						<div class="col-md-6">
							<div class="title-text">
								<p>
									Чернівецький академічний обласний
									Український музично-драматичний театр
									ім. Ольги Кобилянської
								</p>
							</div><!-- end title-text -->
						</div>
					</div><!-- end row -->
				</div><!-- end container -->
			</div><!-- end top-line -->
			<div class="menu">
				<div class="container">
					<div class="row">
						<div class="col-md-12">
							<div class="hamburger hamburger--arrowalt hidden-lg hidden-md hidden-sm">
								<div class="hamburger-box">
									<div class="hamburger-inner"></div>
								</div>
							</div>
							<nav>
								<ul>
									<li class="left-li"><a href="/pages/admin.php">Новини</a></li>
									<li class="left-li"><a href="/pages/personal-admin.php">Працівники</a></li>
									<li class="left-li"><a href="/pages/repertoire-admin.php">Репертуар</a></li>
								</ul>
							</nav>
						</div>
					</div><!-- end row -->
				</div><!-- end container -->
			</div><!-- menu -->
		</div><!-- end top-line-menu -->

		<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
			<div class="container">
				<div class="row">
					<fieldset>
						<legend>
							<h2>Добавити:</h2>
						</legend>
						<form name="form1"  method="post" action="teatradmin/reg.php" id="form1" >
							<p>Тема:</p><br>
							<input type="text" id="tema" name="tema" form="form1" size="100"/>
							<p>Текст:</p><br>
							<textarea name="txt" id="txt" cols="100" rows="5"></textarea>
							<p>Завантажте головну фотографію:</p><br/>
							<input type="file" name="photo" id="photo" accept="image/*" form="form1"/>
							<p>Выберите дату:</p>
							<input type="date" name="date" id="date" form="form1" value="2016-08-31"/>
							<input type="submit" name="submit1" id="submit1" value="Додати" form="form1"/>
						</form><!-- end form -->
					</fieldset>

					<fieldset>
						<legend>
							<h2>Видалити:</h2>
						</legend>
						<form id="form3" name="form3" method="post" action="teatradmin/delete.php">
							<p>Виберіть новину яку потрібно видалити:</p><br>
							<?php
							$result = mysql_query("SELECT tema, id FROM dt_news");
							$myrow = mysql_fetch_array($result);
							do {
								printf ("<p><input name='id' type='radio' value='%s'><label>%s</label></p>", $myrow["id"], $myrow["tema"]);
							} while ($myrow = mysql_fetch_array($result));
							?>
							<input type="submit" name="submit" id="submit" value="Видалити" form="form3"/>
						</form><!-- end form -->
					</fieldset>

					<fieldset>
						<legend>
							<h2>Змінити:</h2>
						</legend>
						<form id="form2" name="form2" method="post" action="myform/contact.php" >
							<p>Виберіть новину яку потрібно змінити: </p><br>
							<select id="rad" name="rad">
								<?php
								$result = mysql_query("SELECT tema, id FROM dt_news");
								$myrow = mysql_fetch_array($result);
								do {
									printf ("<option name='rad' value='%s'>%s</option>", $myrow["id"],$myrow["tema"]);
								} while ($myrow = mysql_fetch_array($result));
								$_SESSION['rad'] = "1";
								?>
							</select>
							<a href='myform/contact.php' rel='#overlay'>
								<input type="button" value="Загрузить" form="form2"/>
							</a>
							<div class="overlay" id="overlay">
								<div class="wrap"></div>
							</div>
						</form><!-- end form -->
					</fieldset>

					<fieldset>
						<form id="form5" name="form5" method="post" action="../index.php">
							<input type='submit' name='submit1' id='submit_1' value='Вийти' form='form5'/>
						</form>
					</fieldset>
				</div><!-- end row -->
			</div><!-- end container -->
		</section><!-- end theatre -->

		<footer class="footer">
			<div class="container">
				<div class="row">
					<div class="col-md-12"></div>
				</div><!-- end row -->
			</div><!-- end container -->
		</footer><!-- end footer -->
	</div><!-- end wrapper -->

	<script src="/libs/dist/jquery.knob.min.js"></script>
	<script src="/libs/viewportchecker/jquery.viewportchecker.js"></script>
	<script src="/libs/landing-nav/navigation.js"></script>
	<script src="/libs/parallax/parallax.js"></script>
	<script src="/libs/parallax/parallax.min.js"></script>
	<script src="/libs/fancybox/jquery.fancybox.pack.js"></script>
	<script src="/libs/scrollto/jquery.scrollTo.min.js"></script>
	<script src="/libs/slick/slick.min.js"></script>
	<script src="/libs/nprogress/nprogress.js"></script>
	<script src="/js/parallax.js"></script>
	<script src="/js/animate.js"></script>
	<script src="/js/modernizr.js"></script>
	<script src="/js/main.js"></script>
	<script>
	$(document).ready(function(){
		$("#rad").checked(function(){
			var v = $(this).val();
		});
	});
	</script>

</body>
</html>
