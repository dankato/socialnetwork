<?php
  // connection variable
  $con = mysqli_connect("localhost", "root", "", "social");
  if(mysqli_connect_errno()) {
    echo "Failed to connect: " . mysqli_connect_errno();
  }
?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Social Network</title>
  </head>
  <body>
    <h1>Starting up...</h1>
  </body>
</html>
