<?php
include 'checkUser.php';

$result = $db1->query("SELECT * FROM dt_group_vistava");
$spectacleCategories = array();
$i = 0;
while ($row = $result->fetch()) {
  $spectacleCategories[$i]['id_reper'] = $row['id_reper'];
  $spectacleCategories[$i]['genre'] = $row['genre'];
  $i++;
}

$result = $db1->query("SELECT * FROM dt_actors");
$actors = array();
$i = 0;
while ($row = $result->fetch()) {
  $actors[$i]['id'] = $row['id'];
  $actors[$i]['id_n'] = $row['id_n'];
  $actors[$i]['name'] = $row['name'];
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

?>

<section class="theatre parallax-window-news"
         data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
<div class="container">
  <div class="row">
    <fieldset>
      <legend><h2><b>Добавити:</b></h2></legend>
      <select name="por" id="por">
        <option>До якого типу</option>
        <?php foreach ($spectacleCategories as $spectacleCategory): ?>
          <option value='<?php echo $spectacleCategory['id_reper']; ?>'>
            <?php echo $spectacleCategory['genre']; ?>
          </option>
        <?php endforeach; ?>
      </select>
      <br>
      <br>
      <div id="ot"></div>
      <form name="send1" id="send1" action="">
        <p>Назва вистави:</p>
        <input type="text" id="nazva" name="nazva" style="width: 100%"/><br/>
        <p>Автор вистави:</p>
        <input type="text" id="avtor" name="avtor" style="width: 100%"/><br/>
        <p>Тип вистави:</p>
        <input type="text" id="tip" name="tip" style="width: 100%"/><br/>
        <p>Тривалість вистави:</p>
        <input type="text" id="times" name="times" style="width: 100%"/><br/>
        <p>Опис та Актори:</p>
        <div id="txt"></div>
        <div id="ot1p"></div>
      </form>
      <div id="message"></div>
      <div class="container">
        <div class="row">
          <form id='myform' method='post'>
            <?php foreach ($actors as $actor): ?>
              <div class='col-md-6 col-sm-6' style='font-size: 14px'>
                <input type='text' size='2' id='sorting'>
                <input type='text' size='15' class='role'
                       id='<?php echo $actor['id']; ?>'>
                <input alt='<?php echo $actor['id_n']; ?>' name='checkbox'
                       id='<?php echo $actor['id']; ?>' class='my-checkbox'
                       type='checkbox'>
                  <?php echo $actor['name']; ?>
                </input>
              </div>
            <?php endforeach; ?>
          </form>
        </div>
      </div>
      <div id="worrker"></div>
      <div id="id_direktor"></div>
      <input type="button" id="add_reper" name="add_reper" value="Добавити"/>
      <input type="button" id="add" name="add" value="Добавити Акторів"/>
    </fieldset>

    <fieldset>
      <legend><h2>Видалити:</h2></legend>
      <select name="del_reper" id="del_reper">
        <option>Видалити виставу</option>
        <?php foreach ($spectacles as $spectacle): ?>
          <option value='<?php echo $spectacle['id']; ?>'>
            <?php echo $spectacle['nazva']; ?>
          </option>
        <?php endforeach; ?>
        <input type="button" id="delet_reperuar" name="delet_reperuar" value="Видалити"/>
      </select>
      <div id="output_delete_reper"></div>
    </fieldset>

    <fieldset>
      <legend><h2>Змінити:</h2></legend>
      <p>Виберіть категорію</p>
      <select name="smena_perept" id="smena_perept">
        <option>Виберіть категорію</option>
        <?php foreach ($spectacleCategories as $spectacleCategory): ?>
          <option value='<?php echo $spectacleCategory['id_reper']; ?>'>
            <?php echo $spectacleCategory['genre']; ?>
          </option>
        <?php endforeach; ?>
      </select>

      <select name="smena_tema" id="smena_tema">
        <option>Виберіть тему</option>
      </select>

      <div id="vivod_peps"></div>
      <form method="post">
        <input type="button" id="change_rep" name="change_rep" value="Змінити репертуар"/>
        <input type="button" id="add2" name="add2" value="Змінити ролі"/>
        <input type="button" id="add_chanche" name="add_chanche" value="Добавити ролі"/>
      </form>
      <div id="messagea"></div>
    </fieldset>
  </div>
</div>
</section>

<script>
$(document).ready(function() {
  $('#txt').summernote({
    height: 300
  });

  $("#add_reper").click(function() {
    var ww = $("#por").val();
    var znachtip = $("#tip").val();
    var znachphotozag = $("#photozag").val();
    var znachnazva = $("#nazva").val();
    var znachavtor = $("#avtor").val();
    var znachtimes = $("#times").val();
    var znachopis = $("#txt").summernote('code');
    $.ajax({
      url: "teatradmin/add_perertu.php",
      method: "POST",
      data: {
        zminnww: ww,
        zminnatip: znachtip,
        zminnaphotozag: znachphotozag,
        zminnanazva: znachnazva,
        zminnaavtor: znachavtor,
        zminnatimes: znachtimes,
        zminnaopis: znachopis
      },
      dataType: "html",
      success: function(data) {
        $("#message").html(data);
        location.reload();
      }
    });
  });

  $("#delet_reperuar").click(function() {
    var znachid = $("#del_reper").val();
    $.ajax({
      url: "teatradmin/delete_reper.php",
      method: "POST",
      data: {
        zminnaid: znachid
      },
      dataType: "html",
      success: function(data) {
        $("#output_delete_reper").html(data);
        location.reload();
      }
    });
  });

  $("#smena_perept").change(function() {
    var spectacleCategory = $(this).val();
    $.ajax({
      url: "teatradmin/change_select.php",
      method: "POST",
      data: {
        spectacleCategory: spectacleCategory
      },
      dataType: "html",
      success: function(data) {
        $("#smena_tema").html(data);
      }
    });
  });

  $("#smena_tema").change(function() {
    var spectacle = $(this).val();
    $.ajax({
      url: "teatradmin/output_repert.php",
      method: "POST",
      data: {
        spectacle: spectacle
      },
      dataType: "html",
      success: function(data) {
        $("#vivod_peps").html(data);
      }
    });
  });

  $("#change_rep").click(function() {
    var znachids = $("#ids_s").val();
    var znachidn = $("#idn_n").val();
    var znachtip = $("#tips").val();
    var znachphotozag = $("#photozags").val();
    var znachnazva = $("#nazvas").val();
    var znachtimes = $("#timess").val();
    var znachavtor = $("#avtors").val();
    var znachopis = $("#opiss").val();
    $.ajax({
      url: "teatradmin/change_perert.php",
      method: "POST",
      data: {
        zminnaids: znachids,
        zminnaidn: znachidn,
        zminnatip: znachtip,
        zminnaphotozag: znachphotozag,
        zminnanazva: znachnazva,
        zminnatimes: znachtimes,
        zminnaavtor: znachavtor,
        zminnaopis: znachopis
      },
      dataType: "html",
      success: function(data) {
        $("#messagea").html(data);
        console.log(data);
      }
    });
  });
});

$("#add").click(function() {
  $('input:checkbox:checked').each(function() {
    var $n = $(this).attr('id');
    var $m = $(this).attr("alt");
    var $addrole= $(this).siblings(".role").val();
    var $sorting= $(this).siblings("#sorting").val();

    $.ajax({
      url:"add_vistavas.php",
      method:"POST",
      data:{
        zminnaw:$n,
        zminnam:$m,
        zminnarole:$addrole,
        sorting:$sorting
      },
      dataType:"html",
      success:function(data) {
        $("#message").html(data);
      }
    });
  });
});

$("#add_chanche").click(function() {
  $('input:checkbox:checked').each(function() {
    var $n = $(this).attr('id');
    var $m = $(this).attr("alt");
    var $role= $(this).siblings(".mytxt").val();
    var $mysort= $(this).siblings("#idska").val();
    $.ajax({
      url:"add_vistavas.php",
      method:"POST",
      data:{
        zminnaw:$n,
        zminnam:$m,
        zminnarole:$role,
        sorts:$mysort
      },
      dataType:"html",
      success:function(data) {
        $("#message").html(data);
      }
    });
  });
});

$("#add2").click(function() {
  $('input:checkbox:checked').each(function() {
    var znachids=$("#ids_s").val();
    var $n = $(this).attr('id');
    var $m = $(this).attr("alt");
    var $roles= $(this).siblings(".mytxt").val();
    var $mysorts= $(this).siblings(".idska").val();
    $.ajax({
      url:"add_actor.php",
      method:"POST",
      data:{
        zminnaw:$n,
        zminnam:$m,
        zminnaroles:$roles,
        zminnaids:znachids,
        sortss:$mysorts
      },
      dataType:"html",
      success:function(data) {
        $("#message").html(data);
      }
    });
  });
});
</script>
<?php include 'footerAdmin.php' ?>
