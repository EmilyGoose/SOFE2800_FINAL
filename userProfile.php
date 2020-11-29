<?php
session_start();
$userid = $_POST["userProfile"];//controls which user's profile is displayed, rn displays the viewing users profile, this

$iniConfig = parse_ini_file("php.ini");

//Establishing connection
$servername = $iniConfig["ip"];
$dbusername = $iniConfig["user"];
$password = $iniConfig["password"];
$dbname = $iniConfig["database"];
$connection = mysqli_connect ($servername, $dbusername, $password, $dbname);

$query="SELECT * FROM user WHERE id = '$userid';";
$result = $connection->query($query); // changed $Result to $result as capitals will not work

// Obtain's the userid of the user to be loaded from button
if(isset($_POST['userid'])){
    $userid = $_POST['userid'];
    
    // Get user details based on their userid
    $query="SELECT * FROM users WHERE id= '$userid'";
    $qresult = $connection->query($query);
            
    // Obtains the data contained for the matching table row to retrieve username.
    $row = $qresult->fetch_array(MYSQLI_NUM);
    $userid = $row[0];
    $username = $row[1];

}
/* Not entirely sure what daniel was doing here 
while($row = $result->fetch_assoc()){
    $username = $row['username'];


    //$userInfo = $userInfo.print_r($row,true).'<br>';


$query="SELECT * FROM listing WHERE userid= '$userid';";
$result = $connection->query($query);

$userListingsInfo = "";
while($row = $result->fetch_assoc()){
    $userListingsInfo = $userListingsInfo.print_r($row,true).'<br>';}
*/

//link to get back to login page
    echo "<a href=\"index.php\">Click here to go to index.php</a>" ."<br>";
//}


// Obtains the data contained for the matching table row.
/*
while($row = $qresult->fetch_assoc()){
    print_r($row);
    echo '<br>';

    $title = $row['title'];
    $description = $row['description'];
    $image = $row['image'];
    $userid = $row['userid'];
    */


?>
<html>
<head>
    <title>User: <?php echo $username  ?></title>
    <script>
        function whichListing(listingid){
            document.getElementById('whichListing').setAttribute(value,listingid) ;
            console.log("trying to change")
            document.forms['listingLinks'].submit()

        }
    </script>
</head>
<body>

    <div id="user information">
        <h1><?php echo $username  ?></h1>
    </div>

    <div id="userlistings">
        <h1>Listings: </h1>
        <form id="listingLinks" method="post" action="Listing.php" >
            <!-- <input type="number" id ="whichListing"  name="whichListing" value="" hidden> -->
            <?php/*
            while($row = $result->fetch_assoc()) {
                echo "<button onclick=\"whichListing('".$row['id']."')\" value=\"Listing\">".$row['title']."</button>"."<br>";
            }
            */
            ?>


            <!-- I don't want to accidentally break anything so writing my (Jess) idea here -->
            <!-- Need to retrieve each row one at a time, and sequentially print as there is not an easy way to store them -->

            <!-- THIS IS WHERE I NEED TO FIGURE OUT HOW TO DO A PARAM REQUEST -->
            <?php
                $query="SELECT * FROM listing WHERE userid= '$userid'";
                $qresult = $connection->query($query);
                while($row = mysql_fetch_assoc($row)){
                    $listingid = $row['id'];
                    $title = $row['title'];
                    echo '<h1><a href = \"Listing.php\">'.$title.'<a/></h1>'; // I want to somehow pass this listing's Id here
                }
            ?>


        </form>

    </div>

</body>
</html>
