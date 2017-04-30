<?php $db=mysql_connect("localhost","cdda-ws15137","e812129988") or die ("error to database") ;
$res=mysql_select_db("cdda-ws15137",$db);
mysql_query("SET NAMES utf8");

?>

<?php include 'header-admin.php' ?>

<?php include 'top-line-menu-admin.php' ?>

<?php
function load_news_redaktor(){
$db=mysql_connect("localhost","cdda-ws15137","e812129988");
$res=mysql_select_db("cdda-ws15137",$db);


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
                <p><b>Завантажте фотографію працівника:</b><br/>

                <input type="file" name="photo" id="photo"/></p>

                <p><b>Прізвище та Імя:</b><br/>

                <input type="text" id="nam" name="nam" size="100" value=""/></p>

                <p><b>Посада:</b><br/>

                <input type="text" id="posada" name="posada" size="100" value=""/></p>

                <p>Заслуги:<br/>

                <textarea name="txt" id="txt" cols="100" rows="5"></textarea></p>

                <div id="ot1p"></div>

            </form><div id="message"></div>
           <!--кінець  вибірки керівництва-->

           <!-- вибірка працівника-->

           <div id="worrker"></div>


    <div class="container">
			<div class="row">
<?php

$db=mysql_connect("localhost","cdda-ws15137","e812129988");
$res=mysql_select_db("cdda-ws15137",$db);
mysql_query("SET NAMES utf8");

$result=mysql_query("SELECT * from dt_vistava");
$myrow=mysql_fetch_array($result);

do {
 printf ("<div class='col-md-6 col-sm-6'>
 <input alt='%s' name='checkbox' id='%s' class='my-checkbox' type='checkbox' value='%s'>%s</input>
 </div>", $myrow["id_rep"], $myrow["id"], $myrow["nazva"], $myrow["nazva"]);
}
while ($myrow=mysql_fetch_array($result));
 ?>
 </div><!-- end row -->
		</div><!-- end container -->

           <!--кінець  вибірки працівника-->
          <div id="id_direktor"></div>
          <input type="button" id="add_workers" name="add_workers" value="Добавити Актора"/>
          <input type="button" id="add" name="add" value="Добавити Вистави"/>
          </fieldset>
          <input type="hidden" id="text-input" />
          <fieldset>

            <legend>

		      <h2>Видалити:</h2>

            </legend>


             <select name="del_actors" id="del_actors">



<?php
$result=mysql_query("SELECT * from dt_actors");
$myrow=mysql_fetch_array($result);
mysql_query("SET NAMES utf8");
do {
 printf ("<p>
<option value='%s'>%s</option>

 </p> ", $myrow["id"], $myrow["name"]);
}
while ($myrow=mysql_fetch_array($result));


 ?>
 <input type="button" id="delet_workers" name="delet_workers" value="Видалити дані"/>
              </select>
              <div id="output_delete_actors"></div>

          </fieldset>

          <fieldset>

            <legend>

		      <h2>Змінити:</h2>

            </legend>
           <p>Виберіть категорію
           <select name="smena_dir" id="smena_dir">
                <option value="">Виберіть категорію</option>
                <?php echo load_news_redaktor(); ?>
           </select></p>

             <select name="smena_actors" id="smena_actors">
                <option value="">Виберіть працівника</option>
           </select>

           <div id="vivod_actors"></div>
           <form method="post" action="">
           <input type="button" id="change_workers" name="change_workers" value="Змінити дані"/>
           <input type="button" id="add2" name="add2" value="Змінити вистави"/>
           </form>
           <div id="messagea"></div>
          </fieldset>

        </div><!-- end row -->

    </div><!-- end container -->

</section><!-- end theatre -->
<!-- -->
<script>
        $(document).ready(function(){

            var znachids;

$("#por").change(function(){
            var ww=$("#por").val();
           $.ajax({
                url:"teatradmin/pr_up.php",
                method:"POST",
                data:{zminnaid:ww},
                dataType:"html",
                success:function(data)
                {
                    $("#ot").html(data);
                }
           });
      });

       $("#add_workers").click(function(){
           var znachname=$("#nam").val();
           var ww=$("#idf").val();
           var znachposada=$("#posada").val();
           var znachphoto=$("#photo").val();
           var znachtxt=$("#txt").val();
           var znachinp=$('#text-input').val();
           $.ajax({
                url:"teatradmin/add_actors.php",
                method:"POST",
                data:{zminnaname:znachname,zminnww:ww,    zminnaposada:znachposada,zminnaphoto:znachphoto, zminnatxt:znachtxt,zminnainp:znachinp },
                dataType:"html",
                success:function(data)
                {
                    $("#message").html(data);
                }
           });
            $("#send1")[0].reset();
      });
 $("#delet_workers").click(function(){
                znachid=$("#del_actors").val();

           $.ajax({
                url:"teatradmin/delete_actors.php",
                method:"POST",
                data:{zminnaid:znachid},
                dataType:"html",
                success:function(data)
                {
                     $("#output_delete_actors").html(data);
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
                url:"teatradmin/vivod.php",
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
          var znachidn=$("#idn").val();
           var znachname=$("#nama").val();
           var znachposada=$("#posad_a").val();
           var znachphoto=$("#phot_o").val();
           var znachtxt=$("#txtt").val();

           $.ajax({
                url:"teatradmin/din_up.php",
                method:"POST",
                data:{zminnaids:znachids,zminnaidn:znachidn,zminnaname:znachname, zminnaposada:znachposada,zminnaphoto:znachphoto,zminnatxt:znachtxt},
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
 $("#add").click(function(){
    $('input:checkbox:checked').each(function(){
      var $n = $(this).attr('id');
      var $m = $(this).attr("alt");

           $.ajax({
                url:"add_actors.php",
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
