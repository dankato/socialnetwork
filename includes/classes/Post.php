<?php
  class Post {
    // global vars
    private $user_obj;
    private $con;
    // constructors
    public function __construct($con, $user) {
      $this->con = $con;
      // creating an instance of the user class
      $this->user_obj = new User($con, $user);
    }
    public function submitPost($body, $user_to) {
      // remove html tags
      $body = strip_tags($body);
      // escaping single quote so it won't break db query
      $body = mysqli_real_escape_string($this->con, $body);
      // is post empty?, delete all spaces
      $check_empty = preg_replace('/\s+/', '', $body);
      if($check_empty != "") {
        // current date and time$
        $date_added = date("Y-m-d H:i:s");
        // get username
        $added_by = $this->user_obj->getUsername();

        // if user is on own profile, user_to is 'none'.
        if($user_to == $added_by) {
          $user_to = "none";
        }
      }
    }

  }
?>
