<?php
include 'header.php';
include 'top-line-menu.php';
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();
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
            <li><a href="#next" id="next">Наступний місяць</a></li>
          </ul>
        </nav>
      </div>
      <div id="result" style="margin-top:150px; margin-left:-58px;"></div>
    </div>
  </div>
</div>
<div class="reper-list" id="now">
  <?php include 'theatr.php' ?>
</div>
</section>
<?php include 'footer.php' ?>
