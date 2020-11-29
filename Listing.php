<?php
    session_start();

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


        if(isset($_POST['id'])){
            $listingid = $_POST['id'];
            $query="SELECT * FROM marketplace WHERE id= '$listingid'";
            $qresult = $connection->query($query);
                    
            // Obtains the data contained for the matching table row.
            $row = $qresult->fetch_array(MYSQLI_NUM);

            $title = $row[1];
            $description = $row[2];
            $image = $row[3];
            $userid = $row[4];
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
        <title> <?php echo $title ?> </title>

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
            <h1><?php $title ?></h1>
            <h3>Posted By: <?php echo $userid ?></h3>
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