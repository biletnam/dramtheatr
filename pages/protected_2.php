<?php
include 'checkUser.php';

$result = $db1->query("SELECT * from dt_news");
$news = array();
$i = 0;
while ($row = $result->fetch()) {
  $news[$i]['id'] = $row['id'];
  $news[$i]['tema'] = substr($row['tema'], 0, 200);
  $i++;
}

$result = $db1->query("SELECT * FROM dt_photo");
$photos = array();
$i = 0;
while ($row = $result->fetch()) {
  $photos[$i]['id'] = $row['id'];
  $photos[$i]['photo'] = $row['photo'];
  $photos[$i]['id_act'] = $row['id_act'];
  $photos[$i]['id_vist'] = $row['id_vist'];
  $photos[$i]['id_new'] = $row['id_new'];
  $i++;
}

?>

<section class="theatre parallax-window-news"
         data-parallax="scroll"
         data-image-src="/img/news/news-bg.jpg">

  <div class="container">
    <div class="row">

      <!-- Add news -->
      <fieldset style="-webkit-border-radius: 4px;">
        <legend><h2>Додати:</h2></legend>
        <form id="form1" >
          <div class="col-md-6">
            <label>Тема новини:</label>
            <input id="tema"
                   type="text"
                   class="form-control input-edge"
                   style="margin-bottom: 10px;">
            <label>Дата:</label>
            <input id="date"
                   type="date"
                   class="form-control"
                   style="margin-bottom: 10px;">
            <label>Коротка стаття:</label>
            <div id="short_content"></div>
          </div>
          <div class="col-md-6" max-height="100px;">
            <label>Головне зображення:</label>
            <div id="main-image"
                 class="btn"
                 data-toggle='modal'
                 data-target='#ImageModal'
                 style="background:url('img/b6.jpg')center/cover;
                        width: 100%;
                        height: 384px;
                        margin-bottom: 10px;
                        -webkit-border-radius: 4px;">
            </div>
          </div>
          <div class="col-md-12">
            <label>Повна стаття:</label>
            <div id="full_content"></div>
            <input id="add_news"
                   type="button"
                   class="btn btn-default"
                   value="Публікувати"
                   style="margin-bottom: 10px;">
          </div>
        </form>
      </fieldset>

      <!-- Edit news -->
      <fieldset style="-webkit-border-radius: 4px;">
        <legend><h2>Змінити:</h2></legend>
         <div class="dropdown">
           <button id="dropdownMenu2"
                   class="btn btn-default dropdown-toggle"
                   type="button"
                   data-toggle="dropdown"
                   aria-haspopup="true"
                   aria-expanded="true"
                   style="margin-bottom: 10px; margin-left: 15px;">
               Вибрати статтю
             <span class="caret"></span>
           </button>
           <ul class="dropdown-menu"
               aria-labelledby="dropdownMenu2">
             <?php foreach ($news as $new): ?>
               <li>
                 <a class='dropdown-edit'
                      data-id='<?php echo $new['id']; ?>'
                      style='cursor: pointer;'>
                   <?php echo $new['tema']; ?>
                 </a>
               </li>
             <?php endforeach; ?>
           </ul>
         </div>
         <div id="redaktirov"></div>
         <div class="col-md-12">
           <input id="red"
                  type="button"
                  class="btn btn-default"
                  value="Зберегти"
                  style="display: none; margin-bottom: 10px;">
         </div>
      </fieldset>

      <!-- Delete news -->
      <fieldset style="-webkit-border-radius: 4px;">
        <legend><h2>Видалити:</h2></legend>
        <div class="dropdown col-md-12">
          <button id="dropdownMenu1"
                  class="btn btn-default dropdown-toggle"
                  type="button"
                  data-toggle="dropdown"
                  aria-haspopup="true"
                  aria-expanded="true"
                  style="margin-bottom: 10px;">
              Вибрати статтю
            <span class="caret"></span>
          </button>
          <ul class="dropdown-menu"
              aria-labelledby="dropdownMenu1">
            <?php foreach ($news as $new): ?>
              <li>
                <a class='dropdown-ref'
                     data-toggle='modal'
                     data-target='#myModal'
                     style='cursor: pointer;'
                     value='<?php echo $new['id']; ?>'>
                  <?php echo $new['tema']; ?>
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </fieldset>

    </div><!-- end row -->
  </div><!-- end container -->
