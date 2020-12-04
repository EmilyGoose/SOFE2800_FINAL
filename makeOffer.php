<?php

// Include and call function to connect to db
include_once 'components/dbConnection.php';
$conn = getConnection();

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

session_start();

$error = "";

// Get post request variables
$listingid = $_POST["listingid"];

// If offerdesc is set this is a request to create an offer
if (isset($_POST["offerdesc"])) {

    // Get post request variables
    $fromUserid = $_POST["fromUserid"];
    $toUserid = $_POST["toUserid"];
    $listingid = $_POST["listingid"];
    $contact = $_POST["contact"];
    $offerdesc = $_POST["offerdesc"];

    //check for escape strings
    $contact = $conn->real_escape_string($contact);
    $offerdesc = $conn->real_escape_string($offerdesc);


    // Make a sql query to see if the offer was already made
    $sql = "SELECT id FROM offer WHERE fromUserid = '$fromUserid' AND listingid = '$listingid';";
    if (mysqli_query($conn, $sql)->num_rows > 0) {
        $offerExists = true;
    } else {
        $offerExists = false;
    }
    //if the offer was already made don't make another one
    if ($offerExists == true) {
        // Redirect back to form with error
        $error = "You have already made an offer for this listing!";
    } else {
        $sql = "INSERT INTO offer (fromUserid, toUserid, listingid,contact,offerdesc) VALUES ('$fromUserid','$toUserid','$listingid','$contact','$offerdesc');";
        mysqli_query($conn, $sql);
        // Redirect to sent offers
        header("Location: viewSentOffers.php");
        die();
    }
}

// Creates query to retrieve appropriate listing from database.
$query = "SELECT * FROM listing WHERE id= '$listingid';";
$qresult = $conn->query($query);

// Obtains the data contained for the matching table row.
$row = mysqli_fetch_array($qresult, MYSQLI_ASSOC);
$listingTitle = $row['title'];
$description = $row['description'];
$image = $row['image'];
$userid = $row['userid'];

// Creates query to retrieve associated user's username
$query = "SELECT username FROM user WHERE id= '$userid';";
$qresult = mysqli_query($conn, $query);

// Obtains the data contained for the matching table row using mysqli.
$row = mysqli_fetch_array($qresult, MYSQLI_ASSOC);
$postingUsername = $row['username'];

?>

<html>
<head>
    <title>Make an offer: <?php echo $listingTitle ?></title>
    <?php include_once("components/imports.php"); ?>
</head>
<body>
<?php include('components/header.php')?>
<div class="pageContent">
    <h1>Make an offer on <?php echo $postingUsername ?>'s <?php echo $listingTitle ?></h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        <input type="text" name="fromUserid" value="<?php echo $_SESSION['sessionID'] ?>" style="display: none">
        <input type="text" name="toUserid" value="<?php echo $userid ?>" style="display: none">
        <input type="text" name="listingid" value="<?php echo $listingid ?>"style="display: none">

        <label for="contact">Enter Contact Information</label>
        <input type="text" name="contact" value="">
        <br>
        <label for="offerdesc">Describe your offer</label>
        <textarea name="offerdesc" placeholder="Enter a description of your offer here." id="" cols="30" rows="10"></textarea>
        <input type="submit">
        <p class="error"><?php echo $error ?></p>
        </form>
</div>
</body>
</html>
