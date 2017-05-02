<!-- Article list -->
<!-- Create article -->
<!-- Remove article -->
<!-- Select an image -->
<!-- JavaScript -->

<?php
include 'checkUser.php';
?>

<section style="min-height: 635px; background-color: rgba(254, 216, 154, 0.8);">
  <div class="container">
    <div class="row">
      <fieldset style="-webkit-border-radius: 4px;">
        <legend>
          <button id="published" class="btn btn-default" data-toggle="tab" href="#publishedArticles" style="margin-left: 8px;">
            Опубліковані
          </button>
          <script type="text/javascript">
            $("#published").click(function() {
              $.ajax({
                url: "teatradmin/ajaxHandler.php",
                async: false,
                method: "POST",
                data: {
                  refreshArticleList: true,
                },
                dataType: "html",
                success: function(data) {
                  $("#refreshTable").html(data);
                }
              });
            });
          </script>
          <button id="create" class="btn btn-default" data-toggle="tab" href="#createArticle">
            Створити
          </button>
          <script type="text/javascript">
            $("#published").click(function() {
              $(".saveArticle, .publishArticle").hide();
            });
            $("#create").click(function() {
              $(".saveArticle").hide();
              $(".publishArticle").show();
              $("#createTitle").val("");
              $("#editMainImage, #createMainImage").attr("photo-id", 3);
              $("#createMainImage").css("background", "url('img/b6.jpg')center/cover");
              $("#createShortContent").summernote('code', '');
              $("#createFullContent").summernote('code', '');
            });
          </script>
          <input type="button" class="btn btn-default pull-right saveArticle"
                 value="Зберегти" style="margin-right: 8px; display: none;" data-toggle="tab"
                 href="#publishedArticles" articleId="">
          <input type="button" class="btn btn-default pull-right publishArticle"
                 value="Публікувати" style="margin-right: 8px; display: none;" data-toggle="tab"
                 href="#publishedArticles">
        </legend>
        <div class="tab-content" style="-webkit-border-radius: 4px;">

          <!-- Article list -->
          <div id="publishedArticles" class="tab-pane fade in active">
            <table class="table">
              <tbody id="refreshTable"></tbody>
              <script type="text/javascript">
                $.ajax({
                  url: "teatradmin/ajaxHandler.php",
                  async: false,
                  method: "POST",
                  data: {
                    refreshArticleList: true,
                  },
                  dataType: "html",
                  success: function(data) {
                    $("#refreshTable").html(data);
                  }
                });
              </script>
            </table>
          </div>

          <!-- Create article -->
          <div id="createArticle" class="tab-pane fade">
            <div class="col-md-6">
              <label>Тема новини:</label>
              <input id="createTitle"
                     type="text"
                     class="form-control input-edge"
                     style="margin-bottom: 10px;">
              <label>Дата:</label>
              <input id="createDate"
                     type="date"
                     class="form-control"
                     style="margin-bottom: 10px;">
              <label>Коротка стаття:</label>
              <div id="createShortContent"></div>
            </div>
            <div class="col-md-6" max-height="100px;">
              <label>Головне зображення:</label>
              <div id="createMainImage"
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
              <div id="createFullContent"></div>
              <input type="button"
                     class="btn btn-default pull-right publishArticle"
                     value="Публікувати"
                     style="margin-bottom: 10px;"
                     data-toggle="tab"
                     href="#publishedArticles">
              <script type="text/javascript">
                $(".publishArticle").click(function() {
                  var publishArticle = $(".publishArticle").val();
                  var createPhoto = $("#createMainImage").attr("photo-id");
                  var createTitle = $("#createTitle").val();
                  var createDate = $("#createDate").val();
                  var createShortContent = $("#createShortContent").summernote('code');
                  var createFullContent = $("#createFullContent").summernote('code');
                  $(".publishArticle").hide();
                  $.ajax({
                    url: "teatradmin/ajaxHandler.php",
                    async: false,
                    method: "POST",
                    data: {
                      publishArticle: publishArticle,
                      createPhoto: createPhoto,
                      createTitle: createTitle,
                      createDate: createDate,
                      createShortContent: createShortContent,
                      createFullContent: createFullContent,
                    },
                    dataType: "html",
                    success: function(data) {
                      $("#snackbar").text(data);
                    }
                  });
                  $.ajax({
                    url: "teatradmin/ajaxHandler.php",
                    async: false,
                    method: "POST",
                    data: {
                      refreshArticleList: true,
                    },
                    dataType: "html",
                    success: function(data) {
                      $("#refreshTable").html(data);
                    }
                  });
                  var x = document.getElementById("snackbar");
                  x.className = "show";
                  setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                });
              </script>
            </div>
          </div>

          <div id="editArticle" class="tab-pane fade"></div>

        </div>
      </fieldset>

      <!-- Remove article -->
      <div id="myModal" class="modal fade" tabindex="-1"
           role="dialog" aria-labelledby="myModalLabel">
        <div class="modal-dialog" role="document">
          <div class="modal-content" style="color: black;">
            <div class="modal-header">
              <button type="button" class="close"
                      data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
              <h4 id="myModalLabel"
                  class="modal-title">Видалити новину</h4>
            </div>
            <div class="modal-body">
              <div id="modal-text" style="margin-bottom: 10px;"></div>
              Зміни неможливо відмінити. Бажаєте продовжити?
            </div>
            <div class="modal-footer">
              <button type="button"
                      class="btn btn-default"
                      data-dismiss="modal">Ні</button>
              <button id="continueDelete"
                      type="button"
                      class="btn btn-danger"
                      data-dismiss="modal"
                      deleteArticleById="">Так</button>
                      <script type="text/javascript">
                      $("#continueDelete").click(function() {
                        var deleteArticleById = $(this).attr("deleteArticleById");
                        $.ajax({
                          url: "teatradmin/ajaxHandler.php",
                          async: false,
                          method: "POST",
                          data: {
                            deleteArticleById: deleteArticleById,
                          },
                          dataType: "html",
                          success: function(data) {
                            $("#snackbar").text(data);
                          }
                        });
                        $.ajax({
                          url: "teatradmin/ajaxHandler.php",
                          async: false,
                          method: "POST",
                          data: {
                            refreshArticleList: true,
                          },
                          dataType: "html",
                          success: function(data) {
                            $("#refreshTable").html(data);
                          }
                        });
                        var x = document.getElementById("snackbar");
                        x.className = "show";
                        setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
                      });
                      </script>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Select an image -->
