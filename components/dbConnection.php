<?php

function getConnection() {
    // Get the php.ini file with the db config
    $iniConfig = parse_ini_file("php.ini");

    $servername = $iniConfig["ip"];
    $username = $iniConfig["user"];
    $password = $iniConfig["password"];
    $database = $iniConfig["database"];;
    // Create connection
    return mysqli_connect($servername, $username, $password,$database);
}