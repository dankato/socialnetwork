<?php

?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
  </head>
  <body>
    <form class="" action="register.php" method="post">
      <input type="text" name="reg_first_name" placeholder="first name" required>
      <br>
      <input type="text" name="reg_last_name" placeholder="last name" required>
      <br>
      <input type="email" name="reg_email" placeholder="email" required>
      <br>
      <input type="email" name="reg_email2" placeholder="confirm email" required>
      <br>
      <input type="password" name="reg_password" placeholder="password" required>
      <br>
      <input type="password" name="reg_password2" placeholder="confirm password" required>
      <br>
      <input type="submit" name="register_button" value="register">
    </form>
  </body>
</html>
