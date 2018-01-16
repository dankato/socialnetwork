<?php
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
  $error_array = "";

  if (isset($_POST['register_button'])) {
    // registration form values plus strip tags for security purposes
    $firstname = strip_tags($_POST['reg_first_name']);
    $firstname = str_replace(' ', '', $firstname);
    $firstname = ucfirst(strtolower($firstname));
    $lastname = strip_tags($_POST['reg_last_name']);
    $lastname = str_replace(' ', '', $lastname);
    $lastname = ucfirst(strtolower($lastname));
    $email = strip_tags($_POST['reg_email']);
    $email = str_replace(' ', '', $email);
    $email = ucfirst(strtolower($email));
    $email2 = strip_tags($_POST['reg_email2']);
    $email2 = str_replace(' ', '', $email2);
    $email2 = ucfirst(strtolower($email2));
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
            echo "Email already in use.";
          } else {
            echo "Emails do not match.";
          }
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
