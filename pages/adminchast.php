<?php session_start(); ?>
<html>
<head>
  <title>������� �������� ��������������</title>
</head>
<body>

  <form action="testreg.php" method="post">
    <p>
      <label>��� �����:<br></label>
      <input name="login" type="text" size="15" maxlength="15">
    </p>

    <p>
      <label>��� ������:<br></label>
      <input name="password" type="password" size="15" maxlength="15">
    </p>

    <p>
      <input type="submit" name="submit" value="�����">
      <br>
      <a href="reg.php">������������������</a>
    </p>
  </form>

</body>
</html>
