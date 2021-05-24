<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <style>
    body{
      font-family: sans-serif;
      margin-left: 10em;
    }
    a{
      text-decoration: none;
    }
    .cen{
      text-align: center;
    }


    </style>
    <meta charset="utf-8">
    <title>Dhairya Sharma</title>
  </head>
  <body>
    <h1>Welcome to the Automobiles Database</h1>
    <?php
  if (isset($_SESSION['error'])) {
    echo"<p style=\"color:red;\">".$_SESSION['error']."</p>";
    unset($_SESSION['error']);

  }
  if (isset($_SESSION['success'])) {
    echo"<p style=\"color:green;\">".$_SESSION['success']."</p>";
    unset($_SESSION['success']);

  }
    ?>
<?php
if(isset($_SESSION['account'])){
  require_once "pdo.php";
  $stmt = $pdo->query('SELECT * FROM autos');
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  if($row === false) echo"No rows found <br><br>";
  else{
    echo"<table border= \"1\">";
    echo"<tr><th><p class =\"cen\">Make</p></th> <th><p class =\"cen\">Model</p></th> <th><p class =\"cen\">Year</p></th> <th><p class =\"cen\">Mileage</p></th> <th><p class =\"cen\">Action</p></th></tr>";
    echo"<tr><td>".htmlentities($row['make'])."</td>";
    echo"<td>".htmlentities($row['model'])."</td><td>".htmlentities($row['year'])."</td><td>".htmlentities($row['mileage'])."</td>";
    echo"<td><a href=\"edit.php?user_id=".htmlentities($row['autos_id'])."\">Edit</a>";
    echo"\\<a href=\"delete.php?user_id=".htmlentities($row['autos_id'])."\">Delete</a></td></tr>";
    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
      echo"<tr><td>".htmlentities($row['make'])."</td>";
      echo"<td>".htmlentities($row['model'])."</td><td>".htmlentities($row['year'])."</td><td>".htmlentities($row['mileage'])."</td>";
      echo"<td><a href=\"edit.php?user_id=".htmlentities($row['autos_id'])."\">Edit</a>";
      echo"\\<a href=\"delete.php?user_id=".htmlentities($row['autos_id'])."\">Delete</a></td></tr>";

    }
    echo"</table><br><br>";

  }

  echo "<a href= \"add.php\">Add New Entry</a><br><br>";
  echo "<a href= \"logout.php\">Logout</a>";


}
else{
  echo"<a href= \"login.php\">Please log in</a>";
}


 ?>
  </body>
</html>
