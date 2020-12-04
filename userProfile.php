<?php
session_start();
// Checks if user is logged in.
include 'checkSessionID.php';
$viewerID = $_SESSION['sessionID'];

$iniConfig = parse_ini_file("php.ini");

//Establishing connection
include_once 'components/dbConnection.php';
$connection = getConnection();

// Obtain's the userid of the user to be loaded from link userProfile.php?user=#
if(isset($_GET['user'])){
    $userid = $_GET['user'];
    
    // Get user details based on their userid
    $query="SELECT * FROM user WHERE id= '$userid'";
    $qresult = mysqli_query($connection, $query);

    // Obtains the data contained for the matching table row to retrieve username using mysqli.
    $row = mysqli_fetch_array($qresult, MYSQLI_ASSOC);
    $username = $row['username'];

}

?>
<html>
<head>
    <title>User: <?php echo 'User Profile: '.$username  ?></title>
    <?php include_once("components/imports.php") ?>
</head>
<body>
<?php include('header.php')?>

    <div id="user information">
        <h1><?php echo $username  ?></h1>
    </div>

    <div id="userlistings">
        <h1>Listings: </h1>
        <!--Creates series of links for every listing with the listing id in the link so that they can be received with GET in listing.php -->
        <?php
            $counter = 0;
            $query="SELECT * FROM listing WHERE userid= '$userid';";
            $qresult = mysqli_query($connection, $query);

            while($row = mysqli_fetch_array($qresult, MYSQLI_ASSOC)){
                $listingid = $row['id'];
                $title = $row['title'];

                echo '<h3><a href = "viewListing.php?whichListing='.$listingid.'">'.$title.'</a></h3>';

                // Shows delete listing button if the profile belongs to the viewer
                if ($userid == $viewerID){
                    echo '<input type="button" class="delbtn" value ="Delete Listing" onclick="window.location.href=\'deletelisting.php?listingid='.$listingid.'\'"><br>';
                }
            }
        ?>

    </div>

</body>
</html>
