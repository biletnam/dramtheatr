
<?php

include 'block/connect.php';
$db1 = Db::getConnection();

// Refresh worker list
if (isset($_POST['refreshArticleList'])) {
  $refreshArticleList = $_POST['refreshArticleList'];
  $department = $_POST['department'];
  if (isset($_POST['paginationOffset'])) {
    $paginationOffset = $_POST['paginationOffset'];
  } else {
    $paginationOffset = 0;
  }
  $result = $db1->query("SELECT
    A.id,
    A.name,
    A.position,
    A.description,
    A.rank,
    th_photos.file_name
    FROM th_workers A, th_photos
    WHERE A.department_id = $department
    AND A.photo_id = th_photos.id
    ORDER BY rank ASC
    LIMIT 4 OFFSET $paginationOffset");
  $workers = array();
  $i = 0;
  while ($row = $result->fetch()) {
    $workers[$i]['id'] = $row['id'];
    $workers[$i]['name'] = $row['name'];
    $workers[$i]['rank'] = $row['rank'];
    $workers[$i]['file_name'] = $row['file_name'];
    $i++;
  }
  $result = $db1->query("SELECT
    th_workers.id,
    th_workers.name,
    th_workers.rank
    FROM th_workers
    WHERE department_id = $department
    ORDER BY rank ASC");
  $options = array();
  $i = 0;
  while ($row = $result->fetch()) {
    $options[$i]['id'] = $row['id'];
    $options[$i]['name'] = $row['name'];
    $options[$i]['rank'] = $row['rank'];
    $i++;
  }
  $result = $db1->query("SELECT
    MAX(rank) AS max
    FROM th_workers
    WHERE department_id = $department");
  $row = $result->fetch();
  $optionLast = $row['max'];
?>

<?php foreach ($workers as $worker): ?>
  <tr>
    <td insertAfterById="<?php echo $worker['id']; ?>" width="56" style="vertical-align: middle;">
      <div style="background:url(<?php echo $worker['file_name']; ?>)center/cover;
        width: 40px;
        height: 36px;
        -webkit-border-radius: 4px;">
      </div>
    </td>
    <td refreshById="<?php echo $worker['id']; ?>" width="330" style="vertical-align: middle;"><?php echo $worker['name']; ?></td>
    <td refreshById="<?php echo $worker['id']; ?>" width="330" style="vertical-align: middle;">
      <select class="ranking" worker-id="<?php echo $worker['id']; ?>" worker-rank="<?php echo $worker['rank']; ?>" style="width: 330px;">
        <option value="1">На початку</option>
        <option value="<?php echo $optionLast; ?>">В кінці</option>
        <?php foreach ($options as $option): ?>
          <?php if ($option['id'] != $worker['id']): ?>
            <?php if ($option['rank'] == ($worker['rank'] - 1)): ?>
              <option value="<?php echo $option['id']; ?>" selected>після <?php echo $option['name']; ?></option>
            <?php else: ?>
              <option value="<?php echo $option['id']; ?>">після <?php echo $option['name']; ?></option>
            <?php endif; ?>
          <?php endif; ?>
        <?php endforeach; ?>
      </select>
    </td>
    <td width="57" style="vertical-align: middle;">
      <button class="btn btn-default glyphicon glyphicon-pencil"
              data-toggle='tab'
              href="#editArticle"
              getArticleById="<?php echo $worker['id']; ?>">
      </button>
    </td>
    <td width="57" style="vertical-align: middle;">
      <button class="btn btn-danger glyphicon glyphicon-trash"
              data-toggle='modal'
              data-target='#myModal'
              deleteArticleById="<?php echo $worker['id']; ?>">
      </button>
    </td>
  </tr>
<?php endforeach; ?>

<script type="text/javascript">
  $(document).ready(function() {
    $('.ranking').select2();
  });
  $(".glyphicon-pencil").click(function() {
    $(".news").removeClass("active");
    var getArticleById = $(this).attr("getArticleById");
    $(".saveArticle").attr("workerId", getArticleById)
    $(".saveArticle").show();
    $.ajax({
      url: "teatradmin/th_workersHandler.php",
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
  $(".glyphicon-trash").click(function() {
    var deleteArticleById = $(this).attr("deleteArticleById");
    $("#continueDelete").attr("deleteArticleById", deleteArticleById);
    var workerTitle = $(this).parent().prev().prev().prev().text();
    $("#modal-text").text(workerTitle);
  });
  $('.ranking').change(function() {
    var workerRankNew = $(this).val();
    var workerRankOld = $(this).attr("worker-rank");
    var workerId = $(this).attr("worker-id");
    var paginationOffset = $('#tabWorkers').attr('pagination-offset');
    var department = $('#tabWorkers').attr('department');
    $.ajax({
      url: "teatradmin/th_workersHandler.php",
      async: false,
      method: "POST",
      data: {
        workerRankNew: workerRankNew,
        workerRankOld: workerRankOld,
        workerId: workerId,
        department: department
      },
      dataType: "html",
      success: function(data) {
        $("#snackbar").text(data);
      }
    });
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
    var x = document.getElementById("snackbar");
    x.className = "show";
    setTimeout(function(){ x.className = x.className.replace("show", ""); }, 3000);
  });
</script>

<?php
$result = $db1->query("SELECT count(id) AS count FROM th_workers WHERE department_id = $department");
$result->setFetchMode(PDO::FETCH_ASSOC);
$row = $result->fetch();
$workersQuantity = $row['count'];
?>

<tr style="text-align: center; width: 100%;">
  <td colspan="5" pagination-offset="<?php echo $paginationOffset; ?>">
    <?php for ($i = 1; $i < (ceil($workersQuantity/4)+1); $i++): ?>
      <button class="btn btn-default page" style="width: 40px; height: 34px;" pagination-offset="<?php echo ($i - 1) * 4; ?>"><?php echo $i; ?></button>
    <?php endfor; ?>
  </td>
</tr>
<script type="text/javascript">
  $('.page').removeClass('active');
  $('button[pagination-offset="' + $('td[pagination-offset]').attr('pagination-offset') + '"]').addClass('active');
  $('.page').click(function() {
    var department = $('#tabWorkers').attr('department');
    var paginationOffset = $(this).attr('pagination-offset');
    console.log(paginationOffset);
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

<?php
}

if (isset($_POST['workerRankNew'])) {
  $workerRankNew = $_POST['workerRankNew'];
  $workerRankOld = $_POST['workerRankOld'];
  $department = $_POST['department'];
  $workerId = $_POST['workerId'];
  if ($workerRankNew < $workerRankOld) {
    $sql = "UPDATE th_workers SET rank = rank + 1 WHERE department_id = $department AND rank >= $workerRankNew AND rank <= $workerRankOld;
            UPDATE th_workers SET rank = $workerRankNew WHERE id = $workerId;";
  } else {
    $sql = "UPDATE th_workers SET rank = rank - 1 WHERE department_id = $department AND rank <= $workerRankNew AND rank >= $workerRankOld;
            UPDATE th_workers SET rank = $workerRankNew WHERE id = $workerId;";
  }
  $result = $db1->prepare($sql);
  $response = $result->execute();
  if ($response) {
    echo "Порядок відображення змінено";
  } else {
    echo "Помилка бази даних";
  }
}
?>
