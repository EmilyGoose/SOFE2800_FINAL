<?php
session_start();
?>

<html>
<head>
    <title>Marketplace Home</title>
</head>
<body>
    <a href="index.php">Click here to go to index.php</a>
    <div>
        <a href="userProfile.php?user=<?php echo $_SESSION['sessionID'] ?>">Click here to go to your profile page</a>
        <br>
        <a href="makeListing.php">Click here to go to Make a Listing</a>
    </div>
</body>
</html>
