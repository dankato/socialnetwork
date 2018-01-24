<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="assets/css/style.css">
  </head>
  <body>
    <?php
      include('includes/classes/User.php');
      include('includes/classes/Post.php');
      require 'config/config.php';

      // prevent users to access site without logging in first
      if (isset($_SESSION['username'])) {
        $userLoggedIn = $_SESSION['username'];
        $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
        $user = mysqli_fetch_array($user_details_query);
      } else {
        header("Location: register.php");
      }
      $get_likes = mysqli_query($con, "SELECT likes, added_by FROM posts WHERE id='$post_id'");
      $row = mysqli_fetch_array($get_likes);
      $total_liked = $row['likes'];
      $user_liked = $row['added_by'];
      $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user_liked'");
      $row = mysqli_fetch_array($user_details_query);

      // check for previous likes
      $check_query = mysqli_query($con, "SELECT * FROM likes WHERE username='$userLoggedIn' AND post_id='$post_id'");
      $num_rows = mysqli_num_rows($check_query);
      // if there is a data entry already
      if($num_rows > 0) {
        echo 'button';
      } else {
        echo 'button';
      }
    ?>
  </body>
</html>
