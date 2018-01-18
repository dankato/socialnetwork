<?php
  require 'config/config.php';
  require 'includes/form_handlers/register_handler.php';
  require 'includes/form_handlers/login_handler.php';
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
    <link rel="stylesheet" href="assets/css/register_style.css">
  </head>
  <body>
    <div class="wrapper">

      <form action="register.php" method="post">
        <input type="email" name="log_email" placeholder="Email Address" value="<?php
        if(isset($_SESSION['log_email'])) {
          echo $_SESSION['log_email'];
        }?>" required>
        <br>
        <input type="password" name="log_password" placeholder="Password"><br>

        <?php if(in_array("Email or password was not correct.<br>", $error_array)) echo "Email or password was not correct.<br>"; ?>

        <input type="submit" name="login_button" value="Login">
      </form>


      <form class="" action="register.php" method="post">
        <input type="text" name="reg_first_name" placeholder="first name" value="<?php if(isset($_SESSION['reg_first_name'])) {
          echo $_SESSION['reg_first_name'];
        }?>" required>
        <br>

        <?php if(in_array("Your first name must be between 2 and 25 characters.<br>", $error_array)) {
          echo "Your first name must be between 2 and 25 characters.<br>";
        } ?>

        <input type="text" name="reg_last_name" placeholder="last name" value="<?php if(isset($_SESSION['reg_last_name'])) {
          echo $_SESSION['reg_last_name'];
        }?>" required>
        <br>

        <?php if(in_array("Your last name must be between 2 and 25 characters.<br>", $error_array)) {
          echo "Your last name must be between 2 and 25 characters.<br>";
        } ?>

        <input type="email" name="reg_email" placeholder="email" value="<?php if(isset($_SESSION['reg_email'])) {
          echo $_SESSION['reg_email'];
        }?>" required>
        <br>

        <input type="email" name="reg_email2" placeholder="confirm email" value="<?php if(isset($_SESSION['reg_email2'])) {
          echo $_SESSION['reg_email2'];
        }?>" required>
        <br>

        <?php
        if(in_array("Email already in use.<br>", $error_array)) echo "Email already in use.<br>";
        else if(in_array("Invalid email format.<br>", $error_array)) echo "Invalid email format.<br>";
        else if(in_array("Emails do not match.<br>", $error_array)) echo "Emails do not match.<br>";
        ?>

        <input type="password" name="reg_password" placeholder="password" required>
        <br>
        <input type="password" name="reg_password2" placeholder="confirm password" required>
        <br>

        <?php
        if(in_array("Your passwords do not match.<br>", $error_array)) echo "Your passwords do not match.<br>";
        else if(in_array("Your password can only contain characters or numbers.<br>", $error_array)) echo "Your password can only contain characters or numbers.<br>";
        else if(in_array("Your password must be between 5 and 30 characters.<br>", $error_array)) echo "Your password must be between 5 and 30 characters.<br>";
        ?>

        <input type="submit" name="register_button" value="register">
        <br>
        <?php if(in_array("<span style='color: #14C800;'>Login sucessful.</span><br>", $error_array)) echo "<span style='color: #14C800;'>Login sucessful.</span><br>"; ?>


      </form>
    </div>
  </body>
</html>
