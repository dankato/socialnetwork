<?php
session_start();
  // connection variable
  $con = mysqli_connect("localhost", "root", "", "social");
  if(mysqli_connect_errno()) {
    echo "Failed to connect: " . mysqli_connect_errno();
  }
  // declaring vars to prevent errors
  $firstname = mysqli_query($con, "INSERT INTO test VALUES ('2', 'Jan')");
  $lastname = "";
  $email = "";
  $email2 = "";
  $password = "";
  $password2 = "";
  $date = "";
  $error_array = array();

  if (isset($_POST['register_button'])) {
    // registration form values plus strip tags for security purposes
    $firstname = strip_tags($_POST['reg_first_name']);
    $firstname = str_replace(' ', '', $firstname);
    $firstname = ucfirst(strtolower($firstname));
    $_SESSION['reg_first_name'] = $firstname; // Storing first name into session variable

    $lastname = strip_tags($_POST['reg_last_name']);
    $lastname = str_replace(' ', '', $lastname);
    $lastname = ucfirst(strtolower($lastname));
    $_SESSION['reg_last_name'] = $lastname; // Storing into session variable

    $email = strip_tags($_POST['reg_email']);
    $email = str_replace(' ', '', $email);
    $email = ucfirst(strtolower($email));
    $_SESSION['reg_email'] = $email; // Storing into session variable

    $email2 = strip_tags($_POST['reg_email2']);
    $email2 = str_replace(' ', '', $email2);
    $email2 = ucfirst(strtolower($email2));
    $_SESSION['reg_email2'] = $email2; // Storing into session variable

    $password = strip_tags($_POST['reg_password']);
    $password2 = strip_tags($_POST['reg_password2']);

    $date = date("Y-m-d");

    if($email == $email2) {
      // check to see if email is valid
      if(filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);

        // does email already exist?
        $email_check = mysqli_query($con, "SELECT email FROM users WHERE email='$email'");

        // Count number of rows returned
        $num_rows = mysqli_num_rows($email_check);

        if($num_rows > 0) {
          array_push($error_array, "Email already in use.<br>");
        }


      }
      else {
        array_push($error_array, "Invalid email format.<br>");
      }
    }
    else {
		   array_push($error_array, "Emails do not match.<br>");
	  }

    if(strlen($firstname) > 25 || strlen($firstname) < 2) {
          array_push($error_array, "Your first name must be between 2 and 25 characters.<br>");
    }
    if(strlen($lastname) > 25 || strlen($lastname) < 2) {
      array_push($error_array, "Your last name must be between 2 and 25 characters.<br>");
    }

    if($password != $password2) {
      array_push($error_array, "Your passwords do not match.<br>");
    }
    else {
      if(preg_match('/[^A-Za-z0-9]/', $password)) {
        array_push($error_array, "Your password can only contain characters or numbers.<br>");
      }
    }
    if(strlen($password > 30 || strlen($password) < 5)) {
      array_push($error_array, "Your password must be between 5 and 30 characters.<br>");
    }

    if(empty($error_array)) {
      $password = md5($password);
      // generate username
      $username = strtolower($firstname . "_" . $lastname);
      $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
      $i = 0;
      // if username exists, adding number to username (example john_doe, john_doe1)
      while(mysqli_num_rows($check_username_query) != 0) {
        $i++;
        $username = $username . "_" . $i;
        $check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username='$username'");
      }
    }

  }
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>Register</title>
  </head>
  <body>
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
    </form>
  </body>
</html>
