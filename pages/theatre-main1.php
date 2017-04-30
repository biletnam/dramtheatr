<?php include 'header.php' ?>

<?php include 'top-line-menu.php' ?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">

<div id="calendar"></div>
        <button id="add_event_button">Добавить событие</button>
        <div id="dialog-form" title="Событие">

            <p class="validateTips"></p>

    <form><?php echo $row['start']; ?>


           <?php
$result=mysql_query("SELECT id,type FROM dt_vistava where id='$event_type1' ");
$myrow=mysql_fetch_array($result);
do {
 printf ("<p><br><br>

<a href ='/pages/spectacle.php?id='>%s
 <img src='/pages/images/%s'></a>


 </p>", $myrow["id"], $myrow["type"],$myrow["filename"]);
}
while ($myrow=mysql_fetch_array($result));

 ?>
<p><label for="event_type1"></label>
                 <input type="text" id="event_type1" name="event_type1" value=""></p>

                 <p><label for="event_type"></label>
                 <input type="text" id="event_type" name="event_type" value=""></p>
<p><label for="event_start">Начало</label>
                 <input type="text" name="event_start" id="event_start"/></p>
                 <p><label for="event_end">Конец</label>
                 <input type="text" name="event_end" id="event_end"/></p>
                 <input type="hidden" name="event_id" id="event_id" value="">
             </form>
        </div>


<?php include 'footer-alternative.php' ?>
