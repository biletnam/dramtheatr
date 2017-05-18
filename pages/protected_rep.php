<?php
include 'checkUser.php';

$result = $db1->query("SELECT * FROM dt_actors WHERE id_n = '1' OR id_n = '2' OR id_n = '3'");
$actors = array();
$i = 0;
while ($row = $result->fetch()) {
  $actors[$i]['id'] = $row['id'];
  $actors[$i]['id_n'] = $row['id_n'];
  $actors[$i]['name'] = substr($row['name'], 0, 40);
  $i++;
}

$result = $db1->query("SELECT * FROM dt_vistava");
$spectacles = array();
$i = 0;
while ($row = $result->fetch()) {
  $spectacles[$i]['id'] = $row['id'];
  $spectacles[$i]['nazva'] = $row['nazva'];
  $i++;
}

$result = $db1->query("SELECT * FROM dt_actors");
$workers = array();
$i = 0;
while ($row = $result->fetch()) {
  $workers[$i]['id'] = $row['id'];
  $workers[$i]['name'] = $row['name'];
  $i++;
}
?>

<section class="theatre parallax-window-news"
         data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
<div class="container">
  <div class="row">
    <fieldset>
      <legend><h2><b>Добавити:</b></h2></legend>
      <form action="teatradmin/add_spectacle.php" method="post" enctype="multipart/form-data">
        <p style="margin-top: 5px;">Виберіть аудиторію:</p>
        <select name="audience">
          <option value="1" selected>Для дорослих</option>
          <option value="2">Для дітей</option>
        </select>
        <p style="margin-top: 5px;">Назва вистави:</p>
        <input type="text" name="title" style="width: 100%">
        <p style="margin-top: 5px;">Зображення:</p>
        <input type="file" name="image">
        <p style="margin-top: 5px;">Автор вистави:</p>
        <input type="text" name="author" style="width: 100%">
        <p style="margin-top: 5px;">Тип вистави:</p>
        <input type="text" name="type" style="width: 100%">
        <p style="margin-top: 5px;">Тривалість вистави:</p>
        <input type="text" name="duration" style="width: 100%">
        <p style="margin-top: 5px;">Опис:</p>
        <textarea name="description"></textarea>
        <input type="submit" value="Додати">
      </form>
    </fieldset>

    <fieldset>
      <legend><h2>Видалити:</h2></legend>
      <p>Виберіть аудиторію та виставу:</p>
      <select name="audienceDeleting" style="width: 49%;display: inline-block;">
        <option value="">Виберіть аудиторію</option>
        <option value="1">Для дорослих</option>
        <option value="2">Для дітей</option>
      </select>
      <select name="titleDeleting" style="width: 419px;display: inline-block;">
        <option>Виберіть виставу</option>
      </select>
      <input type="button" id="buttonDeleting" value="Видалити">
    </fieldset>

    <fieldset>
      <legend><h2>Змінити:</h2></legend>
      <p>Виберіть аудиторію та виставу:</p>
      <select name="audienceUpdating" style="width: 49%;display: inline-block;">
        <option value="">Виберіть аудиторію</option>
        <option value="1">Для дорослих</option>
        <option value="2">Для дітей</option>
      </select>
      <select name="titleUpdating" style="width: 419px;display: inline-block;">
        <option>Виберіть виставу</option>
      </select>
      <div id="formUpdating"></div>
    </fieldset>
  </div>
</div>
</section>

<script>
$(document).ready(function() {
  $("textarea[name='description']").summernote({
    height: 300
  });

  $("select[name='audienceDeleting']").change(function() {
    var spectacleCategory = $(this).val();
    $.ajax({
      url: "teatradmin/change_select.php",
      method: "POST",
      data: {
        spectacleCategory: spectacleCategory
      },
      dataType: "html",
      success: function(data) {
        $("select[name='titleDeleting']").html(data);
      }
    });
  });

  $("#buttonDeleting").click(function() {
    var repertoireSpectacleId = $("select[name='titleDeleting']").val();
    $.ajax({
      url: "teatradmin/delete_reper.php",
      method: "POST",
      data: {
        repertoireSpectacleId: repertoireSpectacleId
      },
      dataType: "html",
      success: function(data) {
        location.reload();
      }
    });
  });

  $("select[name='audienceUpdating']").change(function() {
    var spectacleCategory = $(this).val();
    $.ajax({
      url: "teatradmin/change_select.php",
      method: "POST",
      data: {
        spectacleCategory: spectacleCategory
      },
      dataType: "html",
      success: function(data) {
        $("select[name='titleUpdating']").html(data);
      }
    });
  });

  $("select[name='titleUpdating']").change(function() {
    var spectacleId = $(this).val();
    $.ajax({
      url: "teatradmin/output_repert.php",
      method: "POST",
      data: {
        spectacleId: spectacleId
      },
      dataType: "html",
      success: function(data) {
        $("#formUpdating").html(data);
      }
    });
  });
});
</script>

<?php include 'footerAdmin.php' ?>
