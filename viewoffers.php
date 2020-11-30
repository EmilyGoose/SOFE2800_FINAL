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

?>
<html>
    <head>
        <title></title>
    </head>
    <body>
        <div id = "useroffers">
            <h1>Your Offers:</h1>
            <!-- Small message telling user to delete offers where appropriate.  Prevents need for user-user messaging -->
            <p id = "acceptmsg">To accept an offer, contact the other party!  Please delete the offer once you have contacted them.</p>
            <?php
                $counter = 0;
                // Fetches all offers from table to display sequentially
                $query="SELECT * FROM offer WHERE toUserid = '$viewerID';";
                $qresult = mysqli_query($connection, $query);
                
                // Prints results from row fetch and prints sequentially
            while($row = mysqli_fetch_array($qresult, MYSQLI_ASSOC)){
                    $counter++;
                    $offerid = $row['id'];
                    $listingid = $row['listingid'];
                    $title = $row['title'];
                    $offerer = $row['fromUserid'];
                    $contact = $row['contact'];
                    $offerdesc = $row['offerdesc'];
                    echo '<h2> Offer '.$counter.':</h2><br>';
                    echo '<h3><a href = "Listing.php?whichListing='.$listingid.' ">'.$title.'<a/></h3><br>';
                    echo '<h3>Offer made by: '. $offerer . ', Contact information: ' . $contact . '</h3><br>';
                    echo '<h4><b> Offer Description: <b>' . $offerdesc . '</h4><br>';
                    // Prints out button that allows user to delete offer corresponding with offerid.
                    echo '<input type = \"button\" id=\"delbtn' . $counter . '\" value =\"Delete Offer\" onclick=\"deleteoffer.php?offerid=' . $offerid .'\">';
                }
            ?>
        </div>
    </body>
</html>