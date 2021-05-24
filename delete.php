<?php
require_once "pdo.php";
session_start();
if(!(isset($_SESSION['account']))) die('ACCESS DENIED');
if(!(isset($_GET['user_id']))){
  $_SESSION['error'] = "Missing user_id";
  header("Location:index.php");
  exit();
}
if(isset($_POST['user_id']) && isset($_POST['delete'])){
$sql= "Delete from autos where autos_id = :abc ";
$stmt = $pdo->prepare($sql);
$stmt->execute(array(
  ':abc' => $_POST['user_id']
));
$_SESSION['success'] = "Record deleted";
header("Location:index.php");
exit();
}

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
  <body>
<?php

echo"<p>Confirm: Deleting ".htmlentities($row['make'])." </p><br>";

 ?>
 <form  method="post">
   <input type="hidden" name="user_id" value="<?= $row['autos_id']?>">
   <input type="submit" name="delete" value="Delete"><a href="index.php">Cancel</a>


 </form>

  </body>
</html>
