<?php  $db=mysql_connect("localhost","cdda-ws15137","e812129988") or die ("die");
$res=mysql_select_db("cdda-ws15137",$db);
session_start(); //инициализирум механизм сесссий
//начинаем проверку логина и пароля
if(isset($_POST['login'])) {$login=$_POST['login']; if ($login=='') {unset($login);} }
if(isset($_POST['pass'])) {$pass=$_POST['pass']; if ($pass=='') {unset($pass);} }


$db=mysql_connect("localhost","cdda-ws15137","e812129988") or die ("die");
$res=mysql_select_db("cdda-ws15137",$db);
$res=mysql_query("SELECT * FROM dt_userlist WHERE login='".$_SESSION['login']."'
    AND pass='".$_SESSION['pass']."'", $db);
if(mysql_num_rows($res)!=1){    //такого пользователя нет
    Header("Location: admin.php");  //перенаправляем на login.php
}
else{   //пользователь найден, можем выводить все что нам надо
    echo "<a href='logout.php'>Вихід</a>";


}
mysql_close();
?>
<?php include 'teatradmin/block/connect.php' ?>

<?php include 'header-admin.php' ?>

<?php include 'top-line-menu-admin.php' ?>




<?php
function load_news_redaktor(){

$result=mysql_query("SELECT * from dt_vistava");
$myrow=mysql_fetch_array($result);
do {
 printf ("<p>
<option value='%s'>%s</option>

 </p> ", $myrow["id"], $myrow["nazva"]);
}
while ($myrow=mysql_fetch_array($result));

}
 ?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">

    <div class="container">

        <div class="row">

          <fieldset>

            <legend>

		      <h2>Добавити в афішу:</h2>


            </legend>
           <p>Виберіть афішу
             <form action="upload.php" method="post" enctype="multipart/form-data">

           <select name="smena" id="smena">
                <option value="">Виберіть новину</option>
                <?php echo load_news_redaktor(); ?>
           </select></p>
           <div id="redaktirov"></div>
           <input type="button" name="add_afisha" id="add_afisha" value="Додати"/>
           <div id="output_delete_news"></div>

              </form>
          </fieldset>
        </div><!-- end row -->

    </div><!-- end container -->

</section><!-- end theatre -->

 <script>
 $(document).ready(function(){
   $("#add_afisha").click(function(){
                var znachid=$("#idn").val();
                var znachnazva=$("#nazva").val();
                var znachstart=$("#start").val();
                var znachphotozag=$("#photozag").val();
       var znachavtor=$("#avtor").val();
       var znachtip=$("#tip").val();
       var znachtimes=$("#times").val();

           $.ajax({
                url:"teatradmin/add_afisha.php",
                method:"POST",
                data:{zminnaid:znachid,zminnanazva:znachnazva,zminnastart:znachstart,znachphotozag:znachphotozag,znachavtor:znachavtor,znachtip:znachtip,znachtimes:znachtimes},
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
                url:"teatradmin/load_afisha.php",
                method:"POST",
                data:{zminnaid:znachid},
                dataType:"html",
                success:function(data)
                {
                     $("#redaktirov").html(data);
                }
           });
      });


   });
  //  кінець редагування новини

         </script>




<?php include 'footer.php' ?>
