<?php
session_start();

if (isset($_SESSION['userId'])) {
  require "dbconnection.php";

  $userId = intval($_SESSION['userId']);

  // Delete attachments
  $getUserAttachmentsQuery = $dbConnect->prepare("SELECT formal_picture, id_card FROM user_attachments WHERE user_id = ? LIMIT 1");
  $getUserAttachmentsQuery->bind_param("i", $userId);

  // Delete account
  $deleteAccountQuery = $dbConnect->prepare("DELETE FROM masterlist WHERE user_id = ? LIMIT 1");
  $deleteAccountQuery->bind_param("i", $userId);

  if (!$getUserAttachmentsQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $getUserAttachmentsQuery->error);
    $getUserAttachmentsQuery->close();
    exit;
  }

  $userAttachmentsResult = $getUserAttachmentsQuery->get_result();
  if ($userAttachmentsResult->num_rows == 1) {
    $displayUserAttachments = $userAttachmentsResult->fetch_assoc();
    $formalPicture = $displayUserAttachments['formal_picture'];
    $idCard = $displayUserAttachments['id_card'];

    if (!unlink($formalPicture) || !unlink($idCard) || !$deleteAccountQuery->execute()) {
      // Error
      // Modify
      error_log("Error deleting attachments or user account");

      // Error
      // Modify
      exit("An unexpected error occurred while processing your request. Please try again later.");
    } else {
      // Delete session and redirect
      session_unset();
      session_destroy();
      exit(header("Location: user-login.php"));
    }
  }

  // Close queries
  $getUserAttachmentsQuery->close();
  $deleteAccountQuery->close();
  $dbConnect->close();
}
?>