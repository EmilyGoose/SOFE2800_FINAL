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
        <form id="userLinks" method="post" action="userProfile.php">
            <input type="text" name="postUserid" value="<?php echo $_SESSION['sessionID'] ?>" hidden>
            <button onclick="form['userLinks'].submit()" value="Your Profile">Your profile</button>
        </form>

        <a href="makeListing.php">Click here to go to Make a Listing</a>
    </div>
</body>
</html>
