<?php
    if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST') {
        $query = mysql_query("SELECT `id`,`name`,`pass`,`locked` FROM `games`");
        while ($row = mysql_fetch_array($query)) {
            if ($row['locked'] == false) {
                if (isset($_POST['join'.$row['id']])) {
                    if ($row['pass'] != "dks3ouw4eeu3883solxjye8w7u37u2ujdxxnn") {
                        
                        if ($row['pass'] == $_POST['gamePass'.$row['id']]){
                            $game = new game($row['id']);
                            if (!$game->isPlayer()) {
                                $game->addPlayer();
                                $game->save();
                            }
                            header("Location: ./index.php?game=".$row['id']);
                            exit;
                        }
                    }
                    else {
                        $game = new game($row['id']);
                        if (!$game->isPlayer()) {
                            $game->addPlayer();
                            $game->save();
                        }
                        header("Location: ./index.php?game=".$row['id']);
                        exit;
                    }
                }
            }
        }
    }
?>
<div id="side">
    <a href="createGame.php">Create your own game!</a>
    <hr />
    <h3>Games that you are in:</h3>
    <?php
        //code to generate games you're in goes here.
    ?>
</div>

<div id="moreContent">
    <h2>Game Lobby:</h2>
    <div id="story">
        <form id="lobbyForm" method="post" action="">
        <?php
            $query = mysql_query("SELECT `id`,`name`,`pass`,`locked` FROM `games`");
            while ($row = mysql_fetch_array($query)) {
                if ($row['locked'] == false) {
                    print("<strong>".$row['name']."</strong>");
                    print("<span style=\"position: absolute; right:3px\">");
                        if ($row['pass'] != "dks3ouw4eeu3883solxjye8w7u37u2ujdxxnn") {
                            print("Password: "."<input type=\"password\" name=\"gamePass".$row['id']."\" id=\"gamePass".$row['id']."\" />");
                        }
                        print("<button type=\"submit\" name=\"join".$row['id']."\" id=\"join".$row['id']."\" >Join Game</button>");
                    print("</span>");
                    print("<hr />");
                }
            }
            
        ?>
        </form>
    </div>
</div>