<?php
include 'checkUser.php';

$result = $db1->query("SELECT * FROM dt_news ORDER BY date DESC");
$articles = array();
$i = 0;
while ($row = $result->fetch()) {
  $articles[$i]['id'] = $row['id'];
  $articles[$i]['date'] = $row['date'];
  $articles[$i]['tema'] = substr($row['tema'], 0, 200);
  $i++;
}
?>

<section class="theatre parallax-window-news" data-parallax="scroll" data-image-src="/img/news/news-bg.jpg">
  <div class="container">
    <div class="row">
      <fieldset>
        <legend><h2>Добавити:</h2></legend>
        <form action="teatradmin/add_news.php" method="post" enctype="multipart/form-data">
          <p>Тема:</p>
          <input type="text" name="createArticleTitle" style="width: 100%"/>
          <p style="margin-top: 5px;">Зображення:</p>
          <input type="file" name="createArticleImage">
          <p style="margin-top: 5px;">Коротка стаття:</p>
          <textarea id="createArticleShortContent" name="createArticleShortContent"></textarea>
          <p style="margin-top: 5px;">Повна стаття:</p>
          <textarea id="createArticleFullContent" name="createArticleFullContent"></textarea>
          <p style="margin-top: 5px;">Виберіть дату (місяць, день, рік):</p>
          <input type="date" id="date" name="createArticleDate">
          <input type="submit" value="Додати">
        </form>
      </fieldset>

      <fieldset>
        <legend><h2>Видалити:</h2></legend>
        <p>Виберіть новину яку потрібно видалити:</p>
        <select id="deleteArticleSelect">
          <option>Видалити статтю</option>
          <?php foreach ($articles as $article): ?>
            <option value="<?php echo $article['id']; ?>"><?php echo $article['date']; ?> <?php echo $article['tema']; ?></option>
          <?php endforeach; ?>
          <input type="button" id="deleteArticleButton" value="Видалити">
        </select>
      </fieldset>

      <fieldset>
        <legend><h2>Змінити:</h2></legend>
        <p>Виберіть статтю</p>
        <select id="updateArticleSelect">
          <option>Виберіть статтю</option>
          <?php foreach ($articles as $article): ?>
            <option value="<?php echo $article['id']; ?>"><?php echo $article['date']; ?> <?php echo $article['tema']; ?></option>
          <?php endforeach; ?>
        </select>
        <div id="redaktirov">
          <input type="button" id="updateArticleButton" value="Оновити">
        </div>
      </fieldset>
    </div>
  </div>
</section>

<script>
// добавлення новини

  $('#createArticleShortContent').summernote({
  fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36', '48'],
  toolbar: [
    ['style', ['style']],
    ['font', ['bold', 'italic', 'underline', 'clear']],
    ['fontname', ['fontname']],
    ['fontsize', ['fontsize']],
    ['color', ['color']],
    ['para', ['ul', 'ol', 'paragraph']],
    ['insert', ['picture', 'video', 'link']],
    ['table', ['table']],
    ['fullscreen', ['fullscreen', 'codeview']]
  ],
  height: 100,
  focus: false
  });

  $("#createArticleFullContent").summernote({
  fontSizes: ["8", "9", "10", "11", "12", "14", "16", "18", "24", "36", "48"],
  toolbar: [
    ["style", ["style"]],
    ["font", ["bold", "italic", "underline", "clear"]],
    ["fontname", ["fontname"]],
    ["fontsize", ["fontsize"]],
    ["color", ["color"]],
    ["para", ["ul", "ol", "paragraph"]],
    ["insert", ["picture", "video", "link"]],
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

  // видалення новини
  $("#deleteArticleButton").click(function() {
    var articleId = $("#deleteArticleSelect").val();
    $.ajax({
      url:  "teatradmin/del_news.php",
      method: "POST",
      data: {
        articleId: articleId
      },
      dataType: "html",
      success:  function(data) {
        location.reload();
      }
    });
  });

  // редагування новини
  $("#updateArticleSelect").change(function() {
    var articleId = $(this).val();
    $.ajax({
      url: "teatradmin/load_news.php",
      method: "POST",
      data: {
        articleId: articleId
      },
      dataType: "html",
      success: function(data) {
        $("#redaktirov").html(data);
      }
    });
  });
  // $("#updateArticleButton").click(function() {
  //   var articleId = $("#articleId").val();
  //   var updateArticleTitle = $("#updateArticleTitle").val();
  //   var updateShortContent = $("#updateShortContent").summernote('code');
  //   var updateFullContent = $("#updateFullContent").summernote('code');
  //   var updateDate = $("#updateDate").val();
  //   $.ajax({
  //     url:  "teatradmin/red_news.php",
  //     method: "POST",
  //     data: {
  //       articleId: articleId,
  //       updateArticleTitle: updateArticleTitle,
  //       updateShortContent: updateShortContent,
  //       updateFullContent: updateFullContent,
  //       updateDate: updateDate
  //     },
  //     dataType: "html",
  //     success:  function(data) {
  //       location.reload();
  //     }
  //   });
  // });

});
</script>
<?php include 'footerAdmin.php' ?>
