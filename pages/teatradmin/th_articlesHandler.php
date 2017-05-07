<?php
// Update article page
// Save article button
// Refresh article list
// Publish article button
// Remove article button
// Insert photo URL
// Refresh image modal
// Get photo id
// Get last photo id
// Save image to file

include 'block/connect.php';
$db1 = Db::getConnection();

// Update article page
if (isset($_POST['getArticleById'])) {
  $getArticleById = $_POST['getArticleById'];
  $result = $db1->query("SELECT
    th_news.title,
    th_news.published,
    th_news.short_content,
    th_news.full_content,
    th_photos.id,
    th_photos.file_name
    FROM th_news
      INNER JOIN th_photos
        ON th_news.photo_id = th_photos.id
    WHERE th_news.id = '$getArticleById'");
  // $result = $db1->query("SELECT * FROM th_news WHERE id=$getArticleById ORDER BY published DESC");
  $result->setFetchMode(PDO::FETCH_ASSOC);
  $article = $result->fetch();
?>

      <div class="col-md-6">
        <label>Тема новини:</label>
        <input id="editTitle"
               type="text"
               class="form-control input-edge"
               style="margin-bottom: 10px;"
               value="<?php echo $article['title']; ?>">
        <label>Дата:</label>
        <input id="editDate"
               type="date"
               class="form-control"
               style="margin-bottom: 10px;"
               value="<?php echo $article['published']; ?>">
        <label>Коротка стаття:</label>
        <div id="editShortContent"><?php echo $article['short_content']; ?></div>
      </div>
      <div class="col-md-6" max-height="100px;">
        <label>Головне зображення:</label>
        <div id="editMainImage"
             class="btn"
             data-toggle='modal'
             data-target='#ImageModal'
             photo-id=<?php echo $article['id']; ?>
             <?php $imagePath = "'" . $article['file_name'] . "'"; ?>
             style="background:url(<?php echo $imagePath; ?>)center/cover;
                    width: 100%;
                    height: 384px;
                    margin-bottom: 10px;
                    -webkit-border-radius: 4px;">
        </div>
        <script type="text/javascript">
          $("#editMainImage").click(function() {
            $.ajax({
              url: "teatradmin/th_articlesHandler.php",
              async: false,
              method: "POST",
              data: {
                refreshImageModal: true,
              },
              dataType: "html",
              success: function(data) {
                $("#ImageModal").html(data);
              }
            });
          });
        </script>
      </div>
      <div class="col-md-12">
        <label>Повна стаття:</label>
        <div id="editFullContent"><?php echo $article['full_content']; ?></div>
        <input type="button" class="btn btn-default pull-right saveArticle"
               value="Зберегти" style="margin-bottom: 10px;" data-toggle="tab"
               href="#publishedArticles" articleId="<?php echo $getArticleById; ?>">
      </div>
    <script type="text/javascript">

      $('#createShortContent, #editShortContent').summernote({
      fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36', '48'],
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']],
        ['color', ['color']],
        // ['para', ['ul', 'ol', 'paragraph']],
        // ['insert', ['video', 'link']],
        ['insert', ['picture', 'video', 'link']],
        ['table', ['table']],
        ['fullscreen', ['fullscreen', 'codeview']]
      ],
      height: 160,
      focus: false,
      lang: 'uk-UA'
      });

      $("#editFullContent").summernote({
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
      height: 600,
      focus: false,
      lang: 'uk-UA'
      });
      $(".saveArticle").click(function() {
        var updateArticleById = $(this).attr("articleId");
        var articlePhoto = $("#editMainImage").attr("photo-id");
        var articleTitle = $("#editTitle").val();
        var articleDate = $("#editDate").val();
        var articleShortContent = $("#editShortContent").summernote('code');
        var articleFullContent = $("#editFullContent").summernote('code');
        $(".saveArticle").hide();
        $.ajax({
          url: "teatradmin/th_articlesHandler.php",
          async: false,
          method: "POST",
          data: {
            updateArticleById: updateArticleById,
            articlePhoto: articlePhoto,
            articleTitle: articleTitle,
            articleDate: articleDate,
            articleShortContent: articleShortContent,
            articleFullContent: articleFullContent,
          },
          dataType: "html",
          success: function(data) {
            $("#snackbar").text(data);
          }
        });
        $.ajax({
          url: "teatradmin/th_articlesHandler.php",
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

<?php
}

// Save article button
if (isset($_POST['updateArticleById'])) {
  $updateArticleById = $_POST['updateArticleById'];
  if ($updateArticleById == '') unset($updateArticleById);
  if (isset($_POST['articleTitle'])) {
    $articleTitle = $_POST['articleTitle'];
    if ($articleTitle == '') unset($articleTitle);
  }
  if (isset($_POST['articlePhoto'])) {
    $articlePhoto = $_POST['articlePhoto'];
    if ($articlePhoto == '') unset($articlePhoto);
  }
  if (isset($_POST['articleDate'])) {
    $articleDate = $_POST['articleDate'];
    if ($articleDate == '') unset($articleDate);
  }
  if (isset($_POST['articleShortContent'])) {
    $articleShortContent = $_POST['articleShortContent'];
    if ($articleShortContent == '') unset($articleShortContent);
  }
  if (isset($_POST['articleFullContent'])) {
    $articleFullContent = $_POST['articleFullContent'];
    if ($articleFullContent == '') unset($articleFullContent);
  }
  $sql = 'UPDATE th_news
          SET title = :title, short_content = :short_content,
              full_content = :full_content, published = :published,
              photo_id = :photo_id
          WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $updateArticleById, PDO::PARAM_STR);
  $result->bindParam(':title', $articleTitle, PDO::PARAM_STR);
  $result->bindParam(':short_content', $articleShortContent, PDO::PARAM_STR);
  $result->bindParam(':full_content', $articleFullContent, PDO::PARAM_STR);
  $result->bindParam(':published', $articleDate, PDO::PARAM_STR);
  $result->bindParam(':photo_id', $articlePhoto, PDO::PARAM_STR);
  $response = $result->execute();
  if ($response) {
    echo "Зміни збережено";
  } else {
    echo "Помилка бази даних";
  }
}

// Refresh article list
if (isset($_POST['refreshArticleList'])) {
  $refreshArticleList = $_POST['refreshArticleList'];
  if (isset($_POST['paginationOffset'])) {
    $paginationOffset = $_POST['paginationOffset'];
  } else {
    $paginationOffset = 0;
  }
  // $result = $db1->query("SELECT * FROM th_news ORDER BY published DESC");
  $result = $db1->query("SELECT
    th_news.id,
    th_news.title,
    th_news.published,
    th_news.short_content,
    th_news.full_content,
    th_photos.file_name
    FROM th_news
      INNER JOIN th_photos
        ON th_news.photo_id = th_photos.id
    ORDER BY published DESC
    LIMIT 4 OFFSET $paginationOffset");
  while ($article = $result->fetch()) {
    if (strlen($article['title']) > 200) {
      $article['title'] = substr($article['title'], 0, 200) . "...";
    }
    if (!$article['file_name']) {
      $imagePath = "'img/b6.jpg'";
    } else {
      $imagePath = "'" . $article['file_name'] . "'";
    }
?>

  <tr>
    <td insertAfterById="<?php echo $article['id']; ?>" width="56" style="vertical-align: middle;"><div
         style="background:url(<?php echo $imagePath; ?>)center/cover;
                width: 40px;
                height: 36px;
                -webkit-border-radius: 4px;">
    </div></td>
    <td refreshById="<?php echo $article['id']; ?>" width="570" style="vertical-align: middle;"><?php echo $article['title']; ?></td>
    <td refreshById="<?php echo $article['id']; ?>" width="90" style="vertical-align: middle;"><?php echo $article['published']; ?></td>
    <td width="57">
      <button class="btn btn-default glyphicon glyphicon-pencil"
              data-toggle='tab'
              href="#editArticle"
              getArticleById="<?php echo $article['id']; ?>">
      </button>
      <script type="text/javascript">
        $(".glyphicon-pencil").click(function() {
          $(".news").removeClass("active");
          var getArticleById = $(this).attr("getArticleById");
          $(".saveArticle").attr("articleId", getArticleById)
          $(".saveArticle").show();
          $.ajax({
            url: "teatradmin/th_articlesHandler.php",
            async: false,
            method: "POST",
            data: {
              getArticleById: getArticleById
            },
            dataType: "html",
            success: function(data) {
              $("#editArticle").html(data);
            }
          });
        })
      </script>
    </td>
    <td width="57" style="vertical-align: middle;">
      <button class="btn btn-danger glyphicon glyphicon-trash"
              data-toggle='modal'
              data-target='#myModal'
              deleteArticleById="<?php echo $article['id']; ?>">
      </button>
      <script type="text/javascript">
        $(".glyphicon-trash").click(function() {
          var deleteArticleById = $(this).attr("deleteArticleById");
          $("#continueDelete").attr("deleteArticleById", deleteArticleById);
          var articleTitle = $(this).parent().prev().prev().prev().text();
          $("#modal-text").text(articleTitle);
        });
      </script>
    </td>
  </tr>

<?php
  }
$result = $db1->query("SELECT count(id) AS count FROM th_news");
$result->setFetchMode(PDO::FETCH_ASSOC);
$row = $result->fetch();
$articlesQuantity = $row['count'];
?>

<tr style="text-align: center; width: 100%;">
  <td colspan="5">
    <?php for ($i = 1; $i < (ceil($articlesQuantity/4)+1); $i++): ?>
      <button class="btn btn-default page" style="width: 40px; height: 34px;" pagination-offset="<?php echo ($i - 1) * 4; ?>"><?php echo $i; ?></button>
    <?php endfor; ?>
  </td>
</tr>
<script type="text/javascript">
  $('.page').click(function() {
    // $('.page').removeClass('active');
    var paginationOffset = $(this).attr('pagination-offset');
    $.ajax({
      url: "teatradmin/th_articlesHandler.php",
      async: false,
      method: "POST",
      data: {
        refreshArticleList: true,
        paginationOffset: paginationOffset,
      },
      dataType: "html",
      success: function(data) {
        $("#refreshTable").html(data);
      }
    });
    $(this).addClass('active');
  });
</script>

<?php
}

// Publish article button
if (isset($_POST['publishArticle'])) {
  $createPhoto = $_POST['createPhoto'];
  $createTitle = $_POST['createTitle'];
  $createDate = $_POST['createDate'];
  $createShortContent = $_POST['createShortContent'];
  $createFullContent = $_POST['createFullContent'];
  $sql = 'INSERT INTO th_news
          (title, published, short_content, full_content, photo_id)
          VALUES (:title, :published, :short_content, :full_content, :photo_id)';
  $result = $db1->prepare($sql);
  $result->bindParam(':title', $createTitle, PDO::PARAM_STR);
  $result->bindParam(':published', $createDate, PDO::PARAM_STR);
  $result->bindParam(':short_content', $createShortContent, PDO::PARAM_STR);
  $result->bindParam(':full_content', $createFullContent, PDO::PARAM_STR);
  $result->bindParam(':photo_id', $createPhoto, PDO::PARAM_STR);
  $response = $result->execute();
  if ($response) {
    echo "Стаття опублікована";
  } else {
    echo "Помилка бази даних";
  }
}

// Remove article button
if (isset($_POST['deleteArticleById'])) {
  $deleteArticleById = $_POST['deleteArticleById'];
  $sql = 'DELETE FROM th_news WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $deleteArticleById, PDO::PARAM_STR);
  $response = $result->execute();
  if ($response) {
    echo "Стаття видалена";
  } else {
    echo "Помилка бази даних";
  }
}

// Insert photo URL
if (isset($_POST['imageURL'])) {
  $imageURL = $_POST['imageURL'];
  $sql = 'INSERT INTO th_photos (file_name) VALUES (:file_name)';
  $result = $db1->prepare($sql);
  $result->bindParam(':file_name', $imageURL, PDO::PARAM_STR);
  $response = $result->execute();
  if ($response) {
    echo "URL збережено";
  } else {
    echo "Помилка бази даних";
  }
}

// Refresh image modal
if (isset($_POST['refreshImageModal'])) {
  $refreshImageModal = $_POST['refreshImageModal'];
  $result = $db1->query("SELECT * FROM th_photos");
  $allPhotos = array();
  $i = 0;
  while ($row = $result->fetch()) {
    $allPhotos[$i]['id'] = $row['id'];
    $allPhotos[$i]['file_name'] = $row['file_name'];
    $i++;
  }
  $result = $db1->query("SELECT
    th_photos.id,
    th_photos.file_name,
    th_news.id AS article_id
    FROM th_photos
      INNER JOIN th_news
        ON th_news.photo_id = th_photos.id");
  $photos = array();
  $i = 0;
  while ($row = $result->fetch()) {
    $photos[$i]['id'] = $row['id'];
    $photos[$i]['file_name'] = $row['file_name'];
    $photos[$i]['article_id'] = $row['article_id'];
    $i++;
  }
  ?>

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

          <!-- Nav tabs -->
          <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px;">
            <li role="presentation" class="active"><a href="#all_photos"
              aria-controls="all_photos"
              role="tab"
              data-toggle="tab"
              style="color: #337ab7;">Всі фото</a></li>
            <li role="presentation"><a href="#workers"
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
            <li role="presentation"><a href="#load"
              aria-controls="load"
              role="tab"
              data-toggle="tab"
              style="color: #337ab7;">Завантажити</a></li>
            <li role="presentation"><a href="#url"
              aria-controls="url"
              role="tab"
              data-toggle="tab"
              style="color: #337ab7;">URL</a></li>
          </ul>
          <script type="text/javascript">
            $("a[role='tab']").click(function() {
              $("#imageConfirm").attr("selected-tab", "");
            });
            $("a[href='#load']").click(function() {
              $("#imageConfirm").attr("selected-tab", "load");
            });
            $("a[href='#url']").click(function() {
              $("#imageConfirm").attr("selected-tab", "url");
            });
          </script>

          <!-- Tab panes -->
          <?php //$photos = getAllPhotos(); ?>
          <div class="tab-content">
            <div role="tabpanel" class="tab-pane active" id="all_photos">
                 <?php foreach ($allPhotos as $photo): ?>
                   <div class="btn image-grid-item"
                        data-id="<?php echo $photo['id']; ?>"
                        data-filename="<?php echo $photo['file_name']; ?>"
                        style="background:url('<?php echo $photo['file_name']; ?>')center/cover;
                               width:8%;
                               padding-top:8%;
                               margin: 2px;
                               -webkit-border-radius: 4px;
                               border-style: solid;
                               border-width: 5px;">
                   </div>
                 <?php endforeach; ?>
            </div>
            <div role="tabpanel" class="tab-pane" id="workers">
                 <!-- <?php //foreach ($photos as $photo): ?>
                 <?php //if (intval($photo['worker_id']) > 0): ?>
                   <div class="btn image-grid-item"
                        data-id="<?php //echo $photo['id']; ?>"
                        data-filename="<?php //echo $photo['file_name']; ?>"
                        style="background:url('<?php //echo $photo['file_name']; ?>')center/cover;
                               width:8%;
                               padding-top:8%;
                               margin: 2px;
                               -webkit-border-radius: 4px;
                               border-style: solid;
                               border-width: 5px;">
                   </div>
                 <?php //endif; ?>
                 <?php //endforeach; ?> -->
            </div>
            <div role="tabpanel" class="tab-pane" id="spectacles">
                 <!-- <?php //foreach ($photos as $photo): ?>
                 <?php //if (intval($photo['spectacle_id']) > 0): ?>
                   <div class="btn image-grid-item"
                        data-id="<?php //echo $photo['id']; ?>"
                        data-filename="<?php //echo $photo['file_name']; ?>"
                        style="background:url('<?php //echo $photo['file_name']; ?>')center/cover;
                               width:8%;
                               padding-top:8%;
                               margin: 2px;
                               -webkit-border-radius: 4px;
                               border-style: solid;
                               border-width: 5px;">
                   </div>
                 <?php //endif; ?>
                 <?php //endforeach; ?> -->
            </div>
            <div role="tabpanel" class="tab-pane" id="news">
                 <?php foreach ($photos as $photo): ?>
                 <?php if (intval($photo['article_id']) > 0): ?>
                   <div class="btn image-grid-item"
                        data-id="<?php echo $photo['id']; ?>"
                        data-filename="<?php echo $photo['file_name']; ?>"
                        style="background:url('<?php echo $photo['file_name']; ?>')center/cover;
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
            <script type="text/javascript">
              $("div[data-id='1']").addClass("selected-image");
              $(".image-grid-item").click(function() {
              $(".image-grid-item").removeClass("selected-image");
              $(this).addClass("selected-image");
              });
            </script>
            <div role="tabpanel" class="tab-pane" id="load">
              <div class="form-group">
                <label>Вибрати з файлів</label>
                <!-- <form id="imageLoadForm" enctype=multipart/form-data> -->
                <script type="text/javascript">
                  function submitForm() {
                    // console.log("submit event");
                    var fd = new FormData(document.getElementById("fileinfo"));
                    fd.append("label", "WEBUPLOAD");
                    $.ajax({
                      url: "teatradmin/th_articlesHandler.php",
                      async: false,
                      type: "POST",
                      data: fd,
                      processData: false,  // tell jQuery not to process the data
                      contentType: false   // tell jQuery not to set contentType
                    }).done(function( data ) {
                      // console.log("PHP Output:");
                      // console.log( data );
                      $("#editMainImage, #createMainImage").css("background", "url('" + data + "')center/cover");
                    });
                    $.ajax({
                      url: "teatradmin/th_articlesHandler.php",
                      async: false,
                      method: "POST",
                      data: {
                        lastImage: true,
                      },
                      dataType: "html",
                      success: function(data) {
                        $("#editMainImage, #createMainImage").attr("photo-id", data);
                      }
                    });
                    return false;
                  }
                </script>
                <form method="post" id="fileinfo" name="fileinfo" onsubmit="return submitForm();">
                  <!-- <input class="form-control" type="file"> -->
                  <input class="form-control" type="file" name="file" required>
                </form>
              </div>
            </div>
            <div role="tabpanel" class="tab-pane" id="url">
              <div class="form-group">
                <label>URL зображення</label>
                <input id="imageURL" class="form-control col-md-12" type="text">
              </div>
            </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button"
                class="btn btn-default"
                data-dismiss="modal">Відмінити</button>
        <button id="imageConfirm"
                type="button"
                class="btn btn-primary"
                selected-tab=""
                data-dismiss="modal">Вибрати</button>
                <script type="text/javascript">
                  $("#imageConfirm").click(function() {
                    if ($("#all_photos, #workers, #spectacles, #news")) {
                      $("#editMainImage, #createMainImage").css("background", "url('" + $(".selected-image").attr("data-filename") + "')center/cover");
                      var photoId = $(".selected-image").attr("data-id")
                      $("#editMainImage, #createMainImage").attr("photo-id", photoId);
                    }
                    if ($("#imageConfirm").attr("selected-tab") == "load") {
                      $("#fileinfo").submit();
                    }
                    if ($("#imageConfirm").attr("selected-tab") == "url") {
                      var imageURL = $("#imageURL").val();
                      $("#editMainImage, #createMainImage").css("background", "url('" + imageURL + "')center/cover");
                      $.ajax({
                        url: "teatradmin/th_articlesHandler.php",
                        async: false,
                        method: "POST",
                        data: {
                          imageURL: imageURL,
                        },
                        dataType: "html",
                        success: function(data) {
                          $("#snackbar").text(data);
                        }
                      });
                      $.ajax({
                        url: "teatradmin/th_articlesHandler.php",
                        async: false,
                        method: "POST",
                        data: {
                          fileName: imageURL,
                        },
                        dataType: "html",
                        success: function(data) {
                          $("#editMainImage, #createMainImage").attr("photo-id", data);
                        }
                      });
                    }
                  });
                </script>
      </div>
    </div>
  </div>

<?php
}

// Get photo id
if (isset($_POST['fileName'])) {
  $fileName = $_POST['fileName'];
  $result = $db1->query("SELECT * FROM th_photos WHERE file_name = '$fileName'");
  $result->setFetchMode(PDO::FETCH_ASSOC);
  $photo = $result->fetch();
  echo $photo['id'];
}

// Get last photo id
if (isset($_POST['lastImage'])) {
  $result = $db1->query("SELECT MAX(id) AS photo_id FROM th_photos");
  $result->setFetchMode(PDO::FETCH_ASSOC);
  $photo = $result->fetch();
  echo $photo['photo_id'];
}

// Save image to file
if (isset($_POST['label'])) {
  $label = $_POST['label'];
  if ($_POST["label"]) {
    $label = $_POST["label"];
  }
  $allowedExts = array("gif", "jpeg", "jpg", "png");
  $temp = explode(".", $_FILES["file"]["name"]);
  $extension = end($temp);
  if ((($_FILES["file"]["type"] == "image/gif")
  || ($_FILES["file"]["type"] == "image/jpeg")
  || ($_FILES["file"]["type"] == "image/jpg")
  || ($_FILES["file"]["type"] == "image/pjpeg")
  || ($_FILES["file"]["type"] == "image/x-png")
  || ($_FILES["file"]["type"] == "image/png"))
  && ($_FILES["file"]["size"] < 200000)
  && in_array($extension, $allowedExts)) {
    if ($_FILES["file"]["error"] > 0) {
      // echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
    } else {
      $filename = $label.$_FILES["file"]["name"];
      // echo "Upload: " . $_FILES["file"]["name"] . "<br>";
      // echo "Type: " . $_FILES["file"]["type"] . "<br>";
      // echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
      // echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br>";

      if (file_exists("../img/" . $filename)) {
        // echo $filename . " вже існує. ";
        // echo "img/b6.jpg";
      } else {
        move_uploaded_file($_FILES["file"]["tmp_name"], "../img/" . $filename);
        $filename = "img/" . $filename;
        $sql = 'INSERT INTO th_photos (file_name) VALUES (:file_name)';
        $result = $db1->prepare($sql);
        $result->bindParam(':file_name', $filename, PDO::PARAM_STR);
        $response = $result->execute();
        echo $filename;
        if ($response) {
          // echo "Зображення збережено";
        } else {
          // echo "Помилка бази даних";
        }
        // echo "Stored in: " . "../img/" . $filename;
      }
    }
  } else {
    // echo "Невірний файл";
  }
}
?>
