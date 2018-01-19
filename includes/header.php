<?php
  require 'config/config.php';

  // prevent users to access site without logging in first
  if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
  } else {
    header("Location: register.php");
  }
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Social Network</title>
    <link href="https://fonts.googleapis.com/css?family=Cabin:400,500,600,700" rel="stylesheet">
  </head>
  <body>
