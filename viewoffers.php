<?php
session_start();
include 'checkSessionID.php';
$viewerID = $_SESSION['sessionID'];

$iniConfig = parse_ini_file("php.ini");

//Establishing connection
include_once 'components/dbConnection.php';
$connection = getConnection();

// Output error message if connection unsuccessful.
if (mysqli_connect_errno() || $connection === false){
    die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
}

?>
<html>
    <head>
        <title>View Your Offers</title>
        <?php include_once("components/imports.php"); ?>
    </head>
    <body>
    <?php include('header.php')?>

    <div id = "useroffers">
            <h1>Your Received Offers:</h1>
            <?php
                $counter = 0;
                // Fetches all offers from table to display sequentially
                $query="SELECT * FROM offer WHERE toUserid = '$viewerID';";
                $qresult = mysqli_query($connection, $query);

                if(mysqli_num_rows($qresult) == 0){
                    echo '<h2 id = "acceptmsg">You have no offers!</h2>';
                }
                else {
                    echo '<p id = "acceptmsg">To accept an offer, contact the other party!  Please delete the offer once you have contacted them.</p>';


                    // Prints results from row fetch and prints sequentially
                    while ($row = mysqli_fetch_array($qresult, MYSQLI_ASSOC)) {
                        $counter++;
                        $offerid = $row['id'];
                        $listingid = $row['listingid'];
                        $offerer = $row['fromUserid'];
                        $contact = $row['contact'];
                        $offerdesc = $row['offerdesc'];

                        // Obtains title of the post from the listing table.
                        $query = "SELECT * FROM listing WHERE id = '$listingid';";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $title = $row['title'];

                        // Obtains the name of the offerer from the user table.
                        $query = "SELECT * FROM user WHERE id = '$offerer';";
                        $result = mysqli_query($connection, $query);
                        $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                        $offerName = $row['username'];

                        echo '<h2> Offer ' . $counter . ':</h2>';
                        echo '<h3><a href = "Listing.php?whichListing=' . $listingid . ' ">' . $title . '</a></h3>';
                        echo '<h3>Offer made by: ' . $offerName . '</h3><h3> Contact information: ' . $contact . '</h3>';
                        echo '<h4><b> Offer Description: <b>' . $offerdesc . '</h4>';
                        // Prints out button that allows user to delete offer corresponding with offerid.
                        echo '<input type = "button" class="delbtn" value ="Delete Offer" onclick="deleteoffer.php?offerid=' . $offerid . '"><br>';
                    }
                }
            ?>
        </div>
    </body>
</html>