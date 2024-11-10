<?php
session_start();

if (isset($_SESSION['userId']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  require "dbconnection.php";

  $firstName = $_POST['firstName'];
  $middleName = $_POST['middleName'];
  $lastName = $_POST['lastName'];
  $gender = $_POST['gender'];
  $birthdate = $_POST['birthdate'];
  $residency = $_POST['residency'];
  $residentYears = filter_var($_POST['residentYears'], FILTER_SANITIZE_NUMBER_INT);

  date_default_timezone_set("Asia/Manila");
  $dateUpdate = date("Y-m-d");

  $validateUpdateQuery = $dbConnect->prepare("SELECT last_update FROM user_personal_details WHERE user_id = ? LIMIT 1");
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
        echo "<script>alert('Updating general details is done once a day only.'); window.location.href = 'user-settings-general.php';</script>";
        exit;
      }
    }

    // Update general details
    $updateGeneralDetails = "UPDATE masterlist AS table1
    LEFT JOIN user_personal_details AS table2 ON table1.user_id = table2.user_id
    SET table1.first_name = ?, table1.middle_name = ?, table1.last_name = ?,
    table2.gender = ?, table2.birthdate = ?, table2.residency = ?, table2.resident_years = ?, table2.last_update = ?
    WHERE table1.user_id = ?";
    $updateGeneralDetailsQuery = $dbConnect->prepare($updateGeneralDetails);
    $updateGeneralDetailsQuery->bind_param("ssssssisi", $firstName, $middleName, $lastName, $gender, $birthdate, $residency, $residentYears, $dateUpdate, $_SESSION['userId']);
    if (!$updateGeneralDetailsQuery->execute()) {
      // Log error and exit
      error_log("Failed to execute query: " . $updateGeneralDetailsQuery->error);
      $updateGeneralDetailsQuery->close();
      exit;
    } else {
      echo "<script>alert('Update successfully.'); window.location.href = 'user-settings-general.php';</script>";
    }
    $updateGeneralDetailsQuery->close();
  }
  $validateUpdateQuery->close();
}
?>