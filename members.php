<?php

require_once 'header.php';

if (!$loggedin) {
    die("</div></body></html>");
}
if (isset($_GET['view'])) {
    $view = sanitaizeString($_GET['view']);

    if ($view == $user) {
        $name = "Your";
    } else {
        $name = "$view's";
    }

    echo "<h3>$name Profile</h3>";
    showProfileUser($view);
    echo "<a class='button' href='message.php?view=$view'>View $name messages</a>";
    //die("</div></body></html>");
}

if (isset($_GET['add'])) {
    $add = sanitaizeString($_GET['add']);

    $result = queryMysql("SELECT * FROM friends WHERE user='$add' AND friend='$user'");
    if (!$result->num_rows) {
        queryMysql("INSERT INTO friends VALUES ('$add', '$user')");
    }

} elseif (isset($_GET['remove'])) {
    $remove = sanitaizeString($_GET['remove']);
    queryMysql("DELETE FROM friends WHERE user='$remove' AND friend='$user'");
}

$result = queryMysql("SELECT user FROM members ORDER BY user");
$num = $result->num_rows;

echo "<h3>Other Members</h3><ul>";

for ($j = 0; $j < $num; $j++) {
    $row = $result->fetch_array(MYSQLI_ASSOC);
    if ($row['user'] == $user) {
        continue;
    }

    echo "<li><a href='members.php?view=" . $row['user'] . "'>" . $row['user'] . "</a>";
    $follow = "follow";

    $result1 = queryMysql("SELECT * FROM friends WHERE user='" . $row['user'] . "' AND friend='$user'");
    $t1 = $result->num_rows;

    $result1 = queryMysql("SELECT * FROM friends WHERE user='$user' AND friend='" . $row['user'] . "'");
    $t2 = $result->num_rows;

    if (($t1 + $t2) > 1) {
        echo " &harr; is mutual friend";
    } elseif ($t1) {
        echo " &harr; you are following";
    } elseif ($t2) {
        echo " &harr; is following you";
        $follow = "reciep";
    }

    if (!$t1) {
        echo " [<a href='members.php?add=" . $row['user'] . "'>$folow</a>]";
    } else {
        echo " [<a href='members.php?remove=" . $row['user'] . "'>drop</a>]";
    }
}

?>
    </ul></div>
</body>
</html>