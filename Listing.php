<?php
    session_start();
    //echo "sessionID: ".$_SESSION['sessionID'];
    // Checks if user is logged in (session id set)
    if (isset($_SESSION['sessionID'])){
        // Get the php.ini file with the db config
        $iniConfig = parse_ini_file("php.ini");
    
        //Establishing connection
        $servername = $iniConfig["ip"];
        $dbusername = $iniConfig["user"];
        $password = $iniConfig["password"];
        $dbname = $iniConfig["database"];
        $connection = mysqli_connect ($servername, $dbusername, $password, $dbname);

        // Output error message if connection unsuccessful.
        if (mysqli_connect_errno() || $connection === false){
            die("Database connection failed: ".mysqli_connect_error()."(".mysqli_connect_errno().")");
        }

        // Get session user's id
        $viewerid = $_SESSION['sessionID'];

        // Gets id of listing to be displayed from post stream <- NEEDS TO BE PARAM REQUEST FOR LISTING ID
        if(isset($_POST['whichListing'])){
            $listingid = $_POST['whichListing'];
            $query="SELECT * FROM listing WHERE id= '$listingid'";
            $qresult = $connection->query($query);

            // Obtains the data contained for the matching table row.
            $row = $qresult->fetch_assoc();
            $title = $row['title'];
            $description = $row['description'];
            $image = $row['image'];
            $userid = $row['userid'];
           

            $query="SELECT username FROM user WHERE id= '$userid';";
            $qresult = $connection->query($query);

            // Obtains the data contained for the matching table row.
            $row = $qresult->fetch_assoc();
            $postingUsername = $row['username'];
            
        }
    }
    // Redirects to login page if user not logged in.
    else{
        header("Location:login.php");
        exit;
    }
    
?>
<html>
    <head>
        <!-- Insert using database once I figure it out ?? Is this even right??-->
        <title> <?php echo 'Listing: '.$title ?> </title>

        <script type = "text/javascript">
            // Listener for button to redirect to offer page if clicked
            document.getElementById("offerbtn").onclick = function ()
            {
                location.href = 'offer.php';
            }
        </script>
    </head>
    <body>
        
        <div id = "postHeader">
            <h1><?php echo $title ?></h1>
            <h3>Posted By: <?php echo $postingUsername ?></h3>
        </div>
        <div id="imgdisplay">
            <img src="<?php echo $image ?>" alt="poster's image">
        </div>
        <div id= "postbody">
            <h3>Item Description:</h3>
            <h4><?php echo $description ?></h4>
        </div>
        <!-- Hides button (adds hidden class) if user viewing is same as posting user -->
        <div id = "offer <?php if ($userid == $viewerid ) echo 'hidden'?>">
            <input type = "button" id = "offerbtn" value = "Make an Offer!">
        </div>
    </body>
</html>