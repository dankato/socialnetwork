<?php
  class User {
    // global vars
    private $user;
    private $con;
    // constructors
    public function __construct($con, $user) {
      $this->con = $con;
      // this var returns all info from the user table
      $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$user'");
      // turning the results into an array
      $this->user = mysqli_fetch_array($user_details_query);
    }
    public function getFirstAndLastName() {
      $username = $this->user['username'];
      $query = mysqli_query($this->con, "SELECT first_name, last_name FROM users WHERE username='$username'");
      $row = mysqli_fetch_array($query);
      return $row['first_name'] . " " . $row['last_name'];
    }
    public function getUsername() {
      return $this->user['username'];
    }
    public function getNumPosts() {
      $username = $this->user['username'];
      $query = mysqli_query($this->con, "SELECT num_posts FROM users WHERE username='$username'");
      $row = mysqli_fetch_array($query);
      return $row['num_posts'];
    }
    public function isClosed() {
      $username = $this->user['username'];
      $query = mysqli_query($this->con, "SELECT user_closed FROM users WHERE username='$username'");
      $row = mysqli_fetch_array($query);
      if($row['user_closed'] == "yes")
        return true;
      else {
        return false;
      }
    }
  }
?>
