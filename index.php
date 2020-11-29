<?php

// Todo test this lol
//include_once("database.php");
session_start();
$_SESSION['sessionID']=null;
include_once("login.php")

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Final Project</title>
    <!-- Todo include javascript and such, probably from separate PHP file -->
</head>
<body>
<h1><?php if($_SESSION['sessionID']!=null){echo "Session Id: ".$_SESSION['sessionID'];}?></h1>
</body>
</html>
