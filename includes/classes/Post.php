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
        $returned_id = mysqli_insert_id($this->con);
        // insert notifs

        // update post count for user
        $num_posts = $this->user_obj->getNumPosts();
        $num_posts++;
        $update_query = mysqli_query($this->con, "UPDATE users SET num_posts='$num_posts' WHERE username='$added_by'");
      }
    }

    public function loadPostsFriends($data, $limit) {

      $page = $data['page'];
      $userLoggedIn = $this->user_obj->getUsername();
      if($page == 1)
        $start = 0; // starting point
      else
        $start = ($page - 1) * $limit;


      $str = "";
      $data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' ORDER BY id DESC");

      if(mysqli_num_rows($data_query) > 0) {
          $num_iterations = 0; // number of results checked
          $count = 1;

        // echo "before the while<br>";
        while($row = mysqli_fetch_array($data_query)) {
          // echo "inside the while<br>";
          $id = $row['id'];
          $body = $row['body'];
          $added_by = $row['added_by'];
          $date_time = $row['date_added'];

          // prepare user_to string so it can be included, even if not posted to a user
          if($row['user_to'] == "none") {
            $user_to = "";
          }
          else {
            $user_to_obj = new User($con, $row['user_to']);
            $user_to_name = $user_to_obj->getFirstAndLastName();
            $user_to = "to <a href='" . $row['user_to'] . "'>" . $user_to_name . "</a>";
          }
            // check if user who posted, has their account closed, don't show their posts
          $added_by_obj = new User($this->con, $added_by);
            if($added_by_obj->isClosed()) {
              continue;
          }

          $user_logged_obj = new User($this->con, $userLoggedIn);
          if($user_logged_obj->isFriend($added_by)) {
              if($num_iterations++ < $start)
                continue;

              // once 10 posts have been loaded, break
              if($count > $limit) {
                break;
              } else {
                $count++;
              }

              $user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
              $user_row = mysqli_fetch_array($user_details_query);
              $first_name = $user_row['first_name'];
              $last_name = $user_row['last_name'];
              $profile_pic = $user_row['profile_pic'];


              ?>
              <script>
                function toggle<?php echo $id; ?>() {

                  var element = document.getElementById("toggleComment<?php echo $id; ?>");
                  if(element.style.display == "block") {
                    element.style.display = "none";
                  } else {
                    element.style.display = "block";
                  }
                }
              </script>

              <?

              // timeframe
              $date_time_now = date("Y-m-d H:i:s");
              $start_date = new DateTime($date_time); // time of post
              $end_date = new DateTime($date_time_now); // current time
              $interval = $start_date->diff($end_date); // difference between dates
              if($interval->y >= 1) { // if 1 year ago or over
                if($interval == 1)
                  $time_message = $interval->y . " year ago.";
                else {
                  $time_message = $interval->y . " years ago";
                }
              }
              else if($interval-> m >= 1) {
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
                  $time_message = $interval->h . " hour ago.";
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
                if($interval->s < 30) {
                  $time_message = "Just now.";
                }
                else {
                  $time_message = $interval->s . " seconds ago.";
                }
              }
              $str .= "<div class='status_post' onClick='javascript:toggle$id()'>
    								<div class='post_profile_pic'>
    									<img src='$profile_pic' width='50'>
    								</div>

    								<div class='posted_by' style='color:#ACACAC;'>
    									<a href='$added_by'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
    								</div>
    								<div id='post_body'>
    									$body
    									<br>
    								</div>

    							</div>
                  <div class='post_comment' id='toggleComment$id' style='display:none;'>
                    <iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
                  </div>
    							<hr>";
            };
          }

          if($count > $limit)
            $str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
              <input type='hidden' class='noMorePosts' value='false'>";
          else {
            $str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: center;'>No more posts to show.</p>";
          }
        }
        echo $str;
      }

    }

?>