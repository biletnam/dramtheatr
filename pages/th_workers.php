
<?php
include 'checkUser.php';
?>

<section style="min-height: 635px; background-color: rgba(254, 216, 154, 0.8);">
  <div class="container">
    <div class="row">
      <fieldset style="-webkit-border-radius: 4px;">
        <legend>
          <button id="managers" class="btn btn-default" data-toggle="tab" href="#tabWorkers" department="1" style="margin-left: 8px;">
            Керівники
          </button>
          <button id="actor" class="btn btn-default" data-toggle="tab" href="#tabWorkers" department="2">
            Актори
          </button>
          <button id="ballet" class="btn btn-default" data-toggle="tab" href="#tabWorkers" department="3">
            Балет
          </button>
          <button id="orchestra" class="btn btn-default" data-toggle="tab" href="#tabWorkers" department="4">
            Оркестр
          </button>
          <button id="addWorker" class="btn btn-default" data-toggle="tab" href="#tabAddWorker">
            Новий працівник
          </button>
          <script type="text/javascript">
            $('button[data-toggle="tab"]').click(function() {
              $(".saveWorker, .addWorker").hide();
            });
            $("#addWorker").click(function() {
              $(".saveWorker").hide();
              $(".addWorker").show();
              $("#createTitle").val("");
              $("#editMainImage, #createMainImage").attr("photo-id", 3);
              $("#createMainImage").css("background", "url('img/b6.jpg')center/cover");
              $("#createShortContent").summernote('code', '');
              $("#createFullContent").summernote('code', '');
            });
          </script>
          <input type="button" class="btn btn-default pull-right saveWorker"
                 value="Зберегти" style="margin-right: 8px; display: none;" data-toggle="tab"
                 href="#publishedArticles" articleId="">
          <input type="button" class="btn btn-default pull-right addWorker"
                 value="Додати" style="margin-right: 8px; display: none;" data-toggle="tab"
                 href="#publishedArticles">
        </legend>

        <div class="tab-content" style="-webkit-border-radius: 4px;">

          <!-- Managers list -->
          <div id="tabWorkers" class="tab-pane active">
            <table class="table">
              <tbody id="refreshTable"></tbody>
            </table>
          </div>

          <!-- AddWorker list -->
          <div id="tabAddWorker" class="tab-pane">
            <div class="col-md-6">
              <label for="department">Відділ:</label>
              <select class="department" id="department" style="width: 385px;">
                <option value="1">Керівники</option>
                <option value="2">Актори</option>
                <option value="3">Балет</option>
                <option value="4">Оркестр</option>
              </select>
              <label for="ranking" style="margin-top: 10px;">Порядок відображення:</label>
              <select class="ranking" id="ranking" style="width: 385px;">
                <option value="1">На початку</option>
                <option value="5" selected>В кінці</option>
                <option value="2">після Тамара Кільчицька</option>
                <option value="3">після Тетяна Католік</option>
                <option value="4">після Віктор Журат</option>
              </select>
              <label style="margin-top: 10px;">Прізвище та Імя:</label>
              <input id="createTitle"
                     type="text"
                     class="form-control input-edge"
                     style="margin-bottom: 10px;">
              <label>Посада:</label>
              <textarea id="createDate"
                     type="text"
                     class="form-control"
                     style="margin-bottom: 10px;height:   178px;resize: none;"></textarea>
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
              <label>Заслуги:</label>
              <div id="createFullContent"></div>
              <input type="button"
                     class="btn btn-default pull-right addWorker"
                     value="Додати"
                     style="margin-bottom: 10px;"
                     data-toggle="tab"
                     href="#publishedArticles">
              <script type="text/javascript">
                $(".addWorker").click(function() {
                  var addWorker = $(".addWorker").val();
                  var createPhoto = $("#createMainImage").attr("photo-id");
                  var createTitle = $("#createTitle").val();
                  var createDate = $("#createDate").val();
                  var createShortContent = $("#createShortContent").summernote('code');
                  var createFullContent = $("#createFullContent").summernote('code');
                  $(".addWorker").hide();
                  $.ajax({
                    url: "teatradmin/th_articlesHandler1.php",
                    async: false,
                    method: "POST",
                    data: {
                      addWorker: addWorker,
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
                    url: "teatradmin/th_articlesHandler1.php",
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
        <script type="text/javascript">
        var department = 1;
        var paginationOffset = 0;
        $('button[data-toggle="tab"]').removeClass('active');
        $('button[department="1"]').addClass('active');
        $('#tabWorkers').attr('department', department);
        $('#tabWorkers').attr('pagination-offset', paginationOffset);
        $.ajax({
          url: "teatradmin/th_workersHandler.php",
          async: false,
          method: "POST",
          data: {
            refreshArticleList: true,
            department: department,
            paginationOffset: paginationOffset,
          },
          dataType: "html",
          success: function(data) {
            $("#refreshTable").html(data);
          }
        });
        $('button[data-toggle="tab"]').click(function() {
          $('button[data-toggle="tab"]').removeClass('active');
          $(this).addClass('active');
          var department = $(this).attr('department');
          var paginationOffset = 0;
          $('#tabWorkers').attr('department', department);
          $('#tabWorkers').attr('pagination-offset', paginationOffset);
          $.ajax({
            url: "teatradmin/th_workersHandler.php",
            async: false,
            method: "POST",
            data: {
              refreshArticleList: true,
              department: department,
              paginationOffset: paginationOffset,
            },
            dataType: "html",
            success: function(data) {
              $("#refreshTable").html(data);
            }
          });
        });
        </script>

      </fieldset>
    </div>
  </div>
</section>

<div id="snackbar">Some text some message..</div>
<script type="text/javascript">
  $("#createFullContent, #editFullContent").summernote({
  fontSizes: ["8", "9", "10", "11", "12", "14", "16", "18", "24", "36", "48"],
  toolbar: [
    ["style", ["style"]],
    ["font", ["bold", "italic", "underline", "clear"]],
    ["fontname", ["fontname"]],
    ["fontsize", ["fontsize"]],
    ["color", ["color"]],
    ["para", ["ul", "ol", "paragraph"]],
    // ['insert', ['video', 'link']],
    ["insert", ["picture", "video", "link"]],
    ["table", ["table"]],
    ["fullscreen", ["fullscreen", "codeview"]]
  ],
  height: 300,
  focus: false,
  lang: 'uk-UA'
  });
$(document).ready(function(){
  $(".department").select2({
    minimumResultsForSearch: Infinity
  });
});
</script>

<?php include 'footerAdmin.php' ?>
