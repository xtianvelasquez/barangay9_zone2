<?php
session_start();

if (isset($_GET['requestReference'])) {
  require("dbconnection.php");

  $requestStatus = "completed";

  $updateRequestStatusQuery = $dbConnect->prepare("UPDATE document_requests
  SET request_status = ?
  WHERE request_reference = ? LIMIT 1");
  $updateRequestStatusQuery->bind_param("ss", $requestStatus, $_GET['requestReference']);

  if (!$updateRequestStatusQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $updateRequestStatusQuery->error);
    $updateRequestStatusQuery->close();
    exit;
  }

  header("Location: admin-document-requests.php");
  $updateRequestStatusQuery->close();
}
?>