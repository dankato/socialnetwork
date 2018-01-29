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

    public function getMostRecentUser() {
      $userLoggedIn = $this->user_obj->getUsername();

      $query = mysqli_query($this->con, "SELECT user_to, user_from FROM messages WHERE user_to='$userLoggedIn' OR user_from='$userLoggedIn' ORDER BY id DESC LIMIT 1");

      if(mysqli_num_rows($query) == 0)
        return false;
      $row = mysqli_fetch_array($query);
      $user_to = $row['user_to'];
      $user_from = $row['user_from'];

      if($user_to != $userLoggedIn)
        return $user_to;
      else
        return $user_from;
    }

    public function sendMessage($user_to, $body, $date) {
      if($body != "") {
        $userLoggedIn = $this->user_obj->getUsername();
        $query = mysqli_query($this->con, "INSERT INTO messages VALUES ('', '$user_to', '$userLoggedIn', '$body', '$date', 'no', 'no', 'no')");
      }
    }
}
?>
