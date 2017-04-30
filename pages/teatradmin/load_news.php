<?php include 'block/connect.php' ?>

<div class="container"
		 style="padding-bottom: 0px;">
	<div class="row">

		<?php
		if (isset($_POST['zminnaid'])) {
			$zminnaid = $_POST['zminnaid'];
		}
		$result = mysql_query("SELECT * FROM dt_news WHERE id='$zminnaid'");
		$myrow = mysql_fetch_array($result);
		do { ?>
			<form id='send'>
			<div class='col-md-6'>
				<input id='idn'
							 type='hidden'
							 class='form-control'
							 value='<?php echo $myrow["id"]; ?>'
							 style='margin-bottom: 10px;'>
				<label>Тема</label>
				<input id='temas'
							 type='text'
							 class='form-control'
							 value='<?php echo $myrow["tema"]; ?>'
							 size='89'
							 style='margin-bottom: 10px;'>
				<label>Дата</label>
				<input id='posadas'
							 type='date'
							 class='form-control'
							 value='<?php echo $myrow["date"]; ?>'
							 style='margin-bottom: 10px;'>
				<label>Коротка стаття:</label>
				<div id='edit_short_content'><?php echo $myrow["short_content"]; ?></div>
			</div>
			<div class='col-md-6' max-height='100px;'>
				<label>Головне зображення:</label>
				<div style="background:url('img/b6.jpg') center/cover; height: 384px; -webkit-border-radius: 4px;">
				</div>
			</div>
			<div class='col-md-12'>
				<label>Повна стаття:</label>
				<div id='edit_full_content'><?php echo $myrow["txt"]; ?></div>
			</div>
			</form>
		<?php
		} while ($myrow = mysql_fetch_array($result));
		?>

	</div><!-- end row -->
</div><!-- end container -->

<script>

  $("#edit_short_content").summernote({
	fontSizes: ["8", "9", "10", "11", "12", "14", "16", "18", "24", "36", "48"],
  toolbar: [
    ["style", ["style"]],
    ["font", ["italic", "underline", "clear"]],
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

  $("#edit_full_content").summernote({
	fontSizes: ["8", "9", "10", "11", "12", "14", "16", "18", "24", "36", "48"],
  toolbar: [
    ["style", ["style"]],
    ["font", ["italic", "underline", "clear"]],
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
