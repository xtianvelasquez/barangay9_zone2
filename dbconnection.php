<?php
  $serverName = 'localhost:3306';
  $userName = 'root';
  $password = '';
  $dbName = 'barangay9';

  $dbConnect = mysqli_connect($serverName, $userName, $password, $dbName) or die("Unable to connect!");
?>