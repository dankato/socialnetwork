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

        // insert Post
        $query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$body', '$added_by', '$user_to', '$date_added', 'no', 'no', '0')");
        // return post id just submitted
        $return_id = mysqli_insert_id($this->con);
        // insert notifs

        // update post count for user
        $num_posts = $this->user_obj->getNumPosts();
        $num_posts++;
        $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");
      }
    }

    public function loadPostsFriends() {
      $string = "";
      $data = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no', ORDER BY id DESC");
      while($row = mysqli_fetch_array($data)) {
        $id = $row['id'];
        $body = $row['body'];
        $added_by = $row['added_by'];
        $date_time = $row['date_added'];

        // prepare user_to string so it can be included, even if not posted to a user
        if($row['user_to'] == "none") {
          $user_to = "";
        } else {
          $user_to_obj = new User($con, $row['user_to']);
          $user_to_name = $user_to_obj->getFirstAndLastName();
          $user_to = "<a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";

          // check if user who posted, has their account closed, don't show their posts
          $added_by_obj = new User($con, $added_by);
          if($added_by_obj->isClosed()) {
            continue;
          }
          $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
          $user_row = mysqli_fetch_array($user_details_query);

          // timeframe
          $date_time_now = date("Y-m-d H:i:s");
          $start_date = new DateTime($date_time); // time of post
          $end_date = new DateTime($date_time_now); // current time
          $interval = $start_date->diff($end_date); // difference between dates
          if($interval->y >= 1) { // if 1 year ago or over
            if($interval == 1)
              $time_message = $interval->y . " year ago.";
            else {
              $time_message = $interval-> y . " years ago";
            }
          }
          else if($interval->m >= 1) {
            if($interval->d == 0) {
              $days = " ago.";
            }
            else if($interval->d == 1) {
              $days = $interval->d . " day ago.";
            }
            else {
              $days = $interval->d . " days ago.";
            }
            if($interval->m == 1) {
              $time_message = $interval->m . " month". $days;
            } else {
              $time_message = $interval->m . " months". $days;
            }
          }
          else if($interval->d >= 1) {
            if($interval->d == 1) {
              $time_message = "Yesterday.";
            }
            else {
              $time_message = $interval->d . " days ago.";
            }
          }
          else if($interval->h >= 1) {
            if($interval->h == 1) {
              $time_message = $interval->d . " hour ago.";
            }
            else {
              $time_message = $interval->h . " hours ago.";
            }
          }
          else if($interval->i >= 1) {
            if($interval->i == 1) {
              $time_message = $interval->i . " minute ago.";
            }
            else {
              $time_message = $interval->i . " minutes ago.";
            }
          }
          else {
            if($interval->s > 30) {
              $time_message = "Just now.";
            }
            else {
              $time_message = $interval->s . " seconds ago.";
            }
          }
        }
      }
    }
  }
?>
