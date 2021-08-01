<?php
require_once 'header.php';

if (!$loggedin) {
    die('</div></body></html>');
}

echo "<h3>Your Profile</h3>";
$user = $_SESSION['user'];


$result = queryMysql("SELECT * FROM profiles WHERE user='$user'");

if (isset($_POST['text'])) {
    $text = sanitaizeString($_POST['text']);

    if ($result->num_rows) {
        queryMysql("UPDATE profiles SET text='$text' WHERE user='$user'");
    } else {
        queryMysql("INSERT INTO profiles VALUE('$user', '$text')");
    }
} else {
    if ($result->num_rows) {
        $row = $result->fetch_array(MYSQLI_ASSOC);
        $text = $row['text'];
    } else {
        $text = '';
    }
}

if (isset($_FILES['image']['name'])) {
    $saveto = "$user.jpg";
    move_uploaded_file($_FILES['image']['tmp_name'], $saveto);
    $typeok = TRUE;

    switch ($_FILES['image']['type']) {
        case 'image/gif':
            $src = imagecreatefromgif($saveto);
            break;
        case 'image/jpeg':
            $src = imagecreatefromjpeg($saveto);
            break;
        case 'image/pjpeg':
            $src = imagecreatefromjpeg($saveto);
            break;
        case 'image/png':
            $src = imagecreatefrompng($saveto);
        default:
            $typeok = FALSE;
            break;
    }
    
    if ($typeok) {
        list($w, $h) = getimagesize($saveto);

        $max = 100;
        $tw = $w;
        $th = $h;

        if ($w > $h && $max > $w) {
            $th = $max / $w * $h;
            $tw = $max;
        } elseif ($h > $w && $max < $h) {
            $tw = $max / $h * $w;
            $th = $max;
        } elseif  ($max < $w) {
            $tw = $th = $max;
        }

        $tmp = imagecreatetruecolor($tw, $th);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $tw, $th, $w, $h);
        imageconvolution($tmp, array(array(-1, -1, -1),
            array(-1, 16, -1), array(-1, -1, -1)), 8, 0);
        imagejpeg($tmp, $saveto);
        imagedestroy($tmp);
        imagedestroy($src);
    }
}

showProfileUser($user);

echo <<<_END
            <form class='form'  method='post' action='profile.php' enctype='multipart/form-data'>
                <h3>Enter or edit your personal information</h3>
                <textarea name='text'>$text</textarea><br>
                Image: <input type='file' name='image'><br>
                <input type='submit' value='Save Profile'>
            <form>
        </div>
    </body>
</html>
_END;
?>