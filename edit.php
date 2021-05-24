<?php
require_once "pdo.php";
session_start();
if(!(isset($_SESSION['account']))) die('ACCESS DENIED');
if(!(isset($_GET['user_id']))){
  $_SESSION['error'] = "Missing user_id";
  header("Location:index.php");
  exit();
}
if(isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])){
  if(strlen($_POST['make']) < 1 ||strlen($_POST['model']) < 1 ||strlen($_POST['year']) < 1 ||strlen($_POST['mileage']) < 1){
    $_SESSION['error'] = "All fields are required";
    header("Location:edit.php?user_id=".$_POST['user_id']);
    exit();
  }
  elseif(!(is_numeric($_POST['year']))){
    $_SESSION['error'] = "Year must be numeric";
    header("Location:edit.php?user_id=".$_POST['user_id']);
    exit();
  }
  elseif(!(is_numeric($_POST['mileage']))){
    $_SESSION['error'] = "Mileage must be numeric";
    header("Location:edit.php?user_id=".$_POST['user_id']);
    exit();
  }
  else{
  $sql = "UPDATE autos SET make = :mk , model = :md , year = :yr ,mileage =:ml where autos_id = :user_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':mk' => $_POST['make'],
    ':md' => $_POST['mileage'],
    ':yr' => $_POST['year'],
    ':ml' => $_POST['mileage'],
    ':user_id' => $_POST['user_id']
  ));
  $_SESSION['success'] = "Record updated";
  header("Location:index.php");
  exit();
}}
$sql = "select * from autos where autos_id = :xyz";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
  ':xyz' => htmlentities($_GET['user_id'])
));
$row = $stmt->fetch(PDO::FETCH_ASSOC);
if($row === false){
  $_SESSION['error'] = "Bad value for id";
  header("Location:index.php");
  exit();
}
$mk = htmlentities($row['make']);
$md = htmlentities($row['model']);
$yr = htmlentities($row['year']);
$ml = htmlentities($row['mileage']);
$user_id = $row['autos_id'];



 ?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <style>
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
      a{
        text-decoration: none;
      }
      </style>
    <meta charset="utf-8">
    <title>Dhairya Sharma</title>
  </head>
  <body></h1>
    <h1>Editing Automobile</h1>
    <?php
if(isset($_SESSION['error'])){
  echo"<p style =\"color:red;\">".$_SESSION['error']."</p>";
  unset($_SESSION['error']);
}
     ?>
<form  method="post">
  <label for="make">Make: </label>
  <input type="text" name="make" value="<?= $mk ?>" id = "make"><br>
  <label for="model">Model: </label>
  <input type="text" name="model" value="<?= $md ?>" id ="model"><br>
  <label for="year">Year: </label>
  <input type="text" name="year" value="<?= $yr ?>" id= "year"><br>
  <label for="mileage">Mileage: </label>
  <input type="text" name="mileage" value="<?= $ml ?>" id = "mileage"><br>
  <input type="hidden" name="user_id" value="<?= $user_id ?>">
  <input type="submit"  value="Save">
  <a href="index.php">Cancel</a>
</form>
  </body>
</html>
