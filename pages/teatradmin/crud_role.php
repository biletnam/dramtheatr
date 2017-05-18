<?php
include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['createRole'])) {
  $spectacleId = $_POST['spectacleId'];
  if (isset($_POST['createRoleTitle'])) {
    $createRoleTitle = $_POST['createRoleTitle'];
  }
  if (isset($_POST['createRoleWorkerIdSelect'])) {
    $createRoleWorkerIdSelect = $_POST['createRoleWorkerIdSelect'];
  }
  if (isset($_POST['createRoleRank'])) {
    $createRoleRank = $_POST['createRoleRank'];
    if ($createRoleRank == '') {
      $result = $db1->query("SELECT
        MAX(rank) AS max
        FROM dt_roles WHERE spectacle_id = $spectacleId");
      $row = $result->fetch();
      $createRoleRank = $row['max'] + 1;
    }
  }
  if ($createRoleTitle && $createRoleWorkerIdSelect && $createRoleRank) {
    $sql = 'INSERT INTO dt_roles (role, actor_id, spectacle_id, rank)
            VALUES (:role, :actor_id, :spectacle_id, :rank)';
    $result = $db1->prepare($sql);
    $result->bindParam(':role', $createRoleTitle, PDO::PARAM_STR);
    $result->bindParam(':actor_id', $createRoleWorkerIdSelect, PDO::PARAM_STR);
    $result->bindParam(':spectacle_id', $spectacleId, PDO::PARAM_STR);
    $result->bindParam(':rank', $createRoleRank, PDO::PARAM_STR);
    $response = $result->execute();
  }
}

if (isset($_POST['updateRole'])) {
  $spectacleId = $_POST['spectacleId'];
  $roleId = $_POST['roleId'];
  if (isset($_POST['updateRoleTitle'])) {
    $updateRoleTitle = $_POST['updateRoleTitle'];
  }
  if (isset($_POST['updateRoleWorkerIdSelect'])) {
    $updateRoleWorkerIdSelect = $_POST['updateRoleWorkerIdSelect'];
  }
  if (isset($_POST['updateRoleRank'])) {
    $updateRoleRank = $_POST['updateRoleRank'];
  }
  if (isset($_POST['oldRoleRank'])) {
    $oldRoleRank = $_POST['oldRoleRank'];
  }

  if ($oldRoleRank != $updateRoleRank) {
    if ($updateRoleRank < $oldRoleRank) {
      $sql = "UPDATE dt_roles SET rank = rank + 1 WHERE rank >= $updateRoleRank AND rank <= $oldRoleRank;
      UPDATE dt_roles SET rank = $updateRoleRank WHERE id = $roleId;";
    } else {
      $sql = "UPDATE dt_roles SET rank = rank - 1 WHERE rank <= $updateRoleRank AND rank >= $oldRoleRank;
      UPDATE dt_roles SET rank = $updateRoleRank WHERE id = $roleId;";
    }
    $result = $db1->prepare($sql);
    $response = $result->execute();
  }

  $sql = 'UPDATE dt_roles
          SET role = :role, actor_id = :actor_id, spectacle_id = :spectacle_id, rank = :rank
          WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $roleId, PDO::PARAM_STR);
  $result->bindParam(':role', $updateRoleTitle, PDO::PARAM_STR);
  $result->bindParam(':actor_id', $updateRoleWorkerIdSelect, PDO::PARAM_STR);
  $result->bindParam(':spectacle_id', $spectacleId, PDO::PARAM_STR);
  $result->bindParam(':rank', $updateRoleRank, PDO::PARAM_STR);
  $response = $result->execute();
}

if (isset($_POST['deleteRole'])) {
  $spectacleId = $_POST['spectacleId'];
	$roleId = $_POST['roleId'];
  $sql = 'DELETE FROM dt_roles WHERE id = :id';
  $result = $db1->prepare($sql);
  $result->bindParam(':id', $roleId, PDO::PARAM_STR);
  $result->execute();
}

if (isset($_POST['spectacleId'])) {
	$spectacleId = $_POST['spectacleId'];
}

