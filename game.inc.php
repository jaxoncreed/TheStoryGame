<?php
    require("config.php");
    
    class game {
        private $id;
        private $name;
        private $story;
        private $host;
        private $players;
        private $pass;
        private $locked;
        private $turn;
        
        public function __construct($identify) {
            $this->id = $identify;
            $query = mysql_query("SELECT * FROM `games` WHERE `id` = '".  $this->id."'");
            $data = mysql_fetch_assoc($query);
            $this->name = $data['name'];
            $this->story = $data['story'];
            $this->host = $data['host'];
            $this->players = json_decode($data['players']);
            $this->pass = $data['pass'];
            $this->locked = $data['locked'];
            $this->turn = $data['turn'];
        }
        
        public function save() {
            mysql_query("UPDATE `games` SET `name` = '".mysql_real_escape_string($this->name)."', `story` = '".mysql_real_escape_string($this->story)."', `host` = '".mysql_real_escape_string($this->host)."', `players` = '".json_encode($this->players)."', `pass` = '".mysql_real_escape_string($this->pass)."', `locked` = '".mysql_real_escape_string($this->locked)."', `turn` = '".mysql_real_escape_string($this->turn)."' WHERE `id` = '".$this->id."'");
        }
        
        public function isHost() {
            if ($this->host == isLoggedIn()) {
                return true;
            }
            else {
                return false;
            }
        }
        
        public function isPlayer() {
            foreach ($this->players as $play) {
                if ($play == isLoggedIn()) {
                    return true;
                }
            }
            return false;
        }
        
        public function isTurn() {
            foreach ($this->players as $index=>$play) {
                if ($play == isLoggedIn()) {
                    $playerIndex = $index;
                }
            }
            if ($playerIndex == $this->turn) {
                return true;
            }
            else{
                return false;
            }
        }
        
        public function getStory() {
            return $this->story;
        }
        
        public function addStory($newStr) {
            $this->story = $this->story." ".$newStr;
        }
        
        public function nextTurn() {
            if ((count($this->players) - 1) == $this->turn){
                $this->turn = 0;
            }
            else {
                $this->turn = $this->turn + 1;
            }            
        }
        
        public function lockGame() {
            $this->locked = true;
        }
        
        public function addPlayer() {
            array_push($this->players, isLoggedIn());
            $query = mysql_fetch_assoc(mysql_query("SELECT `games` FROM `users` WHERE `id` = '".isLoggedIn()."'"));
            $data = json_decode($query['games']);
            array_push($data, $this->id);
            mysql_query("UPDATE `users` SET `games` = '".  json_encode($data)."' WHERE `id` = '".$this->id."'");
        }
        
        public function getNameArray() {
            $array = array();
            foreach ($this->players as $play) {
                $query = mysql_query("SELECT `name` from `users` WHERE `id` = '".(int) $play."'");
                array_push($array, mysql_fetch_assoc($query)['name']);
            }
            return $array;
        }
        
        public function getTurn() {
            return $this->turn;
        }
    }

?>
