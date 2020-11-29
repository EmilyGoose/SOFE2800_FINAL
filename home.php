<?php
session_start();
echo "<a href=\"Listing.php\">Click here to go to Listing.php page</a>" ."<br>";
echo "<a href=\"userProfile.php\">Click here to go to your userProfile.php page</a>" ."<br>";

?>

<html>
<head>
    <title>Marketplace Home</title>
</head>
<body>
    <div>
        <form id="userLinks" method="post" action="userProfile.php">
            <input type="text" name="userProfile" value="<?php echo $_SESSION['sessionID'] ?>" hidden>
            <button onclick="form['userLinks'].submit()" value="Your Profile">Your profile</button>
        </form>
    </div>
</body>
</html>
