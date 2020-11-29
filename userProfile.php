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
$Result = $connection->query($query);

//$userInfo = "";
while($row = $Result->fetch_assoc()){
    $username = $row['username'];


    //$userInfo = $userInfo.print_r($row,true).'<br>';


$query="SELECT * FROM listing WHERE userid= '$userid';";
$result = $connection->query($query);
/*
$userListingsInfo = "";
while($row = $result->fetch_assoc()){
    $userListingsInfo = $userListingsInfo.print_r($row,true).'<br>';}
*/

//link to get back to login page
    echo "<a href=\"index.php\">Click here to go to index.php</a>" ."<br>";
}


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
            <input type="number" id ="whichListing"  name="whichListing" value="" hidden>
            <?php
            while($row = $result->fetch_assoc()) {
                echo "<button onclick=\"whichListing('".$row['id']."')\" value=\"Listing\">".$row['title']."</button>"."<br>";
            }
            ?>


        </form>
        <?php /*echo $userListingsInfo*/  ?>
    </div>

</body>
</html>
