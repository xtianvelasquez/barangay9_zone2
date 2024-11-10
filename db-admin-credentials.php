<?php
session_start();

if (isset($_SESSION['adminId']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  require "dbconnection.php";

  $adminName = $_POST['adminName'];
  $adminRole = $_POST['adminRole'];
  $adminUsername = $_POST['adminUsername'];
  $adminPassword = $_POST['adminPassword'];

  date_default_timezone_set("Asia/Manila");
  $dateUpdate = date("Y-m-d");

  $validateUpdateQuery = $dbConnect->prepare("SELECT last_update FROM admin_credentials WHERE admin_id = ? LIMIT 1");
  $validateUpdateQuery->bind_param("s", $_SESSION['adminId']);

  if (!$validateUpdateQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $validateUpdateQuery->error);
    $validateUpdateQuery->close();
    exit;
  } else {
    $validateUpdateResult = $validateUpdateQuery->get_result();

    if ($validateUpdateResult->num_rows == 1) {
      $displayUpdateResult = $validateUpdateResult->fetch_assoc();
      $lastDateUpdate = $displayUpdateResult['last_update'];
      if ($lastDateUpdate == $dateUpdate) {
        // Update is once a day only
        // Modify
        echo "<script>alert('Updating your credentials is done once a day only.'); window.location.href = 'admin-credentials.php';</script>";
        exit;
      }
    }

    // Update general details
    $updateAdminCredentials = "UPDATE admin_credentials SET admin_name = ?, admin_role = ?, admin_username = ?, admin_password = ?, last_update = ? WHERE admin_id = ?";
    $updateAdminCredentialsQuery = $dbConnect->prepare($updateAdminCredentials);
    $updateAdminCredentialsQuery->bind_param("ssssss", $adminName, $adminRole, $adminUsername, $adminPassword, $dateUpdate, $_SESSION['adminId']);
    if (!$updateAdminCredentialsQuery->execute()) {
      // Log error and exit
      error_log("Failed to execute query: " . $updateAdminCredentialsQuery->error);
      $updateAdminCredentialsQuery->close();
      exit;
    } else {
      echo "<script>alert('Update successfully.'); window.location.href = 'admin-credentials.php';</script>";
    }
    $updateAdminCredentialsQuery->close();
  }
  $validateUpdateQuery->close();
}
?>