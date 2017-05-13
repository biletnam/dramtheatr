<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();

if(!ini_get('date.timezone')) {
  date_default_timezone_set('GMT');
}
$date = explode(".", date("d.m.Y"));
switch ($date[1]) {
  case 1: $m = 'Січень'; break;
  case 2: $m = 'Лютий'; break;
  case 3: $m = 'Березень'; break;
  case 4: $m = 'Квітень'; break;
  case 5: $m = 'Травень'; break;
  case 6: $m = 'Червень'; break;
  case 7: $m = 'Липень'; break;
  case 8: $m = 'Серпень'; break;
  case 9: $m = 'Вересень'; break;
  case 10: $m = 'Жовтень'; break;
  case 11: $m = 'Листопад'; break;
  case 12: $m = 'Грудень'; break;
}
?>

<section class="theatre parallax-window-news" data-parallax="scroll"
         data-image-src="/img/news/news-bg.jpg">
<div class="title">
  <h1>Афіша</h1>
</div>
<div class="menu-line">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <nav>
          <ul>
            <li>
              <a href="#now" class="active">
                Поточний місяць:
                <span style="font-weight: bold; font-size: 19px;">
                  <?php echo $m; ?>
                </span>
              </a>
            </li>
            <li><a href="#next">Наступний місяць</a></li>
          </ul>
        </nav>
      </div>
    </div>
  </div>
</div>
<div class="reper-list" id="now">
  <?php include 'theatr.php' ?>
</div>
<div class="reper-list" id="next" style="display: none;">
  <?php include 'aaf.php' ?>
</div>
</section>

<?php include 'footer.php' ?>