$result = $db1->query("SELECT
  dt_roles.id,
  dt_roles.actor_id,
  dt_roles.role,
  dt_roles.rank,
  dt_actors.name
  FROM dt_roles
  INNER JOIN dt_actors
  ON dt_roles.actor_id = dt_actors.id
  WHERE spectacle_id = '$spectacleId'
  ORDER BY dt_roles.rank");
$roles = array();
$i = 0;
while ($row = $result->fetch()) {
  $roles[$i]['id'] = $row['id'];
  $roles[$i]['actor_id'] = $row['actor_id'];
  $roles[$i]['role'] = $row['role'];
  $roles[$i]['rank'] = $row['rank'];
  $roles[$i]['name'] = $row['name'];
  $i++;
}
$result = $db1->query("SELECT id, name FROM dt_actors WHERE id_n = '1' OR id_n = '2' OR id_n = '3' ORDER BY name ASC");
$actors = array();
$i = 0;
while ($row = $result->fetch()) {
  $actors[$i]['id'] = $row['id'];
  $actors[$i]['name'] = $row['name'];
  $i++;
}
?>
<table>
	<tbody>
		<?php foreach ($roles as $role): ?>
			<tr>
				<td align="center" width="5%" style="padding: 5px;"><?php echo $role["rank"]; ?></td>
				<td align="center" width="35%" style="padding: 5px;"><?php echo $role["role"]; ?></td>
				<td align="center" width="35%" style="padding: 5px;"><?php echo $role["name"]; ?></td>
				<td width="24%" style="padding: 5px;">
          <button class="editRole toggle-buttons" style="margin-right: 5px;width: 47%;">Редагувати</button>
          <button class="deleteRole toggle-buttons" style="width: 47%;" role-id="<?php echo $role['id']; ?>">Видалити</button>
        </td>
			</tr>
			<tr class="toggle-row" style="display: none;">
				<td align="center" width="5%" style="padding: 5px;">
          <input type="text" name="updateRoleRank" style="width: 100%;text-align: center;" value="<?php echo $role['rank']; ?>">
        </td>
				<td align="center" width="35%" style="padding: 5px;">
          <input type="text" name="updateRoleTitle" style="width: 100%;text-align: center;" value="<?php echo $role['role']; ?>">
        </td>
				<td align="center" width="35%" style="padding: 5px;">
  				<select id="updateRoleWorkerIdSelect" style="width: 100%;display: inline-block;">
            <?php foreach ($actors as $actor): ?>
    					<option <?php echo ($role['actor_id'] == $actor['id'])?"selected":"" ?> value="<?php echo $actor['id']; ?>">
                <?php echo $actor['name']; ?>
              </option>
            <?php endforeach; ?>
  				</select>
        </td>
				<td width="24%" style="padding: 5px;">
          <button class="updateRole" style="margin-right: 5px;width: 47%;" role-id="<?php echo $role['id']; ?>">Оновити</button>
          <input type="text" name="oldRoleRank" hidden value="<?php echo $role['rank']; ?>">
          <button class="cancel" style="width: 47%;">Відмінити</button>
        </td>
			</tr>
		<?php endforeach; ?>
    <script type="text/javascript">
    $(".editRole").click(function() {
      $(".toggle-buttons").hide();
      $(this).parent().parent().hide();
      $(this).parent().parent().next().show();
    });
    $(".cancel").click(function() {
      $(this).parent().parent().hide();
      $(this).parent().parent().prev().show();
      $(".toggle-buttons").show();
    });
    $(".updateRole").click(function() {
      $(this).parent().parent().hide();
      $(this).parent().parent().prev().show();
      $(".toggle-buttons").show();
      var spectacleId = $("input[name='updateSpectacleId']").val();
      var roleId = $(this).attr("role-id");
      var updateRoleRank = $(this).parent().prev().prev().prev().children().val();
      var updateRoleTitle = $(this).parent().prev().prev().children().val();
      var updateRoleWorkerIdSelect = $(this).parent().prev().children().val();
      var oldRoleRank = $(this).next().val();
      $.ajax({
        url: "teatradmin/crud_role.php",
        method: "POST",
        data: {
          spectacleId: spectacleId,
          roleId: roleId,
          updateRoleRank: updateRoleRank,
          updateRoleTitle: updateRoleTitle,
          updateRoleWorkerIdSelect: updateRoleWorkerIdSelect,
          oldRoleRank: oldRoleRank,
          updateRole: true
        },
        dataType: "html",
        success: function(data) {
          $("#crud_role").html(data);
        }
      });
    });
    </script>
		<tr>
			<td style="padding: 5px;"><input type="text" name="createRoleRank" style="width: 100%;text-align: center;"></td>
			<td style="padding: 5px;"><input type="text" name="createRoleTitle" style="width: 100%;text-align: center;"></td>
			<td style="padding: 5px;">
        <select id="createRoleWorkerIdSelect" style="width: 100%;display: inline-block;">
          <?php foreach ($actors as $actor): ?>
            <option value="<?php echo $actor['id']; ?>"><?php echo $actor['name']; ?></option>
          <?php endforeach; ?>
        </select>
			</td>
			<td style="padding: 5px;"><button id="createRole" style="width: 100%">Додати</button></td>
		</tr>
	</tbody>
</table>
<script type="text/javascript">
  $(document).ready(function() {
    $("#createRole").click(function() {
      var spectacleId = $("input[name='updateSpectacleId']").val();
      var createRoleRank = $("input[name='createRoleRank']").val();
      var createRoleTitle = $("input[name='createRoleTitle']").val();
      var createRoleWorkerIdSelect = $("#createRoleWorkerIdSelect").val();
      $.ajax({
    		url: "teatradmin/crud_role.php",
    		method: "POST",
    		data: {
    			spectacleId: spectacleId,
    			createRoleRank: createRoleRank,
    			createRoleTitle: createRoleTitle,
    			createRoleWorkerIdSelect: createRoleWorkerIdSelect,
          createRole: true
    		},
    		dataType: "html",
    		success: function(data) {
    			$("#crud_role").html(data);
    		}
    	});
    });
    $(".deleteRole").click(function() {
      var spectacleId = $("input[name='updateSpectacleId']").val();
      var roleId = $(this).attr("role-id");
      $.ajax({
    		url: "teatradmin/crud_role.php",
    		method: "POST",
    		data: {
          spectacleId: spectacleId,
    			roleId: roleId,
          deleteRole: true
    		},
    		dataType: "html",
    		success: function(data) {
    			$("#crud_role").html(data);
    		}
    	});
    });
  });
</script>
