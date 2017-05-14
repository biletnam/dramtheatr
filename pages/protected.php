<?php
include 'checkUser.php';

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
        <form action="teatradmin/add_actors.php" method="post" enctype="multipart/form-data">
          <p>Категорія працівника:</p>
          <select id="createWorkerCategory" style="width: 100%">
            <option value="1" selected>Художньо-керівний склад</option>
            <option value="2">Актори</option>
            <option value="3">Балет</option>
            <option value="4">Оркестр</option>
          </select>
          <p style="margin-top: 5px;">Зображення:</p>
          <input type="file" name="createWorkerImage">
          <p style="margin-top: 5px;">Порядок сортування:</p>
    			<input type="text" name="createWorkerRank" style="width: 100%">
          <p style="margin-top: 5px;">Прізвище та Імя:</p>
          <input type="text" name="createWorkerName" style="width: 100%">
          <p style="margin-top: 5px;">Посада:</p>
          <input type="text" name="createWorkerPosition" style="width: 100%">
          <p style="margin-top: 5px;">Заслуги:</p>
          <textarea name="createWorkerMerit" id="createWorkerMerit"></textarea>
          <input type="submit" name="createWorkerButton" value="Додати"/>
          <!-- <div id="ot1p"></div>
          <div id="worrker"></div> -->
          <!-- <div class="container">
            <div class="row">
              <?php //foreach($spectacles as $spectacle): ?>
                <div class='col-md-6 col-sm-6' style='font-size: 12px'>
                  <input id='<?php //echo $spectacle['id']; ?>'
                         alt='<?php //echo $spectacle['id_rep']; ?>'
                         name='checkbox' class='my-checkbox' type='checkbox'
                         value='<?php //echo $spectacle['nazva']; ?>'>
                    <?php //echo $spectacle['nazva']; ?>
                  </input>
                </div>
              <?php //endforeach; ?>
            </div>
          </div> -->
          <!-- <div id="id_direktor"></div> -->
          <!-- <input type="button" id="add" name="add" value="Добавити Вистави"/> -->
        </form>
      </fieldset>
      <!-- <input type="hidden" id="text-input" /> -->

      <fieldset><legend><h2>Видалити:</h2></legend>
        <select id="deletingSelect" style="width: 49%;display: inline-block;">
          <option>Виберіть категорію</option>
          <option value="1">Художньо-керівний склад</option>
          <option value="2">Актори</option>
          <option value="3">Балет</option>
          <option value="4">Оркестр</option>
        </select>
        <select id="workerId" style="width: 419px;display: inline-block;">
          <option>Виберіть працівника</option>
        </select>
        <input type="button" id="deleteWorkerButton" value="Видалити">
      </fieldset>

      <fieldset><legend><h2>Змінити:</h2></legend>
        <select id="selectUpdateWorkerCategory" style="width: 49%;display: inline-block;">
          <option>Виберіть категорію</option>
          <option value="1">Художньо-керівний склад</option>
          <option value="2">Актори</option>
          <option value="3">Балет</option>
          <option value="4">Оркестр</option>
        </select>
        <select id="selectUpdateWorker" style="width: 419px;display: inline-block;">
          <option>Виберіть працівника</option>
        </select>
        <div id="refreshUpdateWorker">
          <input type="submit" name="updateWorkerButton" value="Оновити">
        </div>
      </fieldset>

    </div>
  </div>
</section>

<script>
$(document).ready(function() {
  $('#createWorkerMerit').summernote({
    height: 300
  });

  var znachids;

  // $("#createWorkerButton").click(function() {
  //   var createWorkerName = $("#createWorkerName").val();
  //   var createWorkerRank = $("#createWorkerRank").val();
  //   var createWorkerCategory = $("#createWorkerCategory").val();
  //   var createWorkerPosition = $("#createWorkerPosition").val();
  //   var createWorkerMerit = $('#createWorkerMerit').summernote('code');
  //   var znachinp = $('#text-input').val();
  //   $.ajax({
  //     url: "teatradmin/add_actors.php",
  //     method: "POST",
  //     data: {
  //       createWorkerName: createWorkerName,
  //       createWorkerRank: createWorkerRank,
  //       createWorkerCategory: createWorkerCategory,
  //       createWorkerPosition: createWorkerPosition,
  //       createWorkerMerit: createWorkerMerit,
  //       zminnainp: znachinp
  //     },
  //     dataType:"html",
  //     success:function(data) {
  //       location.reload();
  //     }
  //   });
  // });

  $("#deleteWorkerButton").click(function() {
    workerId = $("#workerId").val();
    $.ajax({
      url: "teatradmin/delete_actors.php",
      method: "POST",
      data: {
        workerId: workerId
      },
      dataType: "html",
      success: function(data) {
        location.reload();
      }
    });
  });

  $("#deletingSelect").change(function() {
    var workerCategory = $(this).val();
    $.ajax({
      url: "teatradmin/fetch_state.php",
      method: "POST",
      data: {
        workerCategory: workerCategory
      },
      dataType: "html",
      success: function(data) {
        $("#workerId").html(data);
      }
    });
  });

  $("#selectUpdateWorkerCategory").change(function() {
    var workerCategory = $(this).val();
    $.ajax({
      url: "teatradmin/fetch_state.php",
      method: "POST",
      data: {
        workerCategory: workerCategory
      },
      dataType: "html",
      success: function(data) {
        $("#selectUpdateWorker").html(data);
      }
    });
  });

  $("#selectUpdateWorker").change(function() {
    var workerId = $(this).val();
    $.ajax({
      url: "teatradmin/vivod.php",
      method: "POST",
      data: {
        workerId: workerId
      },
      dataType: "html",
      success: function(data) {
        $("#refreshUpdateWorker").html(data);
      }
    });
  });

  // var $text = $('#text-input'),
  // $box = $('.my-checkbox');
  //
  // $box.on('click change', function() {
  //   var values = [];
  //   $box.filter(':checked').each(function() {
  //     values.push(this.value);
  //   });
  //   $text.val(values.join(','));
  // });
});

// $("#add").click(function() {
//   var checkedSpectacles = [];
//   $('input:checkbox:checked').each(function() {
//     var n = $(this).attr('id');
//     var m = $(this).attr("alt");
//     checkedSpectacles.push([n, m]);
//   });
//   checkedSpectacles.shift();
//   $.ajax({
//     url: "add_actors.php",
//     method: "POST",
//     data: {
//       checkedSpectacles: checkedSpectacles
//     },
//     dataType: "html",
//     success: function(data) {
//       $("#message").html(data);
//     }
//   });
// });

// $("#add2").click(function() {
//   znachids = $("#ids").val();
//   var checkedSpectacles = [];
//   $('input:checkbox:checked').each(function() {
//     var n = $(this).attr('id');
//     var m = $(this).attr("alt");
//     checkedSpectacles.push([n, m]);
//   });
//   checkedSpectacles.shift();
//   $.ajax({
//     url: "add_vistava.php",
//     method: "POST",
//     data: {
//       zminnaids: znachids,
//       checkedSpectacles: checkedSpectacles
//     },
//     dataType: "html",
//     success: function(data) {
//       $("#message").html(data);
//     }
//   });
// });

</script>

<?php include 'footerAdmin.php' ?>
