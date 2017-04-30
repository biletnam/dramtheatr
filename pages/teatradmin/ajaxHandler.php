<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['getArticleById'])) {
  $getArticleById = $_POST['getArticleById'];
  $result = $db1->query("SELECT * FROM th_news WHERE id=$getArticleById ORDER BY published DESC");
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
             style="background:url('img/b6.jpg')center/cover;
                    width: 100%;
                    height: 384px;
                    margin-bottom: 10px;
                    -webkit-border-radius: 4px;">
        </div>
      </div>
      <div class="col-md-12">
        <label>Повна стаття:</label>
        <div id="editFullContent"><?php echo $article['full_content']; ?></div>
        <input type="button" class="btn btn-default pull-right saveArticle"
               value="Зберегти" style="margin-bottom: 10px;" data-toggle="tab"
               href="#publishedArticles" articleId="<?php echo $getArticleById; ?>">
      </div>
    <script type="text/javascript">
      $('#editShortContent').summernote({
      fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36', '48'],
      toolbar: [
        ['style', ['style']],
        ['font', ['bold', 'italic', 'underline', 'clear']],
        ['fontname', ['fontname']],
        ['fontsize', ['fontsize']]
      ],
      height: 195,
      focus: false
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
      focus: false
      });
      $(".saveArticle").click(function() {
        var updateArticleById = $(this).attr("articleId");
        var articleTitle = $("#editTitle").val();
        var articleDate = $("#editDate").val();
        var articleShortContent = $("#editShortContent").summernote('code');
        var articleFullContent = $("#editFullContent").summernote('code');
        $(".saveArticle").hide();
        $.ajax({
          url: "teatradmin/ajaxHandler.php",
          method: "POST",
          data: {
            updateArticleById: updateArticleById,
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
          url: "teatradmin/ajaxHandler.php",
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

if (isset($_POST['updateArticleById'])) {
  $updateArticleById = $_POST['updateArticleById'];
  if ($updateArticleById == '') unset($updateArticleById);
  if (isset($_POST['articleTitle'])) {
    $articleTitle = $_POST['articleTitle'];
    if ($articleTitle == '') unset($articleTitle);
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
              full_content = :full_content, published = :published
          WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $updateArticleById, PDO::PARAM_STR);
  $result->bindParam(':title', $articleTitle, PDO::PARAM_STR);
  $result->bindParam(':short_content', $articleShortContent, PDO::PARAM_STR);
  $result->bindParam(':full_content', $articleFullContent, PDO::PARAM_STR);
  $result->bindParam(':published', $articleDate, PDO::PARAM_STR);
  $response = $result->execute();
  if ($response) {
    echo "Зміни збережено";
  } else {
    echo "Помилка бази даних";
  }
}

if (isset($_POST['refreshArticleList'])) {
  $refreshArticleList = $_POST['refreshArticleList'];
  $result = $db1->query("SELECT * FROM th_news ORDER BY published DESC");
  while ($article = $result->fetch()) {
    if (strlen($article['title']) > 200) {
      $article['title'] = substr($article['title'], 0, 200) . "...";
    }
?>

  <tr>
    <td insertAfterById="<?php echo $article['id']; ?>"><div
         style="background:url('img/b6.jpg')center/cover;
                width: 40px;
                height: 36px;
                -webkit-border-radius: 4px;">
    </div></td>
    <td refreshById="<?php echo $article['id']; ?>"><?php echo $article['title']; ?></td>
    <td refreshById="<?php echo $article['id']; ?>" style="width: 90px;"><?php echo $article['published']; ?></td>
    <td>
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
            url: "teatradmin/ajaxHandler.php",
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
    <td>
      <button class="btn btn-danger glyphicon glyphicon-trash"
              data-toggle='modal'
              data-target='#myModal'
              deleteArticleById="<?php echo $article['id']; ?>">
      </button>
      <script type="text/javascript">
        $(".glyphicon-trash").click(function() {
          var deleteArticleById = $(this).attr("deleteArticleById");
          $("#continueDelete").attr("deleteArticleById", deleteArticleById);
        });
      </script>
    </td>
  </tr>

<?php
  }
}

if (isset($_POST['publishArticle'])) {
  $createTitle = $_POST['createTitle'];
  $createDate = $_POST['createDate'];
  $createShortContent = $_POST['createShortContent'];
  $createFullContent = $_POST['createFullContent'];
  $sql = 'INSERT INTO th_news (title, published, short_content, full_content)
          VALUES (:title, :published, :short_content, :full_content)';
  $result = $db1->prepare($sql);
  $result->bindParam(':title', $createTitle, PDO::PARAM_STR);
  $result->bindParam(':published', $createDate, PDO::PARAM_STR);
  $result->bindParam(':short_content', $createShortContent, PDO::PARAM_STR);
  $result->bindParam(':full_content', $createFullContent, PDO::PARAM_STR);
  $response = $result->execute();
  if ($response) {
    echo "Стаття опублікована";
  } else {
    echo "Помилка бази даних";
  }
}

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
?>
