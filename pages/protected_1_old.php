<?php
session_start();
include 'header-admin.php';
include 'top-line-menu-admin.php';
require 'teatradmin/block/connect.php';
$db1 = Db::getConnection();

$db = mysql_connect("localhost","cdda-ws15137","e812129988") or die ("die");
$res = mysql_select_db("cdda-ws15137",$db);
session_start(); //инициализирум механизм сесссий
//начинаем проверку логина и пароля
if(isset($_POST['login'])) {$login=$_POST['login']; if ($login=='') {unset($login);} }
if(isset($_POST['pass'])) {$pass=$_POST['pass']; if ($pass=='') {unset($pass);} }

$db=mysql_connect("localhost","cdda-ws15137","e812129988") or die ("die");
$res=mysql_select_db("cdda-ws15137",$db);
$res=mysql_query("SELECT * FROM dt_userlist WHERE login='".$_SESSION['login']."'
AND pass='".$_SESSION['pass']."'", $db);
if (mysql_num_rows($res) != 1) {  //такого пользователя нет
  Header("Location: admin.php");  //перенаправляем на login.php
}
mysql_close();

// include 'teatradmin/block/connect.php';
// include 'header-admin.php';
// include 'top-line-menu-admin.php';

function load_news_redaktor() {
  $result = mysql_query("SELECT * from dt_news");
  $myrow = mysql_fetch_array($result);
  do {
    printf ("<p><option value='%s'>%s</option></p> ", $myrow["id"], substr($myrow["tema"], 0, 200));
  } while ($myrow = mysql_fetch_array($result));
}
?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
  <div class="container">
    <div class="row">
      <fieldset>
        <legend><h2>Добавити:</h2></legend>
        <form name="form1"  method="post" action="" id="form1" >
          <p>Тема:</p>
          <input type="text" id="tema" name="tema" style="width: 100%"/><br/><br/>

          <p>Коротка стаття:</p>
          <div id="short_content"></div>

          <p>Повна стаття:</p>
          <div id="full_content"></div>

          <!-- <b>Завантажте головну фотографію:</b>
          <input type="file" name="photo" id="photo" accept="image/*" form="form2"/><br/> -->

          <p>Виберіть дату (місяць, день, рік):</p>
          <input type="date" name="date" id="date" value="2016-08-31"/>
          <input type="button" name="add_news" id="add_news" value="Додати"/>
          <div id="output_news"></div>
        </form><!-- endform -->
      </fieldset>

      <fieldset>
        <legend><h2>Видалити:</h2></legend>
        <form id="form3" name="form3" method="post" action="">
          <p>Виберіть новину яку потрібно видалити:</p>
          <select name="id_dels" id="id_dels">
            <option>Видалити виставу</option>
            <?php
            $result = mysql_query("SELECT tema,id FROM dt_news");
            $myrow = mysql_fetch_array($result);
            do {
              printf ("<p><option value='%s'>%s</option> </p> ", $myrow["id"], $myrow["tema"]);
            } while ($myrow=mysql_fetch_array($result));
            ?>
            <input type="button" name="delete" id="delete" value="Видалити"/>
          </select>
          <div id="output_delete_news"></div>
        </form><!-- end form -->
      </fieldset>

      <fieldset>
        <legend><h2>Змінити:</h2></legend>
        <p>Виберіть новину</p>
        <select name="smena" id="smena">
          <option>Виберіть новину</option>
          <?php echo load_news_redaktor(); ?>
        </select>
        <div id="redaktirov"></div>
        <input type="button" name="red" id="red" value="Зберегти"/>
        <div id="alert"></div>
      </fieldset>
    </div><!-- end row -->
  </div><!-- end container -->
</section><!-- end theatre -->

<script>
// добавлення новини

  $('#short_content').summernote({
  fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36', '48'],
  toolbar: [
    ['style', ['style']],
    ['font', ['bold', 'italic', 'underline', 'clear']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['insert', ['picture', 'video', 'link']],
    ['table', ['table']],
    ['fullscreen', ['fullscreen', 'codeview']]
  ],
  height: 100,
  focus: false
  });

  $("#full_content").summernote({
  fontSizes: ["8", "9", "10", "11", "12", "14", "16", "18", "24", "36", "48"],
  toolbar: [
    ["style", ["style"]],
    ["font", ["bold", "italic", "underline", "clear"]],
    ["fontname", ["fontname"]],
    ["fontsize", ["fontsize"]],
    ["color", ["color"]],
    ["para", ["ul", "ol", "paragraph"]],
    ["insert", ["picture", "video", "link"]],
    ["table", ["table"]],
    ["fullscreen", ["fullscreen", "codeview"]]
  ],
  height: 300,
  focus: false
  });

$(document).ready(function(){

  $("#add_news").click(function(){
    var znachtema = $("#tema").val();
    var znachtxt = $("#full_content").summernote('code');
    // var znachphoto = $("#photo").val();
    var znachdate = $("#date").val();
    $.ajax({
      url:"teatradmin/add_news.php",
      method:"POST",
      data:{
        zminnatema:znachtema,
        zminnatxt:znachtxt,
        // zminnaphoto:znachphoto,
        zminnadate:znachdate
      },
      dataType:"html",
      success:function (data) {
        $("#output_news").html(data);
        $("#form1")[0].reset();
      }
    });
  });

  // видалення новини
  $("#delete").click(function() {
    var znachid=$("#id_dels").val();
    alert (znachid);
    $.ajax({
      url:"teatradmin/del_news.php",
      method:"POST",
      data:{zminnaid:znachid},
      dataType:"html",
      success:function(data) {
        $("#output_delete_news").html(data);
      }
    });
  });

  // редагування новини
  $("#smena").change(function() {
    var znachid=$(this).val();
    $.ajax({
      url:"teatradmin/load_news.php",
      method:"POST",
      data:{zminnaid:znachid},
      dataType:"html",
      success:function(data) {
        $("#redaktirov").html(data);
      }
    });
  });
  $("#red").click(function() {
    var zid = $("#idn").val();
    var ztema = $("#temas").val();
    var ztxt = $("#edit_full_content").summernote('code');
    // var zphoto = $("#photos").val();
    var zdate = $("#posadas").val();
    $.ajax({
      url:"teatradmin/red_news.php",
      method:"POST",
      data:{
        zmid:zid,
        zmtema:ztema,
        zmtxt:ztxt,
        // zmphoto:zphoto,
        zmdate:zdate
      },
      dataType:"html",
      success:function(data) {
        $("#alert").html(data);
      }
    });
  });

});
</script>
<?php include 'footerAdmin.php' ?>
