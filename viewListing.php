<?php
    session_start();
    // Checks if user is logged in (session id set)
   // include 'checkSessionID.php';

    if(isset($_SESSION["sessionID"])) {
        $loggedIn = true;
    }else{
        $loggedIn = false;
    }

    echo $loggedIn;

    // Get session user's id
    if ($loggedIn == true){
        $viewerid = $_SESSION['sessionID'];
    }else{
        $viewerid =null;
    }


    // Include and call function to connect to db
    include_once 'components/dbConnection.php';
    $connection = getConnection();

    // Output error message if connection unsuccessful.
    if (mysqli_connect_errno() || $connection === false){
        die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
    }


    // Gets id of listing to be displayed from post stream <- NEEDS TO BE PARAM REQUEST FOR LISTING ID
    if(isset($_GET['whichListing'])){
        $listingid = $_GET['whichListing'];
        $query="SELECT * FROM listing WHERE id= '$listingid'";
        $qresult = $connection->query($query);

        // Obtains the data contained for the matching table row.
        $row = mysqli_fetch_array($qresult, MYSQLI_ASSOC);
        $title = $row['title'];
        $description = $row['description'];
        $image = $row['image'];
        $userid = $row['userid'];
           

        $query="SELECT username FROM user WHERE id= '$userid';";
        $qresult = mysqli_query($connection,$query);

        // Obtains the data contained for the matching table row using mysqli.
        $row = mysqli_fetch_array($qresult, MYSQLI_ASSOC);
        $postingUsername = $row['username'];
            
    }
?>
<html>
    <head>
        <title> <?php echo 'Listing: '.$title ?> </title>
        <?php include_once("components/imports.php"); ?>
        <script type = "text/javascript">
            // Listener for button to redirect to offer page if clicked
            document.getElementById("offerbtn").onclick = function ()
            {
                location.href = 'offer.php';
            }
        </script>
    </head>
    <body>
    <?php include('header.php')?>
            <div id = "postHeader">
                <h1><?php echo $title ?></h1>
                <h3>Posted By:
                <?php
                    echo  '<a href="userProfile.php?user=' . $userid . '">'.$postingUsername.'</a></h3>';
                ?>
            </div>
            <div id="imgdisplay">
                <img src="<?php echo $image ?>" alt="poster's image">
            </div>
            <div id= "postbody">
                <h3>Item Description:</h3>
                <h4><?php echo $description ?></h4>
            </div>

            <!-- Hides button (adds hidden class) if user viewing is same as posting user -->
            <div id = "offer" <?php if(($loggedIn == false) or ($userid == $viewerid)){ echo 'style="display: none"';}?>>
                <form name="offer" action="makeOffer.php" method="post">
                    <input type="text" name="listingid" value="<?php echo $listingid; ?>" style="display: none">
                    <input type = "button"  onclick="forms['offer'].submit()" id = "offerbtn" value = "Make an Offer!">
                </form>
            </div>
    </body>
</html>