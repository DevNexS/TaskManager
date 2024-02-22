<?php

    session_start();
    
    unset($_SESSION['logged-in']);
    session_unset();

    header('Location: login.php');

?>