</section><!-- end theatre -->

<!-- Delete confirm modal -->
<div id="myModal"
     class="modal fade"
     tabindex="-1"
     role="dialog"
     aria-labelledby="myModalLabel">
  <div class="modal-dialog"
       role="document">
    <div class="modal-content"
         style="color: black;">
      <div class="modal-header">
        <button type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 id="myModalLabel"
            class="modal-title">Видалити новину</h4>
      </div>
      <div class="modal-body">
        <div id="modal-text"></div>
        Зміни неможливо відмінити. Бажаєте продовжити?
      </div>
      <div class="modal-footer">
        <button type="button"
                class="btn btn-default"
                data-dismiss="modal">Ні</button>
        <button id="continue-delete"
                type="button"
                class="btn btn-danger">Так</button>
      </div>
    </div>
  </div>
</div>

<!-- Image load modal -->
<div id="ImageModal"
     class="modal fade"
     tabindex="-1"
     role="dialog"
     aria-labelledby="ImageModalLabel">
  <div class="modal-dialog modal-lg"
       role="document">
    <div class="modal-content"
         style="color: black;">
      <div class="modal-header">
        <button type="button"
                class="close"
                data-dismiss="modal"
                aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <h4 id="ImageModalLabel"
            class="modal-title">Виберіть головне зображення</h4>
      </div>
      <div class="modal-body">
        <!-- <div> -->

          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px;">
            <li role="presentation"
                class="active"><a href="#workers"
                                  aria-controls="workers"
                                  role="tab"
                                  data-toggle="tab"
                                  style="color: #337ab7;">Працівники</a></li>
            <li role="presentation"><a href="#spectacles"
                                       aria-controls="spectacles"
                                       role="tab"
                                       data-toggle="tab"
                                       style="color: #337ab7;">Вистави</a></li>
            <li role="presentation"><a href="#news"
                                       aria-controls="news"
                                       role="tab"
                                       data-toggle="tab"
                                       style="color: #337ab7;">Новини</a></li>
          </ul>

          <!-- Tab panes -->
          <?php //$photos = getAllPhotos(); ?>
          <div class="tab-content">
            <div role="tabpanel"
                 class="tab-pane active"
                 id="workers">
                 <?php foreach ($photos as $photo): ?>
                 <?php if (intval($photo['id_act']) > 0): ?>
                   <div class="btn image-grid-item"
                        data-id="<?php echo $photo['id']; ?>"
                        data-filename="<?php echo $photo['photo']; ?>"
                        style="background:url('img/<?php echo $photo['photo']; ?>')center/cover;
                               width:8%;
                               padding-top:8%;
                               margin: 2px;
                               -webkit-border-radius: 4px;
                               border-style: solid;
                               border-width: 5px;">
                   </div>
                 <?php endif; ?>
                 <?php endforeach; ?>
            </div>
            <div role="tabpanel"
                 class="tab-pane"
                 id="spectacles">
                 <?php foreach ($photos as $photo): ?>
                 <?php if (intval($photo['id_vist']) > 0): ?>
                   <div class="btn image-grid-item"
                        data-id="<?php echo $photo['id']; ?>"
                        data-filename="<?php echo $photo['photo']; ?>"
                        style="background:url('img/<?php echo $photo['photo']; ?>')center/cover;
                               width:8%;
                               padding-top:8%;
                               margin: 2px;
                               -webkit-border-radius: 4px;
                               border-style: solid;
                               border-width: 5px;">
                   </div>
                 <?php endif; ?>
                 <?php endforeach; ?>
            </div>
            <div role="tabpanel"
                 class="tab-pane"
                 id="news">
                 <?php foreach ($photos as $photo): ?>
                 <?php if (intval($photo['id_new']) > 0): ?>
                   <div class="btn image-grid-item"
                        data-id="<?php echo $photo['id']; ?>"
                        data-filename="<?php echo $photo['photo']; ?>"
                        style="background:url('img/<?php echo $photo['photo']; ?>')center/cover;
                               width:8%;
                               padding-top:8%;
                               margin: 2px;
                               -webkit-border-radius: 4px;
                               border-style: solid;
                               border-width: 5px;">
                   </div>
                 <?php endif; ?>
                 <?php endforeach; ?>
            </div>
          <!-- </div> -->

        </div>

      </div>
      <div class="modal-footer">
        <button type="button"
                class="btn btn-default"
                data-dismiss="modal">Відмінити</button>
        <button id="image-confirm"
                type="button"
                class="btn btn-primary"
                data-dismiss="modal">Зберегти</button>
      </div>
    </div>
  </div>
