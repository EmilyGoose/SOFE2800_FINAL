<?php

// Include and call function to connect to db
include_once 'components/dbConnection.php';
$conn = getConnection();

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
//link to get back to index page
echo "<a href=\"index.php\">Click here to go to index.php</a>" ."<br>";

session_start();
//echo "session id is: ". $_SESSION['sessionID']."<br>";

// Get post request variables
$listingid = $_POST["listingid"];
//echo $listingid;

$query="SELECT * FROM listing WHERE id= '$listingid';";
$qresult = $conn->query($query);

// Obtains the data contained for the matching table row.
$row = mysqli_fetch_array($qresult, MYSQLI_ASSOC);
$listingTitle = $row['title'];
$description = $row['description'];
$image = $row['image'];
$userid = $row['userid'];


$query="SELECT username FROM user WHERE id= '$userid';";
$qresult = mysqli_query($conn,$query);

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
<?php include('header.php')?>
    <h1>Make an offer on <?php echo $listingTitle ?></h1>
    <form action="checkOffer.php" method="post">
        <input type="text" name="fromUserid" value="<?php echo $_SESSION['sessionID'] ?>" style="display: none">
        <input type="text" name="toUserid" value="<?php echo $userid ?>" style="display: none">
        <input type="text" name="listingid" value="<?php echo $listingid ?>"style="display: none">

        <label for="contact">Enter Contact Information</label>
        <input type="text" name="contact" value="">
        <br>
        <label for="offerdesc">Describe your offer</label>
        <textarea name="offerdesc" id="" cols="30" rows="10">Enter a description of your offer here.</textarea>
        <input type="submit">



    </form>
</body>
</html>
