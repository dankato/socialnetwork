<?php
  require 'config/config.php';
  include('includes/classes/User.php');
  include('includes/classes/Post.php');
  include('includes/classes/Message.php');
  include('includes/classes/Notification.php');

  // prevent users to access site without logging in first
  if (isset($_SESSION['username'])) {
    $userLoggedIn = $_SESSION['username'];
    $user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
    $user = mysqli_fetch_array($user_details_query);
  } else {
    header("Location: register.php");
  }
?>

<html>
  <head>
    <meta charset="utf-8">
    <title>Social Network</title>
    <link href="https://fonts.googleapis.com/css?family=Josefin+Sans:400,400i,600,600i,700,700i" rel="stylesheet">
    <!-- css -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/css/style.css">
    <script src="https://use.fontawesome.com/8f99050c9f.js"></script>
    <link rel="stylesheet" href="assets/css/jquery.Jcrop.css" type="text/css" />
    <!-- jquery/js -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootbox.js/4.4.0/bootbox.min.js"></script>
    <script type="text/javascript" src="assets/js/main.js"></script>
    <script src="assets/js/jquery_jcrop.js"></script>
    <script src="assets/js/jcrop_bits.js"></script>
  </head>
  <body>

    <div class="top_bar">
      <div class="logo">
        <a href="index.php">Social Network</a>
      </div>
      <nav>
        <?php
          $messages = new Message($con, $userLoggedIn);
          $num_messages = $messages->getUnreadNumber();
        ?>

        <a href="<?php echo $userLoggedIn; ?>"><?php echo $user['first_name']; ?></a>
        <a href="index.php"><i class="fa fa-home" aria-hidden="true"></i></a>
        <a href="javascript:void(0);" onclick="getDropdownData('<?php echo $userLoggedIn; ?>', 'message')">
          <i class="fa fa-comment-o" aria-hidden="true"></i>
          <?php
            if($num_messages > 0)
              echo '<span class="notification_badge" id="unread_message">' . $num_messages . '</span>';
          ?>
        </a>

        <a href="#"><i class="fa fa-exclamation" aria-hidden="true"></i></a>
        <a href="requests.php"><i class="fa fa-users" aria-hidden="true"></i></a>
        <a href="#"><i class="fa fa-cog" aria-hidden="true"></i></a>
        <a href="includes/handlers/logout.php"><i class="fa fa-sign-out" aria-hidden="true"></i></a>
      </nav>
      <div class="dropdown_data_window" style="height: 0px; border: none;"></div>
      <input type="hidden" id="dropdown_data_type" value="">

    </div>

    <script>
      var userLoggedIn = '<?php echo $userLoggedIn; ?>';

      // making call, page is currently 1, data is $_REQUEST
      $(document).ready(function() {

        $('.dropdown_data_window').scroll(function() {
          var inner_height = $('.dropdown_data_window').innerHeight();
          var scroll_top = $('.dropdown_data_window').scrollTop();
          var page = $('.dropdown_data_window').find('.nextPageDropdownData').val();
          var noMoreData = $('.dropdown_data_window').find('.noMoreDropdownData').val();

          if((scroll_top + inner_height >= $('.dropdown_data_window')[0].scrollHeight) && noMoreData == 'false') {
            // holds name of page to send to ajax request to
            var pageName;
            var type = $('#dropdown_data_type').val();

            if(type == 'notification')
              pageName = "ajax_load_notifications.php";
            else if (type = 'message')
              pageName = "ajax_load_messages.php"

            var ajaxReq = $.ajax({
              url: "includes/handlers/" + pageName,
              type: "POST",
              data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
              cache: false,
              success: function(response) {
                $('.dropdown_data_window').find('.nextPageDropdownData').remove();
                $('.dropdown_data_window').find('.noMoreDropdownData').remove();
                $('.dropdown_data_window').append(response);
              }
            })
          }; // end of if
          return false;
        });
      });
    </script>


    <div class="wrapper">
