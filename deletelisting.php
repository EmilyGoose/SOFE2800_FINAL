<?php
    session_start();
    include 'checkSessionID.php';
    $viewerID = $_SESSION['sessionID'];

    $iniConfig = parse_ini_file("php.ini");

    //Establishing server connection
    $servername = $iniConfig["ip"];
    $dbusername = $iniConfig["user"];
    $password = $iniConfig["password"];
    $dbname = $iniConfig["database"];
    $connection = mysqli_connect ($servername, $dbusername, $password, $dbname);

    // Output error message if connection unsuccessful.
    if (mysqli_connect_errno() || $connection === false){
        die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
    }

    include('header.php');

    if(isset($_GET['listingid'])){
        $listingid = $_GET['listingid'];

        // Makes sure the offer to be deleted is the same as the passed id and the toUser is the same as the viewing user.
        $query="DELETE FROM offer WHERE listingid= '$listingid' AND toUserid = '$viewerID';";
        $qresult = mysqli_query($connection, $query);

        // Print out success message (I am not sure if my condition is correct?)
        if ($qresult){
            echo '<h2>Associated offers were deleted successfully </h2><br>';

            // Tries to delete listing if offer to be deleted is the same as the passed id and the toUser is the same as the viewing user.
            $query="DELETE FROM listing WHERE id= '$listingid' AND userid = '$viewerID';";
            $result = mysqli_query($connection, $query);

            // Print out success message (again, not sure if my condition is correct)
            if ($result){
                echo '<h1>Listing deleted successfully. </h1>';
                echo '<a href="userProfile.php?user=' . $viewerID . '">Click here to return to your profile</a>';
            }
            // Print out could not complete message
            else{
                echo '<h1>Uh oh, something went wrong! Listing could not be deleted. </h1>';
                echo '<a href="userProfile.php?user=' . $viewerID . '">Click here to return to your profile</a>';
            }
        }
    }
    // Could not delete offers redirect
    else{
        echo '<h1>Listing was not deleted successfully.</h1>';
        echo '<a href="userProfile.php?user=' . $viewerID . '">Click here to return to your profile</a>';
    }
?>