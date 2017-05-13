<?php
session_start();
include 'teatradmin/block/connect.php';
$db1 = Db::getConnection();
$message = 'Впишіть логін та пароль';

if (isset($_POST['login'])) {
  $login = $_POST['login'];
  if ($login == '') unset($login);
}
if (isset($_POST['pass'])) {
  $pass = $_POST['pass'];
  if ($pass == '') unset($pass);
}
if (isset($_POST['ok'])) {
  $currentUserLogin = $_POST['login'];
  $currentUserPassword = $_POST['pass'];
  $result = $db1->query("SELECT * FROM dt_userlist
                         WHERE login='$currentUserLogin'
                         AND pass='$currentUserPassword'");
  $result->fetch();
  if ($result->rowCount() != 1) {
    $message = "Введені логін і пароль не вірні";
  } else {
    $_SESSION['login'] = $_POST['login'];
    $_SESSION['pass'] = $_POST['pass'];
    Header("Location: protected.php");
  }

}

include 'header.php';
include 'top-line-menu.php';

?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">

<style>
.forma {
  text-align: center;
}
</style>

<div class="title">
  <h1>Вхід в адміністративну частину</h1>
</div><!-- end title -->

<div class="contacts">
  <div class="container">
    <div class="row">
      <div>
        <div class="forma">
          <div class="history-block-inf">
            <h2 style="font-size: 28px;"><?php echo $message; ?></h2>
          </div>
          <form method='POST' action='admin.php' class="form">
            <input type="text"  name="login" placeholder="Логін" required="required" />
            <input type="password" name="pass" placeholder="Пароль" required="required" />
            <button type="submit" name='ok'>Вхід</button>
          </form>

        </div><!-- end forma -->
      </div>
    </div><!-- end row -->
  </div><!-- end container -->
</div><!-- end contacts -->

</section><!-- end theatre -->

<?php include 'footer.php' ?>
