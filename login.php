<?php
    require_once 'header.php';
    
    $error = '';
    $connection = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($connection->connect_error) die('Fatal Error');

    if (isset($_POST['user'])) {
        $user = sanitaizeString($_POST['user']);
        $pass = sanitaizeString($_POST['pass']);

        if ($user == '' || $pass == '') {
            $error = "There is missing information";
        } else {
            $result = queryMysql("SELECT * FROM members WHERE user='$user' AND pass='$pass'");

            if (!$result->num_rows) {
                $error = "Invalid data, please try again";
            }  else {
                $_SESSION['user'] = $user;
                $_SESSION['pass'] = $pass;
                die("You are logged in. Please <a href='profile.php?view=$user'> click here </a> to continue </div></body></html>");
            }
        }
    }

    echo <<<_END
        <form method='post' action='login.php' class='form'>
            <div>
                <label></label>
                <span class='error'>$error</span>
            </div>
            <div>
                <label></label>
                Please enter your details to log in
            </div>
            <div>
                <label>Username</label>
                <input type='text' name='user' value=''>
            </div>
            <div>
                <label>Password</label>
                <input type='password' name='pass' value=''>
            </div>
            <div>
                <label></label>
                <input type='submit' value='login'>
            </div>
        </form>
    </div>
    </body>
    </html>
    _END;
?>