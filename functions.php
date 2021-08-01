<?php

$dbhost = 'localhost';
$dbuser = 'root';
$dbpass = '';
$dbname = 'robinsnest';

$connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
if ($connection->connect_error) die('Fatal Error');


function createTable($name, $query)
{
    queryMysql("CREATE TABLE IF NOT EXISTS $name ($query);");
    echo "Table '$name' created or already exists.<br>";
}

function queryMysql($query)
{
    global $connection;
    $result = $connection->query($query);
    
    if (!$result) die ("Fatal Error in DB");
    return $result;
}

function destroySession()
{
    $_SESSION = array();
    if (session_id() != '' || isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-2592000, '/');
    }
    
    session_destroy();
}

function sanitaizeString($var)
{
    global $connection;
    $var = strip_tags($var); //remove all php & HTML tags
    $var = htmlentities($var); //translates all html entities into code
    if (get_magic_quotes_gpc()) {
        $var = stripcslashes($var);
    }

    return $connection->real_escape_String($var);
}

function  showProfileUser($user)
{
    if(file_exists("$user.jpg")) {
        echo "<img src='$user.jpg' style='float:left;'>";
    }

    $result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        echo stripslashes($row['text']) . "<br style='clear:left;'><br>";
    } else {
        echo "<p>Nothing to see there, yet</p><br>";
    }
}
?>