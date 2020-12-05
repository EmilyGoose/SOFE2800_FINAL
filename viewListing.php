<?php
session_start();
// Checks if user is logged in (session id set)
// include 'checkSessionID.php';

if (isset($_SESSION["sessionID"])) {
    $loggedIn = true;
} else {
    $loggedIn = false;
}

// Get session user's id
if ($loggedIn == true) {
    $viewerid = $_SESSION['sessionID'];
} else {
    $viewerid = null;
}


// Include and call function to connect to db
include_once 'components/dbConnection.php';
$connection = getConnection();

// Output error message if connection unsuccessful.
if (mysqli_connect_errno() || $connection === false) {
    die("Database connection failed: " . mysqli_connect_error() . "(" . mysqli_connect_errno() . ")");
}

// Post request means we've updated a listing
if ($_SERVER["REQUEST_METHOD"] == "POST" and isset($_POST['whichListing']) and isset($_POST['newText'])) {
    $newText = $_POST['newText'];
    $whichListing = $_POST['whichListing'];

    // Make sure we have the right user
    $userQuery = "SELECT userId FROM listing WHERE id= '$whichListing'";
    $result = $connection->query($userQuery);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    // Only run the update for own listing
    if ($row['userId'] == $viewerid) {
        $newText = $connection->real_escape_string($newText);
        $query = "UPDATE listing SET description='$newText' WHERE id= '$whichListing'";
        $connection->query($query);
    }


}


// Gets id of listing to be displayed from post stream <- NEEDS TO BE PARAM REQUEST FOR LISTING ID
// Need to check both get and post depending on how we got to the page
if (isset($_GET['whichListing']) or isset($_POST['whichListing'])) {
    $listingId = "";
    if (isset($_GET['whichListing'])) {
        $listingId = $_GET['whichListing'];
    } else {
        $listingId = $_POST['whichListing'];
    }
    $query = "SELECT * FROM listing WHERE id= '$listingId'";
    $qresult = $connection->query($query);

    // Obtains the data contained for the matching table row.
    $row = mysqli_fetch_array($qresult, MYSQLI_ASSOC);
    $title = $row['title'];
    $description = $row['description'];
    $image = $row['image'];
    $userid = $row['userid'];


    $query = "SELECT username FROM user WHERE id= '$userid';";
    $qresult = mysqli_query($connection, $query);

    // Obtains the data contained for the matching table row using mysqli.
    $row = mysqli_fetch_array($qresult, MYSQLI_ASSOC);
    $postingUsername = $row['username'];

}
?>
<html>
<head>
    <title> <?php echo 'Listing: ' . $title ?> </title>
    <?php include_once("components/imports.php"); ?>
    <script type="text/javascript" src="components/editListing.js"></script>
    <script type="text/javascript">
        // Listener for button to redirect to offer page if clicked
        document.getElementById("offerbtn").onclick = function () {
            location.href = 'offer.php';
        }
    </script>
</head>
<body>
<?php include('components/header.php') ?>
<div class="pageContent">
    <div id="postHeader">
        <h1><?php echo $title ?></h1>
        <h3>Posted By:
            <?php
            echo '<a href="userProfile.php?user=' . $userid . '">' . $postingUsername . '</a></h3>';
            ?>
    </div>
    <div class="postContent">
        <div id="imgdisplay">
            <img class="listingBigImage" src="<?php echo $image ?>" alt="poster's image">
        </div>
        <div class="postBody">
            <h3 style="margin-top: 0;">Item Description:</h3>
            <p id="itemDesc"><?php echo $description ?></p>
            <!-- Form for editing the listing. Permissions are validated on post. -->
            <form id="editForm" method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                <input type="text" style="display: none;" name="whichListing" value="<?php echo $listingId ?>">
                <textarea name="newText" cols="50" rows="3" id="editBox"
                          style="display:none;"><?php echo $description ?></textarea>
            </form>
            <div class="buttonRow">
                <!-- Hides button (adds hidden class) if user viewing is same as posting user -->
                <div id="offer" <?php if (($loggedIn == false) or ($userid == $viewerid)) {
                    echo 'style="display: none"';
                } ?>>
                    <form name="offer" action="makeOffer.php" method="post">
                        <input type="text" name="listingid" value="<?php echo $listingId; ?>" style="display: none">
                        <input type="button" onclick="forms['offer'].submit()" class="actionButton"
                               value="Make an Offer!">
                    </form>
                </div>
                <?php
                // If the listing creator is viewing give them an option to delete and edit
                if ($userid == $viewerid) {
                    // Edit button
                    echo '<input type="button" class="actionButton" id="editButton" value="Edit Listing" onclick="editListing()">';
                    // Delete button
                    echo '<input type="button" class="actionButton" value ="Delete Listing" onclick="window.location.href=\'deletelisting.php?listingid=' . $listingId . '\'">';
                }
                ?>
            </div>
        </div>
    </div>


</div>
</body>
</html>