

<?php include 'header-admin.php' ?>

<?php include 'top-line-menu-admin.php' ?>

<?php
function load_news_redaktor(){

$result=mysql_query("SELECT * from dt_group_vistava");
$myrow=mysql_fetch_array($result);
do {
 printf ("<p>
<option value='%s'>%s</option>

 </p> ", $myrow["id_reper"], $myrow["genre"]);
}
while ($myrow=mysql_fetch_array($result));

}
 ?>
 <?php
function load_dol(){

$result=mysql_query("SELECT * from dt_group_vistava");
$myrow=mysql_fetch_array($result);
do {
 printf ("<p>
<option value='%s'>%s</option>

 </p> ", $myrow["id_reper"], $myrow["genre"]);
}
while ($myrow=mysql_fetch_array($result));

}
?>

<?php function show_form(){
    require 'teatradmin/block/connect.php';?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">

    <div class="container">

        <div class="row">

          <fieldset>

            <legend>

		      <h2>Добавити:</h2>

            </legend>
            <!-- вибірка керівництва-->

          <select name="por" id="por">
                <option value="">До якого типу</option>
                <?php echo load_dol() ?>
            </select>
           <div id="ot"></div>

            <form name="send1" id="send1" action="">
            <p><b>Вкажіть номер папки з фото:</b><br/>

                <input type="text" name="photozag" id="photozag"/></p>

                <p><b>Назва вистави:</b><br/>

                <input type="text" id="nazva" name="nazva" size="100" value=""/></p>

                <p><b>Автор вистави:</b><br/>

                <input type="text" id="avtor" name="avtor" size="100" value=""/></p>

                <p><b>Тип вистави:</b><br/>

                <input type="text" id="tip" name="tip" size="100" value=""/></p>

                <p><b>Тривалість вистави:</b><br/>

                <input type="text" id="times" name="times" size="100" value=""/></p>

                <p>Опис та Актори:<br/>

                <textarea name="opis" id="opis" cols="100" rows="5"></textarea></p>

                <div id="ot1p"></div>

</form><div id="message"></div>
           <!--кінець  вибірки керівництва-->
   <div class="container">
			<div class="row">
<?php

$db=mysql_connect("localhost","cdda-ws15137","e812129988");
$res=mysql_select_db("cdda-ws15137",$db);
mysql_query("SET names 'utf-8'");

$result=mysql_query("SELECT * from dt_actors");
$myrow=mysql_fetch_array($result);

do {
 printf ("<div class='col-md-4 col-sm-6'>
<input alt='%s' name='checkbox' id='%s' class='my-checkbox' type='checkbox' value='%s'>%s</input>
</div>", $myrow["id_n"], $myrow["id"], $myrow["name"], $myrow["name"]);
}
while ($myrow=mysql_fetch_array($result));

 ?>
      </div><!-- end row -->
		</div><!-- end container -->

           <!-- вибірка працівника-->

           <div id="worrker"></div>
           <!--кінець  вибірки працівника-->
          <div id="id_direktor"></div>
          <input type="button" id="add_reper" name="add_reper" value="Добавити"/>
           <input type="button" id="add" name="add" value="Добавити Акторів"/>
          </fieldset>

          <fieldset>

            <legend>

		      <h2>Видалити:</h2>

            </legend>


             <select name="del_reper" id="del_reper">
                <option value="">Видалити виставу</option>


            <?php
$result=mysql_query("SELECT * from dt_vistava");
$myrow=mysql_fetch_array($result);
do {
 printf ("<p>
<option value='%s'>%s</option>

 </p> ", $myrow["id"], $myrow["nazva"]);
}
while ($myrow=mysql_fetch_array($result));


 ?>
 <input type="button" id="delet_reperuar" name="delet_reperuar" value="Видалити"/>
              </select>
              <div id="output_delete_reper"></div>

          </fieldset>

          <fieldset>

            <legend>

		      <h2>Змінити:</h2>

            </legend>
           <p>Виберіть категорію
           <select name="smena_perept" id="smena_perept">
                <option value="">Виберіть категорію</option>
                <?php echo load_news_redaktor(); ?>
           </select></p>

             <select name="smena_tema" id="smena_tema">
                <option value="">Виберіть тему</option>
           </select>

           <div id="vivod_peps"></div>
           <form method="post" action="">
           <input type="button" id="change_rep" name="change_rep" value="Змінити"/>
           <input type="button" id="add2" name="add2" value="Змінити акторів"/>
           </form>
           <div id="messagea"></div>
          </fieldset>

        </div><!-- end row -->

    </div><!-- end container -->

</section><!-- end theatre -->
<!-- -->
<script>
        $(document).ready(function(){





$("#por").change(function(){
            var ww=$("#por").val();
           $.ajax({
                url:"teatradmin/add_repe.php",
                method:"POST",
                data:{zminnaid:ww},
                dataType:"html",
                success:function(data)
                {
                    $("#ot").html(data);
                }
           });
      });

       $("#add_reper").click(function(){
           var ww=$("#id_rep").val();
           var znachtip=$("#tip").val();
           var znachphotozag=$("#photozag").val();
           var znachnazva=$("#nazva").val();
           var znachavtor=$("#avtor").val();
           var znachtimes=$("#times").val();
           var znachopis=$("#opis").val();

           $.ajax({
                url:"teatradmin/add_perertu.php",
                method:"POST",
                data:{zminnww:ww,zminnatip:znachtip,zminnaphotozag:znachphotozag, zminnanazva:znachnazva,zminnaavtor:znachavtor,zminnatimes:znachtimes,zminnaopis:znachopis },
                dataType:"html",
                success:function(data)
                {
                    $("#message").html(data);
                }
           });
            $("#send1")[0].reset();
      });
 $("#delet_reperuar").click(function(){
                var znachid=$("#del_reper").val();

           $.ajax({
                url:"teatradmin/delete_reper.php",
                method:"POST",
                data:{zminnaid:znachid},
                dataType:"html",
                success:function(data)
                {
                     $("#output_delete_reper").html(data);
                }
           });
      });



    $("#smena_perept").change(function(){
           var country_id = $(this).val();
           $.ajax({
                url:"teatradmin/change_select.php",
                method:"POST",
                data:{countryId:country_id},
                dataType:"html",
                success:function(data)
                {
                     $("#smena_tema").html(data);
                }
           });
      });
       $("#smena_tema").change(function(){
           var znach1 = $(this).val();

           $.ajax({
                url:"teatradmin/output_repert.php",
                method:"POST",
                data:{zminna:znach1},
                dataType:"html",
                success:function(data)
                {
                     $("#vivod_peps").html(data);
                }
           });
      });

    $("#change_rep").click(function(){
            var znachids=$("#ids_s").val();
            var znachidn=$("#idn_n").val();
            var znachtip=$("#tips").val();
            var znachphotozag=$("#photozags").val();
            var znachnazva=$("#nazvas").val();
            var znachtimes=$("#timess").val();
            var znachavtor=$("#avtors").val();
            var znachopis=$("#opiss").val();

           $.ajax({
                url:"teatradmin/change_perert.php",
                method:"POST",
                data:{zminnaids:znachids,zminnaidn:znachidn,zminnatip:znachtip, zminnaphotozag:znachphotozag,zminnanazva:znachnazva,zminnatimes:znachtimes,zminnaavtor:znachavtor,zminnaopis:znachopis},
                dataType:"html",
                success:function(data)
                {
                    $("#messagea").html(data);
                }
           });
      });

 });

  $("#add").click(function(){
    $('input:checkbox:checked').each(function(){
      var $n = $(this).attr('id');
      var $m = $(this).attr("alt");

           $.ajax({
                url:"add_vistavas.php",
                method:"POST",
                data:{ zminnaw:$n, zminnam:$m},
                dataType:"html",
                success:function(data)
                {
                    $("#message").html(data);
                }
           });

      });

 });

  $("#add2").click(function(){
    $('input:checkbox:checked').each(function(){
          znachids=$("#ids_s").val();
      var $n = $(this).attr('id');
      var $m = $(this).attr("alt");

           $.ajax({
                url:"add_actor.php",
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
