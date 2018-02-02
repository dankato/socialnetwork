<?php
  include("../../config/config.php");
  include("../classes/User.php");
  include("../classes/Message.php");

  $limit = 7; // # of messages to load
  $message = new Message($con, $_REQUEST['userLoggedIn']); //request comes from ajax call

  echo $message->getConvosDropdown($_REQUEST, $limit);
?>
