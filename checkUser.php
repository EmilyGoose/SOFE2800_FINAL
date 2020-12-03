<?php
// Include and call function to connect to db
include_once 'components/dbConnection.php';
$conn = getConnection();

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//link to get back to login page
echo "<a href=\"index.php\">Click here to go to index.php</a>" ."<br>";

session_start();
//echo "session id is: ". $_SESSION['sessionID']."<br>";

// Get post request variables
//$email = $_POST["email"];
$password =  $_POST["password"];
$mode = $_POST["mode"];
//$firstName = $_POST["firstName"];
//$lastName = $_POST["lastName"];
$username = $_POST["username"];

// Make a sql query to see if the user exists (This is useful for both login and signup)
$sql = "SELECT username FROM user WHERE username = '$username';";
if (mysqli_query($conn, $sql) -> num_rows >0){
    $userExists = true;
}else{
    $userExists = false;
}

if ($mode == "login") {
    // Make sure the user exists
    if ($userExists) {

        // Get a user matching the email/password pair
        $sql = "SELECT username ,id FROM user WHERE username = '$username' AND passwordHash = '$password';";
        $result = mysqli_query($conn, $sql);
        // If nothing was returned, the password is wrong
        if ($result->num_rows == 0) {
            echo "Wrong password!";
        } else {
            while ($row = $result->fetch_assoc()) {
                echo "Welcome ".$row['username']."<br>";
                $_SESSION['sessionID'] = $row['id'];
                //echo "your User id is ".$row['id']."<br>" ."session id is the same: ".$_SESSION['sessionID'];
                header("Location:home.php");

            }
        }
    } else {
        echo "User not found! Check your email address and try again.";
    }
} else if ($mode == "signup") {
    // Check if the user exists
    if ($userExists) {
        echo "A user already exists with that username";
    } else {
        // Insert the new info into the database
        $sql = "INSERT INTO user (username, passwordHash) VALUES ('$username','$password');";
        mysqli_query($conn, $sql);
        echo "Successfully created new user. Please log in.";
    }
}
