<?php
    require("header.inc.php");
    
    if (isset($_POST['createButton'])) {
        $email = mysql_real_escape_string($_POST['email']);
        $pass1 = mysql_real_escape_string($_POST['password1']);
        $pass2 = mysql_real_escape_string($_POST['password2']);
        $name = mysql_real_escape_string($_POST['name']);
        $query = mysql_query("SELECT `email` FROM `users` WHERE `email` = '".$email."'");
        if ($email == "") {
            print("Error: Email field was left blank.");
        }
        elseif ($pass1 == "" || $pass2 == "") {
            print("Error: One of the password fields was left blank.");
        }
        elseif ($name == "") {
            print("Error: Name field was left blank.");
        }
        elseif ($pass1 != $pass2) {
            print("Error: Password fields did not match.");
        }
        elseif (mysql_num_rows($query)) {
            print("Error: This email was already registered.");
        }
        else {
            mysql_query("INSERT INTO `users` (`email`, `password`, `name`, `games`) VALUES ('".$email."', '".sha1($pass1)."', '".$name."', '[\"h\"]')");
            header("Location: ./index.php");
            exit;
        }
    }
?>
    <div id="createUser">
        <h1>Create Your Account</h1>
        <form id="createUserForm" method="post" action="">
            <h2>Email:</h2>
            <input type="text" name="email" id="email" />
            <h2>Password:</h2>
            <input type="password" name="password1" id="password1" />
            <h2>Confirm Password:</h2>
            <input type="password" name="password2" id="password2" />
            <h2>Name:</h2>
            <input type="text" name="name" id="name" />
            <br /><br />
            <button type="submit" name="createButton" id="createButton">Create Your Account</button>
        </form>
    </div> 
<?php
    include("footer.inc.php");
?>