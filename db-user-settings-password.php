<?php
session_start();

if (isset($_SESSION['userId']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  require "dbconnection.php";

  $currentPassword = $_POST['currentPassword'];
  $newPassword = $_POST['newPassword'];
  $repeatNewPassword = $_POST['repeatNewPassword'];

  date_default_timezone_set("Asia/Manila");
  $dateUpdate = date("Y-m-d");

  $validateUpdateQuery = $dbConnect->prepare("SELECT last_update FROM user_credentials WHERE user_id = ? LIMIT 1");
  $validateUpdateQuery->bind_param("i", $_SESSION['userId']);

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
        echo "<script>alert('Changing password is done once a day only.'); window.location.href = 'user-settings-password.php';</script>";
        $validateUpdateQuery->close();
        exit;
      }
    }

    $getPasswordQuery = $dbConnect->prepare("SELECT user_password FROM user_credentials WHERE user_id = ? LIMIT 1");
    $getPasswordQuery->bind_param('i', $_SESSION['userId']);
    if (!$getPasswordQuery->execute()) {
      // Log error and exit
      error_log("Failed to execute query: " . $getPasswordQuery->error);
      $getPasswordQuery->close();
      exit;
    } else {
      $passwordResult = $getPasswordQuery->get_result();

      if ($passwordResult->num_rows == 1) {
        $displayPassword = $passwordResult->fetch_assoc();

        if ($currentPassword !== $displayPassword['user_password']) {
          // Not match
          // Modify
          echo "<script>alert('Not match: current password input and real password.'); window.location.href = 'user-settings-password.php';</script>";
          $getPasswordQuery->close();
          exit;
        } elseif ($newPassword !== $repeatNewPassword) {
          // Not match
          // Modify
          echo "<script>alert('Not match: new password and repeat new password.'); window.location.href = 'user-settings-password.php';</script>";
          $getPasswordQuery->close();
          exit;
        } else {
          $changePasswordQuery = $dbConnect->prepare("UPDATE user_credentials SET user_password = ?, last_update = ? WHERE user_id = ? LIMIT 1");
          $changePasswordQuery->bind_param("ssi", $newPassword, $dateUpdate, $_SESSION['userId']);
          if (!$changePasswordQuery->execute()) {
            // Log error and exit
            error_log("Failed to execute query: " . $changePasswordQuery->error);
            $changePasswordQuery->close();
            exit;
          } else {
            // Successfully changed password
            // Modify
            echo "<script>alert('Successfully changed password.'); window.location.href = 'user-settings-password.php';</script>";
          }
          $changePasswordQuery->close();
        }
      }
    }
    $getPasswordQuery->close();
  }
  $validateUpdateQuery->close();
}
?>