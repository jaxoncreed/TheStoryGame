<?php
    if (isset($_POST['submitString'])) {
        if ($game->isTurn()) {
            $game->addStory($_POST['newString']);
            $game->nextTurn();
            $game->save();
        }
    }
    if (isset($_POST['lobbyRemove'])) {
        $game->lockGame();
        $game->save();
    }
?>
<div id="side">
    <a href="index.php">Back to the Lobby</a>
    <hr />
    <h3>Players in the game:</h3>
    <p>Click on a player to kick them from the game</p>
    <?php
        $names = $game->getNameArray();
        $turn = $game->getTurn();
        foreach ($names as $index=>$name) {
            if ($index == $turn) {
                print("<span style=\"background-color: green; color: white;\">");
                    print(($index + 1).") ".$name);
                print("</span>");
                print("<hr />");
            }
            else {
                print(($index + 1).") ".$name);
                print("<hr />");
            }
        }
    ?>
</div>

<div id="moreContent">
    <span style="position: absolute; left:200px">
        <strong>As the host you can: </strong>
        <form id="hostForm" method="post" action="">
            <button type="submit" name="lobbyRemove" id="lobbyRemove">Remove the Game from the Lobby</button>
            <button type="submit" name="endStory" id="endStory">End the Story</button>
        </form>
    </span>
    <h2>The Story so Far:</h2>
    <div id="story">
        <p>
        <?php 
            print($game->getStory()); 
        ?>
        </p>
    </div>
    <span style="position: absolute; bottom: 0px">
        <form id="String" method="post" action="">
        <input type="text" name="newString" id="newString" maxlength="100" size="100" />
        <button type="submit" name="submitString" id="submitString">Submit your addition</button>
        <br />
    </span>
</div>
