<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['articleId'])) {
	$articleId = $_POST['articleId'];
}

$result = $db1->query("SELECT * FROM dt_news WHERE id = '$articleId'");
$result->setFetchMode(PDO::FETCH_ASSOC);
$article = $result->fetch();
?>

<!-- <p>Тема:</p>
<input type="text" id="updateArticleTitle" style="width: 100%" value="<?php //echo $article['tema']; ?>"><br><br>
<p>Коротка стаття:</p>
<div id="updateShortContent"><?php //echo $article['short_content']; ?></div>
<p>Повна стаття:</p>
<div id="updateFullContent"><?php //echo $article['txt']; ?></div>
<p>Виберіть дату (місяць, день, рік):</p>
<input type="date" id="updateDate" value="<?php //echo $article['date']; ?>">
<input type="text" id="articleId" value="<?php //echo $article['id']; ?>" hidden> -->

<form action="teatradmin/red_news.php" method="post" enctype="multipart/form-data">
	<input name="oldArticleImage" type="text" hidden value="<?php echo $article['photo']; ?>">
	<p>Тема:</p>
	<input type="text" name="updateArticleTitle" style="width: 100%" value="<?php echo $article['tema']; ?>">
	<p style="margin-top: 5px;">Зображення:</p>
	<input type="file" name="updateArticleImage">
	<p style="margin-top: 5px;">Коротка стаття:</p>
	<textarea id="updateShortContent" name="updateShortContent"><?php echo $article['short_content']; ?></textarea>
	<p style="margin-top: 5px;">Повна стаття:</p>
	<textarea id="updateFullContent" name="updateFullContent"><?php echo $article['txt']; ?></textarea>
	<p style="margin-top: 5px;">Виберіть дату (місяць, день, рік):</p>
	<input type="date" id="date" name="updateDate" value="<?php echo $article['date']; ?>">
	<input type="text" name="articleId" value="<?php echo $articleId; ?>" hidden>
	<input type="submit" value="Оновити">
</form>

<script>

  $("#updateShortContent").summernote({
	fontSizes: ["8", "9", "10", "11", "12", "14", "16", "18", "24", "36", "48"],
  toolbar: [
    ["style", ["style"]],
    ["font", ["bold", "italic", "underline", "clear"]],
    ["fontname", ["fontname"]],
    ["fontsize", ["fontsize"]],
    ["color", ["color"]],
    ["para", ["ul", "ol", "paragraph"]],
    ["insert", ["video", "link"]],
    ["table", ["table"]],
    ["fullscreen", ["fullscreen", "codeview"]]
  ],
  height: 160,
  focus: false
  });

  $("#updateFullContent").summernote({
	fontSizes: ["8", "9", "10", "11", "12", "14", "16", "18", "24", "36", "48"],
  toolbar: [
    ["style", ["style"]],
    ["font", ["bold", "italic", "underline", "clear"]],
    ["fontname", ["fontname"]],
    ["fontsize", ["fontsize"]],
    ["color", ["color"]],
    ["para", ["ul", "ol", "paragraph"]],
    ["insert", ["video", "link"]],
    ["table", ["table"]],
    ["fullscreen", ["fullscreen", "codeview"]]
  ],
  height: 300,
  focus: false
  });

</script>
