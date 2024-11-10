<?php
session_start();

if ($_SESSION['userId'] && $_SERVER['REQUEST_METHOD'] === 'POST') {
  require "dbconnection.php";

  $contactNumber = trim("+63" . $_POST['contactNumber']);
  $emailAddress = filter_var($_POST['emailAddress'], FILTER_SANITIZE_EMAIL);
  $homeAddress = $_POST['homeAddress'];

  date_default_timezone_set("Asia/Manila");
  $dateUpdate = date("Y-m-d");

  $validateUpdateQuery = $dbConnect->prepare("SELECT last_update FROM user_contact_details WHERE user_id = ? LIMIT 1");
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
        echo "<script>alert('Updating contact details is done once a day only.'); window.location.href = 'user-settings-contact.php';</script>";
        exit;
      }
    }

    $updateContactDetailsQuery = $dbConnect->prepare("UPDATE user_contact_details SET contact_number = ?, email_address = ?, home_address = ?, last_update = ? WHERE user_id = ?");
    $updateContactDetailsQuery->bind_param("ssssi", $contactNumber, $emailAddress, $homeAddress, $dateUpdate, $_SESSION['userId']);
    if (!$updateContactDetailsQuery->execute()) {
      // Log error and exit
      error_log("Failed to execute query: " . $updateContactDetailsQuery->error);
      $updateContactDetailsQuery->close();
      exit;
    } else {
      // Successfully updated
      // Modify
      echo "<script>alert('Update successfully.'); window.location.href = 'user-settings-contact.php';</script>";
    }

    $updateContactDetailsQuery->close();
  }

  $validateUpdateQuery->close();
}
?>