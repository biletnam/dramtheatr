<?php

$db = mysql_connect("localhost", "admin", "130913");
$res = mysql_select_db("teatr", $db);
mysql_query("SET names 'utf-8'");

$result = mysql_query("SELECT * from dt_vistava");
$myrow = mysql_fetch_array($result);

do {
  printf ("<p>
             <input name='checkbox'
                    id='%s'
                    class='my-checkbox'
                    type='checkbox'
                    value='%s'>%s
             </input>
           </p>",  $myrow["id"],$myrow["nazva"],$myrow["nazva"]);
} while ($myrow = mysql_fetch_array($result));
?>

<html>
<head>
  <script type="text/javascript"
          src="//ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js">
  </script>
</head>
<body>
  <button id="add">shopa</button>
  <div id="message"></div>

  <script>
  $(document).ready(function() {
    $("#add").click(function() {
      $('input:checkbox:checked').each(function() {
        var $n = $(this).attr('id');
        $.ajax({
          url: "add_actors.php",
          method: "POST",
          data: {
            zminnaw: $n
          },
          dataType: "html",
          success: function(data) {
            $("#message").html(data);
          }
        });
      });
    });
  });
  </script>

</body>
</html>
