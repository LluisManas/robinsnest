<?php
require_once 'functions.php';

if (isset($_POST['user'])) {
    $user = sanitaizeString($_POST['user']);
    $result = queryMsql("SELECT * FROM members where user='$user'");

    if ($result->num_rows) {
        echo "<span class='taken'>&nbsp;&#x2718;" . 
            "The username '$user' is taken</span>";
    } else {
        echo "<span class='available'>&nbsp;&#x2714;" . 
            "The user name '$user' is available</span>";
    }
}
?>