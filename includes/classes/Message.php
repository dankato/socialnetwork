<?php
  class Message {
    // global vars
    private $user_obj;
    private $con;
    // constructors
    public function __construct($con, $user) {
      $this->con = $con;
      // creating an instance of the user class
      $this->user_obj = new User($con, $user);
    }

}
?>
