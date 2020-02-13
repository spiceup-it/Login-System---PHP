<?php

    session_start();

    //unset all of the session variables
    $_SESSION = array();

    //Destroy the session
    session_destroy();

    //Redirect back to login page
    header("location: login.php");
    exit;

?>