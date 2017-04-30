<?php

$db = mysql_connect("localhost", "cdda-ws15137", "e812129988") or die ("die");
$res = mysql_select_db("cdda-ws15137", $db);

//инициализирум механизм сесссий
session_start();

//начинаем проверку логина и пароля
if (isset($_POST['login'])) {
  $login=$_POST['login'];
  if ($login=='') unset($login);
}
if (isset($_POST['pass'])) {
  $pass=$_POST['pass'];
  if ($pass=='') unset($pass);
}

$db = mysql_connect("localhost", "cdda-ws15137", "e812129988") or die ("die");
$res = mysql_select_db("cdda-ws15137", $db);

$res = mysql_query("SELECT * FROM dt_userlist WHERE login='".$_SESSION['login']."'
                    AND pass='".$_SESSION['pass']."'", $db);

if (mysql_num_rows($res) != 1) {
  // такого пользователя нет перенаправляем на login.php
  Header("Location: admin.php");
} else {
  //пользователь найден, можем выводить все что нам надо
}

mysql_close();
?>

<?php include 'teatradmin/block/connect.php' ?>
<?php include 'header-admin.php' ?>
<?php include 'top-line-menu-admin.php' ?>

<?php
function load_news_redaktor() {
  $result = mysql_query("SELECT * from dt_vistava");
  $myrow = mysql_fetch_array($result);
  do {
    printf ("<p>
             <option value='%s'>%s</option>
             </p>", $myrow["id"], $myrow["nazva"]);
  } while ($myrow = mysql_fetch_array($result));
}
?>

<section class="theatre parallax-window-news"
         data-parallax="scroll"
         data-image-src="/img/news/news-bg.jpg">
  <div class="container">
    <div class="row">
      <fieldset>
        <legend>
          <h2>Добавити в афішу:</h2>
        </legend>

        <form action="upload.php"
              method="post"
              enctype="multipart/form-data">
          <p>Виберіть афішу
            <select name="smena" id="smena">
              <option value="">Виберіть новину</option>
              <?php echo load_news_redaktor(); ?>
            </select>
          </p>
          <div id="redaktirov"></div>
          <input type="button"
                 name="add_afisha"
                 id="add_afisha"
                 value="Додати"/>
          <input type="button"
                 name="del_afisha"
                 id="del_afisha"
                 value="Видалити з афіши"/>
          <br><br>
          <div id="output_delete_news"></div>
        </form>

        <select onchange="test(this.value)"
                name="country">
          <option >___________</option>
          <option value="0">Не показувати наступний місяць</option>
          <option value="1">Показати наступний місяць</option>
          <input type="button"
                 id="submit1"
                 name="submit1"
                 value="Підтвердити">
          <div id="activated"></div>
        </select>

        <div id="coun" style="visibility:hidden"></div>

      </fieldset>
    </div><!-- end row -->
  </div><!-- end container -->
</section><!-- end theatre -->

<script>
var strana = '';
function test(Val) {
  document.getElementById('coun').innerHTML = Val;
  strana = Val;
};

$(document).ready(function() {
  $("#add_afisha").click(function() {
    var znachid = $("#idn").val();
    var znachnazva = $("#nazva").val();
    var znachstart = $("#start").val();
    var znachphotozag = $("#photozag").val();
    var znachavtor = $("#avtor").val();
    var znachtip = $("#tip").val();
    var znachtimes = $("#times").val();
    var znachid_rep = $("#id_rep").val();
    $.ajax({
      url: "teatradmin/add_afisha.php",
      method: "POST",
      data: {
        zminnaid: znachid,
        zminnanazva: znachnazva,
        zminnastart: znachstart,
        znachphotozag: znachphotozag,
        znachavtor: znachavtor,
        znachtip: znachtip,
        znachtimes: znachtimes,
        znachrep: znachid_rep
      },
      dataType: "html",
      success: function(data) {
        $("#output_delete_news").html(data);
      }
    });
  });

  $("#del_afisha").click(function() {
    var znachid = $("#idn").val();
    $.ajax({
      url: "teatradmin/delete_reper.php",
      method: "POST",
      data: {
        zminnaiddel: znachid
      },
      dataType: "html",
      success: function(data) {
        $("#output_delete_news").html(data);
      }
    });
  });

  $("#smena").change(function() {
    var znachid=$(this).val();
    $.ajax({
      url: "teatradmin/load_afisha.php",
      method: "POST",
      data: {
        zminnaid: znachid
      },
      dataType: "html",
      success: function(data) {
        $("#redaktirov").html(data);
      }
    });
  });

  $("#submit1").click(function() {
    $.ajax({
      url: "teatradmin/active.php",
      method: "POST",
      data: {
        zminnadeact: strana
      },
      dataType: "html",
      success: function(data) {
        $("#activated").html(data);
      }
    });
  });
});
</script>

<?php include 'footer.php' ?>
