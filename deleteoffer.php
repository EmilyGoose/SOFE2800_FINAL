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
    $connection = mysqli_connect($servername, $dbusername, $password, $dbname);

    // Output error message if connection unsuccessful.
    if (mysqli_connect_errno() || $connection === false){
        die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
    }
    

    if(isset($_GET['offerid'])){
        $offerid = $_GET['offerid'];

        // Makes sure the offer to be deleted is the same as the passed id and the toUser is the same as the viewing user.
        $query="DELETE * FROM offer WHERE id= '$offerid' AND toUserid = '$viewerID';";
        $qresult = mysqli_query($connection, $query);
        
        // Print out success message (I am not sure if my condition is correct?)
        if ($qresult){
            echo '<h1> Offer deleted successfully. </h1>';
            echo '<a href="viewoffers.php">Click here to return to your offers</a><br>';
        }
        // Print out could not complete message
        else{
            echo '<h1>Offer was not deleted successfully.</h1><';
            echo '<a href="viewoffers.php">Click here to return to your offers</a>';
        }
    }
?>