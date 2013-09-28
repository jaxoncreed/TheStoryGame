<?php
    require("header.inc.php");
    
    if (!isLoggedIn()) {
        if (isset($_POST['loginButton'])) {
            if ($_POST['username'] == "") {
                print("Error: The email field was not set.");
                require("login.php");
            }
            elseif ($_POST['password'] == "") {
                print("Error: The password field was not set.");
                require("login.php");
            }
            else {
                $query = mysql_query("SELECT `id` FROM `users` WHERE `email` = '".mysql_real_escape_string($_POST['username'])."' AND `password` = '".sha1(mysql_real_escape_string($_POST['password']))."'");
                if (mysql_num_rows($query)) {
                    $sessID = mysql_real_escape_string(session_id());
                    $hash = mysql_real_escape_string(sha1($sessID.$_SERVER['HTTP_USER_AGENT']));
                    $userData = mysql_fetch_assoc($query);
                    $expires = time() + (60 * 60);
                    mysql_query("INSERT INTO `active_users` (`users`, `session_id`, `hash`, `expires`) VALUES ('".$userData['id']."', '".$sessID."', '".$hash."', '".$expires."')");
                    header("Location: ".$_SERVER['REQUEST_URI']);
                }
                else {
                    print("Error: Email and/or Password were incorrect.");
                    require("login.php");
                }
            }
        }
        else {
            require("login.php");
        }
    }
    else { //if logged in
        if (isset($_POST['logoutButton'])) {
            $user = isLoggedIn();
            mysql_query("DELETE FROM `active_users` WHERE `users` = ".(int) $user);
            header("Location: ./index.php");
            exit;
        }
        elseif (isset($_GET['game'])) {
            $game = new game($_GET['game']);
            if ($game->isHost()) {
                require("host.php");
            }
            elseif ($game->isPlayer()) {
                require("game.php");
            }
            else {
                header("Location: ./index.php");
                exit;
            }
        }
        else {
            require("home.php");  
        }
    }
    //require("host.php");
    include("footer.inc.php");
?>