</div>

<script>

$('#myTabs a').click(function (e) {
  e.preventDefault()
  $(this).tab('show')
})

  $('#short_content').summernote({
  fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36', '48'],
  toolbar: [
    ['style', ['style']],
    ['font', ['bold', 'italic', 'underline', 'clear']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['insert', ['video', 'link']],
    // ['insert', ['picture', 'video', 'link']],
    ['table', ['table']],
    ['fullscreen', ['fullscreen', 'codeview']]
  ],
  height: 160,
  focus: false
  });

  $("#full_content").summernote({
  fontSizes: ["8", "9", "10", "11", "12", "14", "16", "18", "24", "36", "48"],
  toolbar: [
    ["style", ["style"]],
    ["font", ["bold", "italic", "underline", "clear"]],
    ["fontname", ["fontname"]],
    ["fontsize", ["fontsize"]],
    ["color", ["color"]],
    ["para", ["ul", "ol", "paragraph"]],
    ['insert', ['video', 'link']],
    // ["insert", ["picture", "video", "link"]],
    ["table", ["table"]],
    ["fullscreen", ["fullscreen", "codeview"]]
  ],
  height: 300,
  focus: false
  });

$(document).ready(function(){

  // Set current date to input
  Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
  });
  $('#date').val(new Date().toDateInputValue());

  // добавлення новини
  $("#add_news").click(function() {
    var znachtema = $("#tema").val();
    var shortContent = $("#short_content").summernote('code');
    var znachtxt = $("#full_content").summernote('code');
    // var znachphoto = $("#photo").val();
    var znachdate = $("#date").val();
    var photoId = $(".selected-image").attr("data-id");
    $.ajax({
      url: "teatradmin/add_news.php",
      method: "POST",
      data: {
        zminnatema: znachtema,
        shortcontent: shortContent,
        zminnatxt: znachtxt,
        // zminnaphoto:znachphoto,
        zminnadate: znachdate,
        photo_id: photoId
      },
      dataType: "html",
      success: function(data) {
        // alert(data);
        window.location = '/pages/protected_2.php';
      }
    });
  });
  $(".image-grid-item").click(function() {
    $(".image-grid-item").removeClass("selected-image");
    $(this).addClass("selected-image");
  });
  $("#image-confirm").click(function() {
    $("#main-image").css("background", "url('img/" +
    $(".selected-image").attr("data-filename") + "')center/cover");

  });

  // видалення новини
  $("#continue-delete").click(function() {
    var znachid = $("#modal-text").attr("data-id");
    $.ajax({
      url:"teatradmin/del_news.php",
      method:"POST",
      data:{zminnaid:znachid},
      dataType:"html",
      success:function(data) {
        window.location = '/pages/protected_2.php';
      }
    });
  });
  $(".dropdown-ref").click(function() {
    var id = $(this).attr("value");
    var text = $(this).html();
    $("#modal-text").html('"' + text + '"<br><br>');
    $("#modal-text").attr("data-id", id);
  });

  // редагування новини
  $(".dropdown-edit").click(function() {
    var znachid = $(this).attr("data-id");
    $("#red").show();
    $.ajax({
      url : "teatradmin/load_news.php",
      method : "POST",
      data : {zminnaid : znachid},
      dataType : "html",
      success : function(data) {
        $("#redaktirov").html(data);
      }
    });
  });
  $("#red").click(function() {
    var zid = $("#idn").val();
    var ztema = $("#temas").val();
    var editShortContent = $("#edit_short_content").summernote('code');
    var ztxt = $("#edit_full_content").summernote('code');
    // var zphoto = $("#photos").val();
    var zdate = $("#posadas").val();
    $.ajax({
      url:"teatradmin/red_news.php",
      method:"POST",
      data:{
        zmid:zid,
        zmtema:ztema,
        edit_short_content:editShortContent,
        zmtxt:ztxt,
        // zmphoto:zphoto,
        zmdate:zdate
      },
      dataType:"html",
      success:function(data) {
        // alert (data);
        window.location = '/pages/protected_2.php';
      }
    });
  });

});
</script>
<?php include 'footerAdmin.php' ?>
