<?php
    session_start();
 

    // Include and call function to connect to db
    include_once 'components/dbConnection.php';
    $connection = getConnection();

    // Output error message if connection unsuccessful.
    if (mysqli_connect_errno() || $connection === false){
        die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
    }

?>
<html>
<head>
    <title>Marketplace Home</title>
    <?php include_once("components/imports.php") ?>
</head>
<body>
<?php include('components/header.php')?>
    <h1 class="indexTitle">All Listings:</h1>

    <div class = "grid">
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
                    echo '<div class ="listingTile">';
                    echo '<img class="listingImage" onclick="window.location.href=\'viewListing.php?whichListing='.$listingid.'\'" src="'. $image .'" alt="listing">';
                    echo '<div class="listingText">';
                    echo '<h3 class="listingHeader"><a class="gridLink" href = "viewListing.php?whichListing='.$listingid.'">'.$title.'</a></h3>';
                    echo '<h4 class="listingHeader">Posted By: <a href = "userProfile.php?user=' . $userid . '">'.$username.'</a></h4>';
                    echo '</div></div>';
                }
            }
            else{
                echo '<h1> ERROR: COULD NOT FETCH LISTINGS!</h1>';
            }
        ?>
    </div>
</body>
</html>
