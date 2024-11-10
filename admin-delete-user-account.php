<?php
session_start();

if (isset($_GET['userId'])) {
  require "dbconnection.php";

  $userId = intval($_GET['userId']);

  // Prepare statement to get user attachments
  $getUserAttachmentsQuery = $dbConnect->prepare("SELECT formal_picture, id_card FROM user_attachments WHERE user_id = ? LIMIT 1");
  $getUserAttachmentsQuery->bind_param("i", $userId);

  // Prepare statement to delete the account
  $deleteAccountQuery = $dbConnect->prepare("DELETE FROM masterlist WHERE user_id = ? LIMIT 1");
  $deleteAccountQuery->bind_param("i", $userId);

  // Execute query to get user attachments
  if (!$getUserAttachmentsQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $getUserAttachmentsQuery->error);
    $getUserAttachmentsQuery->close();
    exit;
  }

  $userAttachmentsResult = $getUserAttachmentsQuery->get_result();
  if ($userAttachmentsResult->num_rows === 1) {
    $displayUserAttachments = $userAttachmentsResult->fetch_assoc();
    $formalPicture = $displayUserAttachments['formal_picture'];
    $idCard = $displayUserAttachments['id_card'];

    // Check if files exist before attempting to delete
    $filesDeleted = true;
    if (file_exists($formalPicture)) {
      $filesDeleted = $filesDeleted && unlink($formalPicture);
    }
    if (file_exists($idCard)) {
      $filesDeleted = $filesDeleted && unlink($idCard);
    }

    // Attempt to delete the user account if files were deleted successfully
    if ($filesDeleted && $deleteAccountQuery->execute()) {
      header("Location: admin-masterlist.php");
      exit;
    } else {
      error_log("Error deleting attachments or user account");
      exit("An unexpected error occurred while processing your request. Please try again later.");
    }
  } else {
    // Handle case where no attachments are found
    error_log("No attachments found for user ID: $userId");
    exit("No attachments found for the specified user.");
  }

  // Close queries and database connection
  $getUserAttachmentsQuery->close();
  $deleteAccountQuery->close();
  $dbConnect->close();
} else {
  
  exit("Invalid request: userId is not set.");
}
?>