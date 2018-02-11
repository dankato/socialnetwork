<?php 
    include("includes/header.php");
    include("includes/form_handlers/settings_handler.php");
?>

<div class="main_column column">
    <h4>Account Settings</h4>
    <?php 
        echo "<img src='" . $user['profile_pic'] . "' id='small_profile_pics'>";
    ?>
    <br>
    <a href="upload.php">Upload a new profile picture.</a>
    <br><br><br>

    <h3>Modify the values and click 'Update Details'</h3>

    <?php 
        $user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE username='$userLoggedIn'");
        $row = mysqli_fetch_array($user_data_query);

        $first_name = $row['first_name'];
        $last_name = $row['last_name'];
        $email = $row['email'];

    ?>


    <h4>User Info</h4>
    <form action="settings.php" method="post">
        First Name: <input type="text" name="first_name" value="<?php echo $first_name; ?>"><br>
        Last Name: <input type="text" name="last_name" value="<?php echo $last_name; ?>"><br>
        Email: <input type="text" name="email" value="<?php echo $email; ?>"><br>

        <?php 
            echo $message;
        ?>

        <input type="submit" name="update_details" id="save_details" value="Update Info">
    </form>

    <h4>Change Password</h4>
    <form action="settings.php" method="post">
        Old Password: <input type="password" name="old_password"><br>
        New Password: <input type="password" name="new_password1"><br>
        New Password: <input type="password" name="new_password2"><br>
        <input type="submit" name="update_password" id="save_details" value="Update Password">
    </form>

    <h4>Close Account</h4>
    <form action="settings.php">
        <input type="submit" name="close_account" id="close_account" value="Close Account">
    </form>

</div>