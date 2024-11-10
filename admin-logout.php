<?php
session_start();
session_unset();
if (session_destroy()) {
  header("location: admin-login.php");
  exit();
}
$dbConnect->close();
?>