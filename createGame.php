<?php
    require("header.inc.php");
    if (!isLoggedIn()) {
        header("Location: ./index.php");
        exit;
    }
    else {
        if (isset($_POST['gameButton'])) {
            $name = mysql_real_escape_string($_POST['name']);
            $pass = mysql_real_escape_string($_POST['password']);
            $query = mysql_query("SELECT `id` FROM `games` WHERE `name` = `".$name."`");
            $curUser = isLoggedIn();
            if ($name == "") {
                print("Error: You must name your game.");
            }
            elseif (mysql_num_rows($query)) {
                print("Error: There is already a game with that name");
            }
            else {
                if ($pass != "") {
                    mysql_query("INSERT INTO `games` (`name`, `story`, `host`, `players`, `pass`, `locked`, `turn`) VALUES ('".$name."', '', '".$curUser."', '[\"".$curUser."\"]', '".$pass."', 'false', '0')");
                    $findIndex = mysql_query("SELECT `id` FROM `games` WHERE `name` = '".$name."'");
                    header("Location: ./index.php?game=".mysql_fetch_assoc($findIndex)['id']);
                    exit;
                }
                else {
                    mysql_query("INSERT INTO `games` (`name`, `story`, `host`, `players`, `pass`, `locked`, `turn`) VALUES ('".$name."', '', '".$curUser."', '[\"".$curUser."\"]', 'dks3ouw4eeu3883solxjye8w7u37u2ujdxxnn', 'false', '0')");
                    $findIndex = mysql_query("SELECT `id` FROM `games` WHERE `name` = '".$name."'");
                    header("Location: ./index.php?game=".mysql_fetch_assoc($findIndex)['id']);
                    exit;
                }
            }
        }
    }
?>
    <div id="createUser">
        <h1>Create Your Game</h1>
        <form id="createGameForm" method="post" action="">
            <h2>Game Name:</h2>
            <input type="text" name="name" id="name" />
            <h2>Game Password:</h2>
            <p>Leave blank if you want to keep your game open to the public</p>
            <input type="text" name="password" id="password" />
            <br /><br />
            <button type="submit" name="gameButton" id="gameButton">Create Your Game</button>
        </form>
    </div> 
<?php
    include("footer.inc.php");
?>