<?php

// Get the php.ini file with the db config
$iniConfig = parse_ini_file("php.ini");

$servername = $iniConfig["ip"];
$username = $iniConfig["user"];
$password = $iniConfig["password"];
$database = $iniConfig["database"];

// Create connection
$conn = mysqli_connect($servername, $username, $password,$database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

echo "Connected successfully";