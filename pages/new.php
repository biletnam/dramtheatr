<?php include 'header-admin.php' ?>
<?php include 'top-line-menu-admin.php' ?>

<?php
function load_news_redaktor() {
  $result = mysql_query("SELECT * FROM dt_news");
  $myrow = mysql_fetch_array($result);
  do {
    printf("<p><option value='%s'>%s</option></p>", $myrow["id"], $myrow["tema"]);
  } while ($myrow=mysql_fetch_array($result));
}
?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
  <div class="container">
    <div class="row">
      <fieldset>
        <legend>
          <h2>Добавити:</h2>
        </legend>
        <form name="form1"  method="post" action="" id="form1" >
          <p><b>Тема:</b><br/>
            <input type="text" id="tema" name="tema"  size="100"/></p>
            <p>Текст:<br/>
              <textarea name="txt" id="txt" cols="100" rows="5"></textarea></p>
              <p><b>Завантажте головну фотографію:</b><br/>
                <input type="file" name="photo" id="photo" accept="image/*" form="form1"/></p>
                <p>Выберите дату:
                  <input type="date" name="date" id="date"  value="2016-08-31"/></p>
                  <input type="button" name="add_news" id="add_news" value="Додати"  />
                  <div id="output_news"></div>
                </form><!-- end form -->
              </fieldset>
              <fieldset>
                <legend>
                  <h2>Видалити:</h2>
                </legend>
                <form id="form3" name="form3" method="post" action="">
                  <p>Виберіть новину яку потрібно видалити: <br/>
                    <?php
                    $result = mysql_query("SELECT tema, id FROM dt_news");
                    $myrow = mysql_fetch_array($result);
                    do {
                      printf ("<p><input name='id_del' id='id_del' type='radio' value='%s'><label> %s</label></p>",$myrow["id"],$myrow["tema"]);
                    } while ($myrow = mysql_fetch_array($result));
                    ?>
                    <input type="button" name="delete" id="delete" value="Видалити"  />
                    <div id="output_delete_news"></div>
                  </form><!-- end form -->
                </fieldset>
                <fieldset>
                  <legend>
                    <h2>Змінити:</h2>
                  </legend>
                  <p>Виберіть новину
                    <select name="smena" id="smena">
                      <option value="">Виберіть новину</option>
                      <?php echo load_news_redaktor(); ?>
                    </select>
                  </p>
                  <div id="redaktirov"></div>
                  <input type="button" name="red" id="red" value="Редагувати"/>
                  <div id="alert"></div>
                </fieldset>
              </div><!-- end row -->
            </div><!-- end container -->
          </section><!-- end theatre -->

          <script>

          // добавлення новини
          $(document).ready(function(){
            $("#add_news").click(function(){
              var znachtema=$("#tema").val();
              var znachtxt=$("#txt").val();
              var znachphoto=$("#photo").val();
              var znachdate=$("#date").val();
              $.ajax({
                url:"teatradmin/add_news.php",
                method:"POST",
                data: {
                  zminnatema:znachtema,
                  zminnatxt:znachtxt,
                  zminnaphoto:znachphoto,
                  zminnadate:znachdate
                },
                dataType:"html",
                success:function(data) {
                  $("#output_news").html(data);
                }
              });
            });

            // видалення новини
            $("#delete").click(function(){
              var znachid=$("#id_del").val();

              $.ajax({
                url:"teatradmin/del_news.php",
                method:"POST",
                data:{zminnaid:znachid},
                dataType:"html",
                success:function(data)
                {
                  $("#output_delete_news").html(data);
                }
              });
            });
            //  кінець видалення новини
            $("#smena").change(function(){
              var znachid=$(this).val();

              $.ajax({
                url:"teatradmin/load_news.php",
                method:"POST",
                data:{zminnaid:znachid},
                dataType:"html",
                success:function(data)
                {
                  $("#redaktirov").html(data);
                }
              });
            });


            // редагування новини
            $("#red").click(function(){
              var zid=$("#idn").val();
              var ztema=$("#temas").val();
              var ztxt=$("#txts").val();
              var zphoto=$("#photos").val();
              var zdate=$("#posadas").val();
              alert (ztxt);
              alert (zphoto);
              alert (zdate);

              $.ajax({
                url:"teatradmin/red_news.php",
                method:"POST",
                data:{zmid:zid, zmtema:ztema, zmtxt:ztxt,zmphoto:zphoto,zmdate:zdate},
                dataType:"html",
                success:function(data)
                {
                  $("#alert").html(data);
                }
              });
            });
          });

          </script>
          
          <?php include 'footer.php' ?>
