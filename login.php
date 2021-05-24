<?php
session_start();
if(isset($_POST['cancel'])){
  header("Location:index.php");
  return;
}
elseif(isset($_POST['email']) && isset($_POST['pass'])){
  if(isset($_SESSION['account'])){
    unset($_SESSION['account']);
  }
  $pass = htmlentities($_POST['pass']);
$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';
$passsalt = $salt.$pass;
$check = hash('md5', $passsalt);

  if(strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1  ){

    $_SESSION["error"] = "User name and password are required";
    header("Location:login.php");
    exit();

  }
  elseif(strpos($_POST['email'] , '@') === false){
    $_SESSION['error'] = "Email must have an at-sign (@)";
    header("Location:login.php");
    exit();
  }
  elseif($check !== $stored_hash){
    $_SESSION['error'] = "Incorrect password";
    error_log("fail ".htmlentities($_POST['email'])." ".$check );
    header("Location:login.php");
    exit();
  }
  else{
    if($check === $stored_hash){
      $_SESSION['account'] = $_POST['email'];
      error_log("success ".htmlentities($_POST['email']) );
      header("Location:index.php");
      exit();
    }
  }

}



 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head><style>
    body{
      font-family: sans-serif;
      margin-left: 10em;
    }
    input[type=submit]{
      cursor: pointer;
    }
    label{
      font-weight: bold;

    }
    input{
      margin-bottom: 3px;
      font-family: sans-serif;
    }
    </style>
    <meta charset="utf-8">
    <title>Dhairya Sharma</title>
  </head>
  <body>
    <h1>Please Log In</h1>
    <?php
     if(isset($_SESSION['error'])){
       echo"<p style = \"color:red;\">".$_SESSION['error']."</p>";
     }
     ?>
    <form method="post">
      <label for = "who">Email </label>
    <input type="text" name="email" id ="who" ><br>
    <label for = "passwd">Password </label>
  <input type="text" name="pass" id ="passwd" ><br>
  <input type="submit"  value="Log In">
  <input type="submit" name="cancel" value="Cancel">
    </form>

  </body>
</html>
