<h1>Sign Up</h1>
<form action="../Operations/SignUp.php" method="post">
  <label for="username">Username:</label>
  <input type="text" id="username" name="username"><br><br>
  <label for="password">Password:</label>
  <input type="password" id="password" name="password"><br><br>
  <input type="submit" value="Submit">
</form>
<?php
if(isset($_GET["error"])){
  echo "There was an error during the SignUp!";
}
?>