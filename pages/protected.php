<?php
include 'checkUser.php';

$result = $db1->query("SELECT * FROM dt_personal");
$departments = array();
$i = 0;
while ($row = $result->fetch()) {
  $departments[$i]['id'] = $row['id'];
  $departments[$i]['dol'] = $row['dol'];
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

$result = $db1->query("SELECT * FROM dt_vistava");
$spectacles = array();
$i = 0;
while ($row = $result->fetch()) {
  $spectacles[$i]['id'] = $row['id'];
  $spectacles[$i]['id_rep'] = $row['id_rep'];
  $spectacles[$i]['nazva'] = $row['nazva'];
  $i++;
}
?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
  <div class="container">
    <div class="row">

      <fieldset><legend><h2>Добавити:</h2></legend>
        <select name="por" id="por" style="width: 100%">
          <option value="">До якого типу</option>
          <?php foreach($departments as $department): ?>
            <option value='<?php echo $department['id']; ?>'>
              <?php echo $department['dol']; ?>
            </option>
          <?php endforeach; ?>
        </select>
        <br>
        <br>
        <form name="send1" id="send1">
          <p>Прізвище та Імя:</p>
          <input type="text" id="nam" name="nam" style="width: 100%"/>
          <p>Посада:</p>
          <input type="text" id="posada" name="posada" style="width: 100%"/>
          <p>Заслуги:</p>
          <div id="txt"></div>
          <div id="ot1p"></div>
        </form>
        <div id="message"></div>
        <div id="worrker"></div>
        <div class="container">
          <div class="row">
            <?php foreach($spectacles as $spectacle): ?>
              <div class='col-md-6 col-sm-6' style='font-size: 12px'>
                <input id='<?php echo $spectacle['id']; ?>'
                       alt='<?php echo $spectacle['id_rep']; ?>'
                       name='checkbox' class='my-checkbox' type='checkbox'
                       value='<?php echo $spectacle['nazva']; ?>'>
                  <?php echo $spectacle['nazva']; ?>
                </input>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <div id="id_direktor"></div>
        <input type="button" id="add_workers" name="add_workers" value="Добавити Актора"/>
        <input type="button" id="add" name="add" value="Добавити Вистави"/>
      </fieldset>
      <input type="hidden" id="text-input" />

      <fieldset><legend><h2>Видалити:</h2></legend>
        <select name="del_actors" id="del_actors">
          <?php foreach($workers as $worker): ?>
            <option value='<?php echo $worker['id']; ?>'>
              <?php echo $worker['name']; ?>
            </option>
          <?php endforeach; ?>
          <input type="button" id="delet_workers" name="delet_workers" value="Видалити дані"/>
        </select>
        <div id="output_delete_actors"></div>
      </fieldset>

      <fieldset><legend><h2>Змінити:</h2></legend>
        <p>Виберіть категорію</p>
        <select name="smena_dir" id="smena_dir">
          <option value="">Виберіть категорію</option>
          <?php foreach($departments as $department): ?>
            <option value='<?php echo $department['id']; ?>'>
              <?php echo $department['dol']; ?>
            </option>
          <?php endforeach; ?>
        </select>

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

    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  $('#txt').summernote({
    height: 300
  });

  var znachids;

  $("#add_workers").click(function() {
    var znachname = $("#nam").val();
    var ww = $("#por").val();
    var znachposada = $("#posada").val();
    var znachtxt = $('#txt').summernote('code');
    var znachinp = $('#text-input').val();
    $.ajax({
      url: "teatradmin/add_actors.php",
      method: "POST",
      data: {
        zminnaname: znachname,
        zminnww: ww,
        zminnaposada: znachposada,
        zminnatxt: znachtxt,
        zminnainp: znachinp
      },
      dataType:"html",
      success:function(data) {
        $("#message").html(data);
      }
    });

  });

  $("#delet_workers").click(function() {
    znachid = $("#del_actors").val();
    $.ajax({
      url: "teatradmin/delete_actors.php",
      method: "POST",
      data: {
        zminnaid: znachid
      },
      dataType: "html",
      success: function(data) {
        $("#output_delete_actors").html(data);
      }
    });
  });

  $("#smena_dir").change(function() {
    var country_id = $(this).val();
    $.ajax({
      url: "teatradmin/fetch_state.php",
      method: "POST",
      data: {
        countryId: country_id
      },
      dataType: "html",
      success: function(data) {
        $("#smena_actors").html(data);
      }
    });
  });

  $("#smena_actors").change(function() {
    var znach = $(this).val();
    $.ajax({
      url: "teatradmin/vivod.php",
      method: "POST",
      data: {
        zminna: znach
      },
      dataType: "html",
      success: function(data) {
        $("#vivod_actors").html(data);
      }
    });
  });

  $("#change_workers").click(function() {
    znachids = $("#ids").val();
    var znachidn = $("#idn").val();
    var znachname = $("#nama").val();
    var znachposada = $("#posad_a").val();
    var znachtxt = $("#txtt").summernote('code');
    var znachsort = $("#sort").val();
    $.ajax({
      url: "teatradmin/din_up.php",
      method: "POST",
      data: {
        zminnaids: znachids,
        zminnaidn: znachidn,
        zminnaname: znachname,
        zminnaposada: znachposada,
        zminnatxt: znachtxt,
        zminnasort: znachsort
      },
      dataType: "html",
      success: function(data) {
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

$("#add").click(function() {
  var checkedSpectacles = [];
  $('input:checkbox:checked').each(function() {
    var n = $(this).attr('id');
    var m = $(this).attr("alt");
    checkedSpectacles.push([n, m]);
  });
  checkedSpectacles.shift();
  $.ajax({
    url: "add_actors.php",
    method: "POST",
    data: {
      checkedSpectacles: checkedSpectacles
    },
    dataType: "html",
    success: function(data) {
      $("#message").html(data);
    }
  });
});

$("#add2").click(function() {
  znachids = $("#ids").val();
  var checkedSpectacles = [];
  $('input:checkbox:checked').each(function() {
    var n = $(this).attr('id');
    var m = $(this).attr("alt");
    checkedSpectacles.push([n, m]);
  });
  checkedSpectacles.shift();
  $.ajax({
    url: "add_vistava.php",
    method: "POST",
    data: {
      zminnaids: znachids,
      checkedSpectacles: checkedSpectacles
    },
    dataType: "html",
    success: function(data) {
      $("#message").html(data);
    }
  });

});
</script>

<?php include 'footerAdmin.php' ?>
