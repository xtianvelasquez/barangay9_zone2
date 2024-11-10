<?php
session_start();

if (isset($_SESSION['userId']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  require "dbconnection.php";

  // Current input
  $currentFormalPicture = $_POST['currentFormalPicture'];
  $currentIdCard = $_POST['currentIdCard'];

  // New input
  $userIdType = $_POST['idType'];

  date_default_timezone_set("Asia/Manila");
  $dateUpdate = date("Y-m-d");

  $validateUpdateQuery = $dbConnect->prepare("SELECT last_update FROM user_attachments WHERE user_id = ? LIMIT 1");
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
        echo "<script>alert('Updating attachments is done once a day only.'); window.location.href = 'user-settings-attachments.php';</script>";
        exit;
      }
    }

    // File upload handling
    if (isset($_FILES['formalPicture']) && isset($_FILES['idCard'])) {
      $formalPicture = $_FILES['formalPicture']['tmp_name'];
      $idCard = $_FILES['idCard']['tmp_name'];

      // Checking file error
      $formalPictureError = $_FILES['formalPicture']['error'];
      $idCardError = $_FILES['idCard']['error'];
      if ($formalPictureError !== UPLOAD_ERR_OK || $idCardError !== UPLOAD_ERR_OK) {
        // An error occurred while uploading files
        // Modify
        echo "<script>alert('An unexpected error occurred while processing your request. Please try again later.'); window.location.href = 'user-settings-attachments.php';</script>";
        exit;
      }

      // Checking file extension
      $allowedExtension = array('png', 'jpg', 'jpeg');
      $formalPictureName = $_FILES['formalPicture']['name'];
      $idCardName = $_FILES['idCard']['name'];
      $formalPictureExtension = strtolower(pathinfo($formalPictureName, PATHINFO_EXTENSION));
      $idCardExtension = strtolower(pathinfo($idCardName, PATHINFO_EXTENSION));
      if (!in_array($formalPictureExtension, $allowedExtension) || !in_array($idCardExtension, $allowedExtension)) {
        // Invalid file extension
        // Modify
        echo "<script>alert('An unexpected error occurred while processing your request. Please try again later.'); window.location.href = 'user-settings-attachments.php';</script>";
        exit;
      }

      // Checking file size
      $formalPictureSize = $_FILES['formalPicture']['size'];
      $idCardSize = $_FILES['idCard']['size'];
      if ($formalPictureSize >= 10000000 || $idCardSize >= 10000000) {
        // File size is too large. Maximum size allowed is 10MB
        // Modify
        echo "<script>alert('An unexpected error occurred while processing your request. Please try again later.'); window.location.href = 'user-settings-attachments.php';</script>";
        exit;
      }

      // File directory
      $targetDirectory = 'uploads/';
      $userFormalPicturePath = $targetDirectory . uniqid() . '.' . pathinfo($_FILES['formalPicture']['name'], PATHINFO_EXTENSION);
      $userIdCardPath = $targetDirectory . uniqid() . '.' . pathinfo($_FILES['idCard']['name'], PATHINFO_EXTENSION);

      // Move uploaded files
      if (!move_uploaded_file($formalPicture, $userFormalPicturePath) || !move_uploaded_file($idCard, $userIdCardPath)) {
        // Failed to move uploaded files to the target directory
        // Modify
        echo "<script>alert('An unexpected error occurred while processing your request. Please try again later.'); window.location.href = 'user-settings-attachments.php';</script>";
        exit;
      }

      // Unlink old files (if necessary)
      if (!empty($currentFormalPicture) && !empty($currentIdCard)) {
        unlink($currentFormalPicture);
        unlink($currentIdCard);
      }
    }

    // Update user_attachments table
    $updateAttachmentQuery = $dbConnect->prepare("UPDATE user_attachments SET formal_picture = ?, id_type = ?, id_card = ?, last_update = ? WHERE user_id = ? LIMIT 1");
    $updateAttachmentQuery->bind_param("ssssi", $userFormalPicturePath, $userIdType, $userIdCardPath, $dateUpdate, $_SESSION['userId']);
    if (!$updateAttachmentQuery->execute()) {
      // Log error and exit
      error_log("Failed to execute query: " . $updateAttachmentQuery->error);
      $updateAttachmentQuery->close();
      exit;
    } else {
      // Successfully updated
      // Modify
      echo "<script>alert('Update successfully.'); window.location.href = 'user-settings-attachments.php';</script>";
    }
    $updateAttachmentQuery->close();
  }

  $validateUpdateQuery->close();
}
?>