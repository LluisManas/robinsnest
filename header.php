<?php
    session_start();

    echo <<<_INIT
    <!DOCTYPE html>
    <html>
        <head>
            <meta charset='utf-8'>
            <meta name='viewport' content='widtg0devise-width, initial-scale=1'>
            <link rel='stylesheet' href='jquery.mobile-1.4.5.min.css'>
            <link rel='stylesheet' href='styles.css'>
            <script src='javascript.js'></script>
            <script src='jquery-2.2.4.min.js'></script>
            <script src='jquery.mobile-1.4.5.min.js'></script>

    _INIT;

        require_once 'functions.php';

        $userstr = 'Welcome Gest';

        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $loggedin = TRUE;
            $userstr = "Welcome $user";
        } else {
            $loggedin = FALSE;
        }
    
    echo <<<_MAIN
            <title>Robin's Nest: $userstr</title>
        </head>
        
        <body>
            <div data-role='page'>
                <div data-role='header'>
                    <div id='logo' class='center'>Robin's Nest</div>
                    <div class='username'>$userstr</div>
                </div>
                <div data-role='content'>
    _MAIN;
        
        if ($loggedin) {
            echo <<<_LOGGEDIN
                <div class='center'>
                    <a data-role='button' data-inline='true' data-icon='home' data-transition='slide' href='members.php?view=$user'>Home</a>
                    <a data-role='button' data-inline='true' data-transition='slide' href='members.php?view=$user'>Members</a>
                    <a data-role='button' data-inline='true' data-transition='slide' href='friends.php'>Friends</a>
                    <a data-role='button' data-inline='true' data-transition='slide' href='messages.php'>Messages</a>
                    <a data-role='button' data-inline='true' data-transition='slide' href='profile.php?view=$user'>Edit Profile</a>
                    <a data-role='button' data-inline='true' data-transition='slide' href='logout.php'>Log out</a>
                </div>

    _LOGGEDIN;
        } else {
            echo <<<_GEST
                <div class='center'>
                    <a data-role='button' data-inline='true' data-icon='home' data-transition='slide' href='index.php'>Home</a>
                    <a data-role='button' data-inline='true' data-icon='plus' data-transition='slide' href='signup.php'>Sign up</a>
                    <a data-role='button' data-inline='true' data-icon='plus' data-transition='slide' href='login.php'>Log in</a>
                </div>
                <p class='info'>log in to use all app features</p>
    
    _GEST;
        }
?>
