<?php
  if(isset($_POST['login_button'])) {
    $email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); // making sure email is in a correct format
    $_SESSION['log_email'] = $email; // storing email into a session var
    $password = md5($_POST['log_password']); // getting password

    $check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    $check_login_query = mysqli_num_rows($check_database_query);

    if($check_login_query == 1) {
      $row = mysqli_fetch_array($check_database_query); // results from query above now stored in this var
      $username = $row['$username']; // in the array row, username is now assigned to var

      $user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_closed='yes'");
      if(mysqli_num_rows($user_closed_query) == 1) {
        $reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'");
      }

      $_SESSION['username'] = $username; // saving the value of username in the session var to $username
      header("Location: index.php");
      exit();
    }
    else {
      array_push($error_array, "Email or password was not correct.<br>");
    }
  }
?>
