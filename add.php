<?php
session_start();
require_once "pdo.php";
if(!(isset($_SESSION['account']))) die('ACCESS DENIED');
if(isset($_POST['cancel'])) {
  header("Location:index.php");
  exit();
}
if(isset($_POST['make']) && isset($_POST['model']) && isset($_POST['year']) && isset($_POST['mileage'])) {
  if(strlen($_POST['make']) < 1 ||strlen($_POST['model']) < 1 ||strlen($_POST['year']) < 1 ||strlen($_POST['mileage']) < 1){
    $_SESSION['error'] = "All fields are required";
    header("Location:add.php");
    exit();
  }
  elseif(!(is_numeric($_POST['year']))){
    $_SESSION['error'] = "Year must be numeric";
    header("Location:add.php");
    exit();
  }
  elseif(!(is_numeric($_POST['mileage']))){
    $_SESSION['error'] = "Mileage must be numeric";
    header("Location:add.php");
    exit();
  }
  else{
    $stmt = $pdo->prepare("Insert into autos (make , model , year , mileage) VALUES(:mk , :md , :yr , :ml)");
    $stmt->execute(array(
   ':mk' => $_POST['make'],
   ':md' => $_POST['model'],
   ':yr' => $_POST['year'],
   ':ml' => $_POST['mileage']

 ));
 $_SESSION['success'] = "Record added";
 header("Location:index.php");
 exit();
  }
}


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
      </style>
    <meta charset="utf-8">
    <title>Dhairya Sharma</title>
  </head>
  <body>
    <h1>Tracking Automobiles for <?php if(isset($_SESSION['account'])) echo $_SESSION['account']; ?></h1>
    <?php
if(isset($_SESSION['error'])){
  echo"<p style =\"color:red;\">".$_SESSION['error']."</p>";
  unset($_SESSION['error']);
}

     ?>
    <form method="post">
      <label for="make">Make: </label>
    <input type="text" name="make" id="make" size = 40><br>
    <label for="model">Model: </label>
    <input type="text" name="model"><br>
    <label for="year">Year: </label>
    <input type="text" name="year" id = "year" ><br>
    <label for="mileage">Mileage: </label>
    <input type="text" name="mileage" id = "mileage"><br>
    <input type="submit"  value="Add">
    <input type="submit" name="cancel" value="Cancel">
    </form>
  </body>
</html>
