<?php
  class Notification {
    // global vars
    private $user_obj;
    private $con;
    // constructors
    public function __construct($con, $user) {
      $this->con = $con;
      // creating an instance of the user class
      $this->user_obj = new User($con, $user);
    }
    public function getUnreadNumber() {
        $userLoggedIn = $this->user_obj->getUsername();
        $query = mysqli_query($this->con, "SELECT * FROM notifications WHERE viewed='no' AND user_to='$userLoggedIn'");
        return mysqli_num_rows($query);
    }
  }
?>
