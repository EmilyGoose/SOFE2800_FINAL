<?php
    session_start();
    
    // Resets user's session id and returns them to the main page.
    $_SESSION["sessionID"] = null;
    header("Location: index.php");
?>