<div id="ImageModal"
     class="modal fade"
     tabindex="-1"
     role="dialog"
     aria-labelledby="ImageModalLabel">
</div>
<div id="snackbar">Some text some message..</div>

<!-- JavaScript -->
<script>
// $('#myTabs a').click(function (e) {
//   e.preventDefault()
//   $(this).tab('show')
// })

  $('#createShortContent, #editShortContent').summernote({
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
  focus: false,
  lang: 'uk-UA'
  });

  $("#createFullContent, #editFullContent").summernote({
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
  focus: false,
  lang: 'uk-UA'
  });

$(document).ready(function(){

  // Set current date to input
  Date.prototype.toDateInputValue = (function() {
    var local = new Date(this);
    local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
    return local.toJSON().slice(0,10);
  });
  $('#createDate, #editDate').val(new Date().toDateInputValue());

  // добавлення новини
  // $("#add_news").click(function() {
  //   var znachtema = $("#tema").val();
  //   var shortContent = $("#short_content").summernote('code');
  //   var znachtxt = $("#full_content").summernote('code');
  //   // var znachphoto = $("#photo").val();
  //   var znachdate = $("#date").val();
  //   var photoId = $(".selected-image").attr("data-id");
  //   $.ajax({
  //     url: "teatradmin/add_news.php",
  //     method: "POST",
  //     data: {
  //       zminnatema: znachtema,
  //       shortcontent: shortContent,
  //       zminnatxt: znachtxt,
  //       // zminnaphoto:znachphoto,
  //       zminnadate: znachdate,
  //       photo_id: photoId
  //     },
  //     dataType: "html",
  //     success: function(data) {
  //       // alert(data);
  //       window.location = '/pages/protected_2.php';
  //     }
  //   });
  // });

  // видалення новини
  // $("#continue-delete").click(function() {
  //   var znachid = $("#modal-text").attr("data-id");
  //   $.ajax({
  //     url:"teatradmin/del_news.php",
  //     method:"POST",
  //     data:{zminnaid:znachid},
  //     dataType:"html",
  //     success:function(data) {
  //       window.location = '/pages/protected_2.php';
  //     }
  //   });
  // });
  // $(".dropdown-ref").click(function() {
  //   var id = $(this).attr("value");
  //   var text = $(this).html();
  //   $("#modal-text").html('"' + text + '"<br><br>');
  //   $("#modal-text").attr("data-id", id);
  // });

  // редагування новини
  // $(".dropdown-edit").click(function() {
  //   var znachid = $(this).attr("data-id");
  //   $("#red").show();
  //   $.ajax({
  //     url : "teatradmin/load_news.php",
  //     method : "POST",
  //     data : {zminnaid : znachid},
  //     dataType : "html",
  //     success : function(data) {
  //       $("#redaktirov").html(data);
  //     }
  //   });
  // });
  // $("#red").click(function() {
  //   var zid = $("#idn").val();
  //   var ztema = $("#temas").val();
  //   var editShortContent = $("#edit_short_content").summernote('code');
  //   var ztxt = $("#edit_full_content").summernote('code');
  //   // var zphoto = $("#photos").val();
  //   var zdate = $("#posadas").val();
  //   $.ajax({
  //     url:"teatradmin/red_news.php",
  //     method:"POST",
  //     data:{
  //       zmid:zid,
  //       zmtema:ztema,
  //       edit_short_content:editShortContent,
  //       zmtxt:ztxt,
  //       // zmphoto:zphoto,
  //       zmdate:zdate
  //     },
  //     dataType:"html",
  //     success:function(data) {
  //       // alert (data);
  //       window.location = '/pages/protected_2.php';
  //     }
  //   });
  // });

});
</script>
<?php include 'footerAdmin.php' ?>
