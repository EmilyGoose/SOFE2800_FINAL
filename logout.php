<?php
session_start();
$_SESSION["sessionID"] = null;
header("Location: home.php");