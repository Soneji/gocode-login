<?php defined('DS') OR die('No direct access allowed.');

$users = array(
 #add any user accounts to this array
 "gocode" => "gocode"
);

if(isset($_GET['logout'])) {
    $_SESSION['username'] = '';
    header('Location:  ' . $_SERVER['PHP_SELF']);
}

if(isset($_POST['username'])) {
    if($users[$_POST['username']] !== NULL && $users[$_POST['username']] == $_POST['password']) {
  $_SESSION['username'] = $_POST['username'];
  header('Location:  ' . $_SERVER['PHP_SELF']);
    }else {
        //invalid login
  echo "<p>error logging in</p>";
    }
}

echo '<html lang="en"><body><form method="post" action="'.SELF.'">
  <link rel="stylesheet" type="text/css" href="index.css">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <a href=".."><div style="display: inline-block;float: left;">Home</div></a>
  <br>
  <title>Login</title>
  <h2>Login</h2>
  <p><label for="username">Username:</label> <input type="text" id="username" name="username" value="" /></p>
  <p><label for="password">Password: </label> <input type="password" id="password" name="password" value="" /></p>
  <p><input type="submit" name="submit" value="Login" class="button"/></p>
  </form></body></html>';
exit; 
?>
