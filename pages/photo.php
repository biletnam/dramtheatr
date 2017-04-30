<?php
$db=mysql_connect("localhost","cdda-ws15137","e812129988") or die ("die");
$res=mysql_select_db("cdda-ws15137",$db);
mysql_query("SET NAMES utf8");
session_start(); //инициализирум механизм сесссий
//начинаем проверку логина и пароля
if(isset($_POST['login'])) {$login=$_POST['login']; if ($login=='') {unset($login);} }
if(isset($_POST['pass'])) {$pass=$_POST['pass']; if ($pass=='') {unset($pass);} }

$db=mysql_connect("localhost","cdda-ws15137","e812129988") or die ("die");
$res=mysql_select_db("cdda-ws15137",$db);
mysql_query("SET NAMES utf8");
$res=mysql_query("SELECT * FROM dt_userlist WHERE login='".$_SESSION['login']."'
AND pass='".$_SESSION['pass']."'", $db);
if(mysql_num_rows($res)!=1){    //такого пользователя нет
  Header("Location: admin.php");  //перенаправляем на login.php
}
else{   //пользователь найден, можем выводить все что нам надо

}
mysql_close();
?><?php $db=mysql_connect("localhost","cdda-ws15137","e812129988") or die ("error to database") ;
$res=mysql_select_db("cdda-ws15137",$db);
mysql_query("SET NAMES utf8");

?>

<?php include 'header-admin.php' ?>

<?php include 'top-line-menu-admin.php' ?>

<?php
function load_news_redaktor() {
  $db = mysql_connect("localhost", "cdda-ws15137", "e812129988");
  $res = mysql_select_db("cdda-ws15137", $db);
  $result = mysql_query("SELECT * from dt_personal");
  $myrow = mysql_fetch_array($result);
  do {
    printf ("<p><option value='%s'>%s</option></p> ", $myrow["id"], $myrow["dol"]);
  }
  while ($myrow = mysql_fetch_array($result));
}
?>

<?php
function load_dol(){
  $result=mysql_query("SELECT * from dt_personal");
  $myrow=mysql_fetch_array($result);
  do {
    printf ("<p>
    <option value='%s'>%s</option>

    </p> ", $myrow["id"], $myrow["dol"]);
  }
  while ($myrow=mysql_fetch_array($result));
}
?>


<?php
function show_form(){
require 'teatradmin/block/connect.php';
?>

  <section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
    <div class="container">
      <div class="row">
        <fieldset>

          <legend><h2>Добавити:</h2></legend>
          <form action="teatradmin/sub.php" method="POST" enctype=multipart/form-data>

            <p>Завантажте файл:</p>
            <input type='file' name='uploadfile' id='uploadfile'/></br></br>

            <p>Зв'язати з працівником:</p>
            <select name="smena_dir" id="smena_dir">
              <option value="">Виберіть категорію</option>
              <?php echo load_news_redaktor(); ?>
            </select></br>

            <select name="smena_actors" id="smena_actors">
              <option value="">Виберіть працівника</option>
            </select></br></br>

            <div id="vivod_actors"></div>
            <div id="messagea"></div>

            <p>Зв'язати з виставою:</p>
            <select name="smena_tema" id="smena_tema">
              <option value=' '> </option>
              <?php
              $result = mysql_query("SELECT * from dt_vistava");
              $myrow = mysql_fetch_array($result);
              do {
                printf ("<p>
                <option value='%s'>%s</option>
                </p> ", $myrow["id"], $myrow["nazva"]);
              }
              while ($myrow = mysql_fetch_array($result));
              ?>
            </select></br></br>
            <div id="vivod_peps"></div>

            <p>Зв'язати з новиною:</p>
            <select name="smena" id="smena">
              <option value=' '> </option>

              <?php
              $result=mysql_query("SELECT * from dt_news");
              $myrow=mysql_fetch_array($result);
              do {
                printf ("<p>
                <option value='%s'>%s</option>
                </p> ", $myrow["id"], $myrow["tema"]);
              }
              while ($myrow=mysql_fetch_array($result));
              ?>
            </select></br></br>
            <div id="redaktirov"></div>
            <div id="vivod_peps"></div>

            <p>Вибрати місце розташування:</p>
            <select name="category" id="category">
              <option value='1'>Головна</option>
              <option value='2'>Банер</option>
              <option value='3'>Галерея</option>
            </select></br></br>

            <input type='submit' name='submit' value ='Внести'/></p>
          </form>
        </fieldset>
        <fieldset>

          <legend><h2>Видалити:</h2></legend>

          <input type="button" id="add" name="add" value="Видалити фото"/>
          <div id="message"></div>

          <!-- OUTPUT FOTO -->

          <?php

          $filelist = array();
          if ($handle = opendir("img/")) {

            while ($entry = readdir($handle)) {

              if (is_file($entry)) {

                $filelist[] = $entry;
              }

              $result=mysql_query("SELECT id, photo from dt_photo WHERE photo='$entry'");
              $myrow=mysql_fetch_array($result);
              if ($entry==$myrow["photo"]){



                do{
                  // if ($i==1){printf("<div class='row'>");}
                  ?>
                  <div class='col-md-3 col-sm-6'>
                    <figure class='team'>
                      <img src='img/<?php echo $myrow["photo"]; ?>' style="max-height: 100px;" />
                      <input name='checkbox' id='<?php echo $myrow["id"]; ?>' class='my-checkbox' type='checkbox'
                      value='<?php echo $myrow["photo"]; ?>'></input>
                    </figure>

                  </div><?php
                  //if ($i==4){printf("</div><!-- end row -->");
                  //$i=1;
                  // }

                }
                while ($myrow=mysql_fetch_array($result));
                //if ($i!=4)
                //{printf("</div><!-- end row -->");}





                //							echo "<form method='post' action='ss.php'>";
                //
                //                            do {
                //
                //								printf ("<input name='checkbox' id='%s' class='my-checkbox' type='checkbox' value='%s'></input>
                //								<div class='col-xs-6 col-sm-3 col-md-2 col-lg-1'>
                //                                <img src='img/%s'> </div>
                //								", $myrow["id"], $myrow["photo"],$myrow["photo"]);
                //							}
                //						while ($myrow=mysql_fetch_array($result));
                //						echo "</form>";
              }
            }

          }
          ?>
          <?php

          if (isset($_POST['zminnaw'])) {$zminnaw = $_POST['zminnaw'];}
          if(isset($zminnaw))
          if (isset($_POST['zminnam'])) {$zminnam = $_POST['zminnam'];}
          if(isset($zminnam))

          {
            $mys=mysql_query("DELETE FROM dt_photo WHERE id='$zminnaw'");

            if ($mys=='true') {echo "Рядок успішно видалений";
              unlink("img/$zminnam");
            }

            else {echo "error";}

          }

          ?>

          <!-- END FOTO   -->

        </fieldset>

      </div><!-- end row -->

    </div><!-- end container -->

  </section><!-- end theatre -->


  <script>
  $(document).ready(function(){
    $("#add").click(function(){
      $('input:checkbox:checked').each(function(){
        var $n = $(this).attr("id");
        var $m = $(this).attr("value");

        $.ajax({
          url:" ",
          method:"POST",
          data:{ zminnaw:$n,zminnam:$m},
          dataType:"html",
          success:function(data)
          {
            $("#message").html(data);
          }
        });

      });
    });

    $("#smena").change(function(){
      var znachid=$(this).val();
      $.ajax({
        url : "teatradmin/load_news_foto.php",
        method : "POST",
        data : { zminnaid : znachid },
        dataType : "html",
        success:function(data)
        {
          $("#redaktirov").html(data);
        }
      });
    });

    $("#smena_tema").change(function(){
      var znach1 = $(this).val();
      $.ajax({
        url:"teatradmin/output_new_photo.php",
        method:"POST",
        data:{zminna:znach1},
        dataType:"html",
        success:function(data) {
          $("#vivod_peps").html(data);
        }
      });
    });

    $("#smena_dir").change(function(){
      var country_id = $(this).val();
      $.ajax({
        url:"teatradmin/fetch_state.php",
        method:"POST",
        data:{countryId:country_id},
        dataType:"html",
        success:function(data)
        {
          $("#smena_actors").html(data);
        }
      });
    });
    $("#smena_actors").change(function(){
      var znach = $(this).val();
      $.ajax({
        url:"teatradmin/foto.php",
        method:"POST",
        data:{zminna:znach},
        dataType:"html",
        success:function(data)
        {
          $("#vivod_actors").html(data);
        }
      });
    });

    $("#change_workers").click(function(){
      znachids=$("#ids").val();
      // var znachidn=$("#idn").val();
      var znachname=$("#nama").val();
      var znachposada=$("#posad_a").val();
      var znachphoto=$("#phot_o").val();
      var znachtxt=$("#txtt").val();
      var znachsort=$("#sort").val();

      $.ajax({
        url:"teatradmin/din_up.php",
        method:"POST",
        data:{zminnaids:znachids,zminnaidn:znachidn,zminnaname:znachname, zminnaposada:znachposada,zminnaphoto:znachphoto,zminnatxt:znachtxt,zminnasort:znachsort},
        dataType:"html",
        success:function(data)
        {
          $("#messagea").html(data);
        }
      });
    });
    var $text = $('#text-input'),
    $box = $('.my-checkbox');

    $box.on('click change', function() {
      var values = [];

      $box.filter(':checked').each(function() {
        values.push(this.value);
      });

      $text.val(values.join(','));


    });

  });


  $("#add2").click(function(){
    $('input:checkbox:checked').each(function(){
      znachids=$("#ids").val();
      var $n = $(this).attr('id');
      var $m = $(this).attr("alt");

      $.ajax({
        url:"add_vistava.php",
        method:"POST",
        data:{ zminnaw:$n, zminnaids:znachids, zminnam:$m},
        dataType:"html",
        success:function(data)
        {
          $("#message").html(data);
        }
      });

    });

  });
  </script>

  <?php }
  show_form();
  ?>

  <?php include 'footer.php' ?>
