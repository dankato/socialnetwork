<?php 
    include("includes/header.php");

    if(isset($_GET['q'])) {
        $query = $_GET['q'];
    } else {
        $query = "";
    }
    if(isset($_GET['type'])) {
        $type = $_GET['type'];
    } else {
        $type = "name";
    }
?>

<div class='main_column column' id='main_column'>
<?php 
    if($query == "") {
        echo "You must enter something in the search field.";
    } else {

        // if query contains an underscore, assume user is searching for usernames
        if($type == "username") {
            $userReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE username LIKE '$query%' AND user_closed='no' LIMIT 8");
        } else {

            // split elements into an array
            $names = explode(" ", $query);

            if(count($names) == 3) {
                $userReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[2]%') AND user_closed='no'");
            }

            // if query has only 1 word, search first names or last names
            else if (count($names) == 2){
                $userReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' AND last_name LIKE '$names[1]%') AND user_closed='no'");
            } else {
                $userReturnedQuery = mysqli_query($con, "SELECT * FROM users WHERE (first_name LIKE '$names[0]%' OR last_name LIKE '$names[0]%') AND user_closed='no'");
            }
        }   

        // check if results were found
        if(mysqli_num_rows($userReturnedQuery) == 0) {
            echo "We can not find anyone with a " . $type . " like: " . $query;
        } else {
            echo mysqli_num_rows($userReturnedQuery) . " results found: <br> <br>";
        }

        echo "<p id='gray'>Try searching for:</p>";
        echo "<a href='search.php?q=" .$query . "&type=name'>Names</a>, <a href='search.php?q=" .$query . "&type=username'>Usernames</a><br><hr>";

        while($row = mysqli_fetch_array($userReturnedQuery)) {
            $user_obj = new User($con, $user['username']);
            $button = "";
            $mutual_friends = "";

            if($user['username'] != $row['username']) {
                // generate button depending on friend status
                if($user_obj->isFriend($row['username'])) {
                    $button = "<input type='submit' name='" . $row['username'] . "' class='danger' value='Remove Friend'>";
                } else if($user_obj->didReceiveRequest($row['username'])) {
                    $button = "<input type='submit' name='" . $row['username'] . "' class='warning' value='Respond to request'>";
                } else if($user_obj->didSendRequest($row['username'])) {
                    $button = "<input class='default' value='Request Sent'>";
                } else {
                    $button = "<input type='submit' name='" . $row['username'] . "' class='success' value='Add  Friend'>";
                }
                $mutual_friends = $user_obj->getMutualFriends($row['username']) . " friends in common";

                // button forms
            }

            echo "
                <div class='search_result'>
                    <div class='searchPageFriendButtons'>
                        <form action='' method='post'>
                            " . $button . " <br>
                        </form>
                    </div>

                    <div class='result_profile_pic'>
                        <a href='" . $row['username'] . "'>
                            <img src='" . $row['profile_pic'] . "' style='height: 100px;'>
                        </a>
                    </div>

                        <a href='" . $row['username'] . "'>
                            " . $row['first_name'] . " " . $row['last_name'] . "
                            <p id='gray'> " . $row['username'] . "</p>
                        </a>
                        <br>
                        " . $mutual_friends . "
                        <br>
                    
                </div>
                <hr>
            ";
        } // end of while loop
    }
?>

</div>