<?php

include 'block/connect.php';
$db1 = Db::getConnection();

if (isset($_POST['zminnaid'])) {
  $zminnaid = $_POST['zminnaid'];
}
$result = $db1->query("SELECT
  id,
  nazva,
  avtor,
  times,
  id_rep,
  tip,
  photozag,
  start
  FROM dt_vistava
  WHERE id = '$zminnaid'");
$result->setFetchMode(PDO::FETCH_ASSOC);
$article = $result->fetch();
?>

<form name='send' id='send'><br>
  <input name='idn' id='idn' type='hidden' value="<?php echo $article['id']; ?>"><br>
  <input name='photozag' id='photozag' type='hidden' value="<?php echo $article['photozag']; ?>">
  <input name='avtor' id='avtor' type='hidden' value="<?php echo $article['avtor']; ?>">
  <input name='times' id='times' type='hidden' value="<?php echo $article['times']; ?>">
  <input name='tip' id='tip' type='hidden' value="<?php echo $article['tip']; ?>">
  <input name='id_rep' id='id_rep' type='hidden' value="<?php echo $article['id_rep']; ?>"><br>
  <input name='nazva' id='nazva' type='hidden' value="<?php echo $article['nazva']; ?>">
  <span>Дата початку</span><br>
  <input name='start' id='start' type='datetime' value="<?php echo $article['start']; ?>" size='100'>
</form>

<script type="text/javascript">
  $(document).ready(function(){
    // Set current date to input
    Date.prototype.toDateInputValue = (function() {
      var local = new Date(this);
      local.setMinutes(this.getMinutes() - this.getTimezoneOffset());
      return local.toJSON().slice(0,10) + " 18:00";
    });
    $('#start').val(new Date().toDateInputValue());
  });
</script>
