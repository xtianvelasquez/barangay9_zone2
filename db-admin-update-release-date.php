<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require("dbconnection.php");

  $userId = intval($_POST['userId']);
  $requestReference = $_POST['requestReference'];
  $releaseDate = $_POST['releaseDate'];
  $requestStatus = "approved";

  $updateDocumentRequestQuery = $dbConnect->prepare("UPDATE document_requests
  SET date_release = ?, request_status = ?
  WHERE user_id = ? AND request_reference = ? LIMIT 1");
  $updateDocumentRequestQuery->bind_param("ssis", $releaseDate, $requestStatus, $userId, $requestReference);

  if (!$updateDocumentRequestQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $updateDocumentRequestQuery->error);
    $updateDocumentRequestQuery->close();
    exit;
  }

  header("Location: admin-document-requests.php");
  $updateDocumentRequestQuery->close();
}
?>