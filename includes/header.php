<?php
  require 'config/config.php';
  include('includes/classes/User.php');
  include('includes/classes/Post.php');

  // prevent users to access site without logging in first
  if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
  } else {
    header("Location: register.php");
  }
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Social Network</title>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,600,600i,700,700i" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://use.fontawesome.com/8f99050c9f.js"></script>
    <!-- jquery/js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
  </head>
  <body>

    <div class="top_bar">
      <div class="logo">
        <a href="index.php">Social Network</a>
      </div>
      <nav>
        <a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name']?></a>
        <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i></a>
        <a href="#"><i class="fa fa-comment-o" aria-hidden="true"></i></a>

        <a href="#"><i class="fa fa-exclamation" aria-hidden="true"></i></a>
        <a href="requests.php"><i class="fa fa-users" aria-hidden="true"></i></a>
        <a href="#"><i class="fa fa-cog" aria-hidden="true"></i></a>
        <a href="includes/handlers/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
      </nav>
    </div>
    <div class="wrapper">
