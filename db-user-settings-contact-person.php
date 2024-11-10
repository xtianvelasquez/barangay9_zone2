<?php
session_start();

if ($_SESSION['userId'] && $_SERVER['REQUEST_METHOD'] === 'POST') {
  require "dbconnection.php";

  $contactName = ucwords(trim($_POST['contactName']));
  $contactRelationship = ucfirst(trim($_POST['contactRelationship']));
  $contactPhone = trim("+63" . $_POST['contactPhone']);
  $contactAddress = trim($_POST['contactAddress']);

  date_default_timezone_set("Asia/Manila");
  $dateUpdate = date("Y-m-d");

  $validateUpdateQuery = $dbConnect->prepare("SELECT last_update FROM user_contact_person WHERE user_id = ? LIMIT 1");
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
        echo "<script>alert('Updating emergency contact person is done once a day only.'); window.location.href = 'user-settings-contact-person.php';</script>";
        exit;
      }
    }

    $updateContactPersonQuery = $dbConnect->prepare("UPDATE user_contact_person SET contact_name = ?, contact_relationship = ?, contact_phone = ?, contact_address = ?, last_update = ? WHERE user_id = ?");
    $updateContactPersonQuery->bind_param("sssssi", $contactName, $contactRelationship, $contactPhone, $contactAddress ,$dateUpdate, $_SESSION['userId']);
    if (!$updateContactPersonQuery->execute()) {
      // Log error and exit
      error_log("Failed to execute query: " . $updateContactPersonQuery->error);
      $updateContactPersonQuery->close();
      exit;
    } else {
      // Successfully updated
      // Modify
      echo "<script>alert('Update successfully.'); window.location.href = 'user-settings-contact-person.php';</script>";
    }

    $updateContactPersonQuery->close();
  }

  $validateUpdateQuery->close();
}
?>