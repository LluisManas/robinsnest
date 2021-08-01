<?php

require_once 'header.php';

    echo <<<_END
        <script>
            function checkUser(user) {
                if (user.name == '') {
                    $('#used').html('&nbsp;')
                    return
                }
                $.POST
                (
                    'checkuser.php',
                    { user : user.value },
                    function(data) {
                        $('#used').html(data)
                    }
                )
            }
        </script>
    _END;

    $error = '';
    if (isset($_SESSION['user'])) {
        destroySession();
    }

    if (isset($_POST['user'])) {
        $user = sanitaizeString($_POST['user']);
        $pass = sanitaizeString($_POST['pass']);

        if ($user == '' || $pass == '') {
            $error = 'Provide all information required';
        } else {
            $result = queryMysql("SELECT * FROM members WHERE user='$user'");
            if ($result->num_rows) {
                $error = 'User name already exists';
            } else {
                queryMysql("INSERT INTO members VALUES('$user', '$pass')");
                die("<h5>Account created, please log in.</h5></div></body></html>");
            }
        }
    }

    echo <<<_END
                <div class='form'>
                    <form method='post' action='signup.php'>
                        <p>$error</p>
                        <h4>Please enter your details to sign up</h4>
                        <label>Username</label>
                        <input type='text' maxlength='16' name='user' value=''>
                        <label></label><div id='used'>&nbsp;</div>
                        <label>Password</label>
                        <input type='password' name='pass' value=''><br>
                        <input type='submit' value='Sign Up'>
                    </form>
                </div>
            </body>
        </html>
    _END;
?>