<?php
    require("game.inc.php");
    session_start();
    if (isLoggedIn()) {
        $expires = time() + (60* 60);
        mysql_query("UPDATE `active_users` SET `expires` = '".$expires."' WHERE `user` = '".(int) isLoggedIn()."'");
    }
    
    function isLoggedIn() {
        $sessID = mysql_real_escape_string(session_id());
        $hash = mysql_real_escape_string(sha1($sessID.$_SERVER['HTTP_USER_AGENT']));
        $query = mysql_query("SELECT `users` FROM `active_users` WHERE `session_id` = '".$sessID."' AND `hash` = '".$hash."' AND `expires` > ".time());
        if (mysql_num_rows($query)) {
            $data = mysql_fetch_assoc($query);
            return ($data['users']);
        }
        else {
            return false;
        }
    }
    
    function getUser() {
        $user = isLoggedIn();
        if ($user) {
            $query = mysql_query("SELECT `email`, `name` FROM `users` WHERE `id` ='".(int) $user."'");
            return mysql_fetch_assoc($query);
        }
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>The Story Game</title>
        <?php
            //Fancy title thing
        ?>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
        <div id="header">
            <h1>The Story Game</h1>Yay! bad styling!
            <span style="position: absolute; right: 5px; bottom: 5px;">
                <form id="logoutForm" method="post" action="">
                    <?php
                        if (isLoggedIn()) {
                            print("<button type=\"submit\" name=\"logoutButton\" id=\"logoutButton\">Logout</button>");
                        }
                    ?>
                </form>
            </span>
        </div>
        <?php
        // put your code here
        ?>
        <div id="content">
