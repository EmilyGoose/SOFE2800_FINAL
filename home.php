<?php
    session_start();
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
    <title>Marketplace Home</title>
    <link rel="stylesheet" type="text/css" href="style/global.css">
</head>
<body>
    <div class = "homeheader">
        <!-- Put the header in here -->
        <?php include('header.php')?>
        <!--old header links
        <div>
            <a href="index.php">Click here to go to index.php</a>
            <a href="userProfile.php?user=<?php echo $_SESSION['sessionID'] ?>">Click here to go to your profile page</a>
            <br>
            <a href="makeListing.php">Click here to go to Make a Listing</a>
        </div>
        -->
    </div>
    <div class = "tiledlistings">
        <?php
            // Gets all listings in table
            $query="SELECT * FROM listing;";
            $qresult = mysqli_query($connection, $query);
    
            // Print out each listing
            if ($qresult){
                while($row = mysqli_fetch_array($qresult, MYSQLI_ASSOC)){
                    $listingid = $row['id'];
                    $title = $row['title'];
                    $image = $row['image'];
                    $userid = $row['userid'];

                    $userquery = "SELECT * FROM user WHERE id = '$userid';";
                    $result = mysqli_query($connection, $userquery);
                    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
                    $username = $row['username'];
                    
                    // Prints each listing in it's own div for flexboxes
                    echo '<div class ="listingtile">';
                    echo '<img src="'. $image .'" alt="listing">';
                    echo '<h3><a href = "Listing.php?whichListing='.$listingid.'">'.$title.'</a></h3>';
                    echo '<h4>Posted By: <a href = userProfile.php?user=' . $userid . '">'.$username.'</a></h4>';
                    echo '</div>';
                }
            }
            else{
                echo '<h1> ERROR: COULD NOT FETCH LISTINGS!</h1>';
            }
        ?>
    </div>
</body>
</html>
