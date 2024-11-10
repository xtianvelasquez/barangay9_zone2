<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require("dbconnection.php");

  $adminUsername = $_POST['adminUsername'];
  $adminPassword = $_POST['adminPassword'];

  // Validate credentials
  $adminCredentialsQuery = $dbConnect->prepare("SELECT * FROM admin_credentials WHERE admin_username = ? AND admin_password = ? LIMIT 1");
  $adminCredentialsQuery->bind_param("ss", $adminUsername, $adminPassword);

  if (!$adminCredentialsQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $adminCredentialsQuery->error);
    $adminCredentialsQuery->close();
    exit;
  } else {
    $adminCredentialsResult = $adminCredentialsQuery->get_result();
    if ($adminCredentialsResult->num_rows == 0) {
      // Invalid credentials
      // Modify
      echo "<script>alert('Invalid username or password.'); window.location.href = 'admin-login.php';</script>";
      $adminCredentialsQuery->close();
      exit;
    } else {
      // Valid credentials
      $adminCredentialsRow = $adminCredentialsResult->fetch_assoc();
      $_SESSION['adminRole'] = $adminCredentialsRow['admin_role'];
      $_SESSION['adminId'] = $adminCredentialsRow['admin_id'];
      header("Location: admin-masterlist.php");
      exit;
    }

    $adminCredentialsQuery->close();
  }
}
?>