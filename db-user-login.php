<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require("dbconnection.php");

  $userUsername = $_POST['userUsername'];
  $userPassword = $_POST['userPassword'];

  // Validate credentials
  $userCredentialsQuery = $dbConnect->prepare("SELECT * FROM user_credentials WHERE user_username = ? AND user_password = ? LIMIT 1");
  $userCredentialsQuery->bind_param("ss", $userUsername, $userPassword);

  if (!$userCredentialsQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $userCredentialsQuery->error);
    $userCredentialsQuery->close();
    exit;
  } else {
    $userCredentialsResult = $userCredentialsQuery->get_result();
    if ($userCredentialsResult->num_rows == 0) {
      // Invalid credentials
      // Modify
      echo "<script>alert('Invalid username or password.'); window.location.href = 'user-login.php';</script>";
      $userCredentialsQuery->close();
      exit;
    } else {
      // Valid credentials
      $userCredentialsRow = $userCredentialsResult->fetch_assoc();
      $_SESSION['userId'] = $userCredentialsRow['user_id'];
      $_SESSION['userUsername'] = $userCredentialsRow['user_username'];
      $_SESSION['userPassword'] = $userCredentialsRow['user_password'];
      header("Location: user-profile.php");
    }

    $userCredentialsQuery->close();
  }
}
?>