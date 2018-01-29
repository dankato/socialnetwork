<?php
  include("includes/header.php");
  $message_obj = new Message($con, $userLoggedIn);
  if(isset($_GET['u']))
    $user_to = $_GET['u'];
  else {
    // retrieve the most recent user we had interactions with
    $user_to = $message_obj->getMostRecentUser();
    // if you have not interacted with anyone yet, set to new
    if($user_to == false)
      $user_to = 'new';
  }
?>
