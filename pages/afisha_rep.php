
<?php
include 'checkUser.php';

$result = $db1->query("SELECT * FROM dt_vistava ORDER BY id DESC");
$spectacles = array();
$i = 0;
while ($row = $result->fetch()) {
  $spectacles[$i]['id'] = $row['id'];
  $spectacles[$i]['nazva'] = $row['nazva'];
  $i++;
}

$result = $db1->query("SELECT * FROM dt_group_afisha ORDER BY start ASC");
$afficheSpectacles = array();
$i = 0;
while ($row = $result->fetch()) {
  $afficheSpectacles[$i]['id'] = $row['id'];
  $afficheSpectacles[$i]['themas'] = $row['themas'];
  $afficheSpectacles[$i]['start'] = $row['start'];
  $i++;
}

?>

<section class="theatre parallax-window-news"
         data-parallax="scroll"
         data-image-src="/img/news/news-bg.jpg">
  <div class="container">
    <div class="row">
      <fieldset>
        <legend>
          <h2>Добавити в афішу:</h2>
        </legend>
        <p>Виберіть виставу яку потрібно додати в афішу</p>
        <select id="smena">
          <option value="">Вистави з репертуару</option>
          <?php foreach ($spectacles as $spectacle): ?>
            <option value="<?php echo $spectacle['id']; ?>"><?php echo $spectacle['nazva']; ?></option>
          <?php endforeach; ?>
        </select>
        <div id="redaktirov"></div>
        <input type="button"
               name="add_afisha"
               id="add_afisha"
               value="Додати"/>
        <br><br>
        <p>Виберіть виставу яку потрібно видалити з афіші</p>
        <select id="deleteAfficheSpectacleById">
          <option value="">Вистави з афіші</option>
          <?php foreach ($afficheSpectacles as $afficheSpectacle): ?>
            <option value="<?php echo $afficheSpectacle['id']; ?>">
              <?php echo $afficheSpectacle['start'] . " " . $afficheSpectacle['themas']; ?>
            </option>
          <?php endforeach; ?>
        </select>
        <input type="button"
               name="del_afisha"
               id="del_afisha"
               value="Видалити"/>
        <br><br>

        <div id="coun" style="visibility:hidden"></div>

      </fieldset>
    </div>
  </div>
</section>
<div id="snackbar">Some text some message..</div>

<script>
var strana = '';
function test(Val) {
  document.getElementById('coun').innerHTML = Val;
  strana = Val;
};

$(document).ready(function() {
  $("#add_afisha").click(function() {
    var znachid = $("#idn").val();
    var znachtip = $("#tip").val();
    var znachnazva = $("#nazva").val();
    var znachstart = $("#start").val();
    var znachavtor = $("#avtor").val();
    var znachtimes = $("#times").val();
    var znachid_rep = $("#id_rep").val();
    var znachphotozag = $("#photozag").val();
    $.ajax({
      url: "teatradmin/add_afisha.php",
      method: "POST",
      data: {
        zminnaid: znachid,
        znachtip: znachtip,
        znachrep: znachid_rep,
        znachavtor: znachavtor,
        znachtimes: znachtimes,
        zminnanazva: znachnazva,
        zminnastart: znachstart,
        znachphotozag: znachphotozag
      },
      dataType: "html",
      success: function(data) {
        location.reload();
      }
    });
  });

  $("#del_afisha").click(function() {
    var znachid = $("#deleteAfficheSpectacleById").val();
    $.ajax({
      url: "teatradmin/delete_reper.php",
      method: "POST",
      data: {
        zminnaiddel: znachid
      },
      dataType: "html",
      success: function(data) {
        location.reload();
      }
    });
  });

  $("#smena").change(function() {
    var znachid = $(this).val();
    $.ajax({
      url: "teatradmin/load_afisha.php",
      method: "POST",
      data: {
        zminnaid: znachid
      },
      dataType: "html",
      success: function(data) {
        $("#redaktirov").html(data);
      }
    });
  });

  // $("#submit1").click(function() {
  //   $.ajax({
  //     url: "teatradmin/active.php",
  //     method: "POST",
  //     data: {
  //       zminnadeact: strana
  //     },
  //     dataType: "html",
  //     success: function(data) {
  //       // $("#activated").html(data);
  //       $("#snackbar").text(data);
  //     }
  //   });
  //   var x = document.getElementById("snackbar");
  //   x.className = "show";
  //   setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  // });
});
</script>

<?php include 'footer.php' ?>
