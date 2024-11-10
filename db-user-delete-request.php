<?php
if (isset($_GET['requestReference'])) {
  require "dbconnection.php";

  $requestReference = $_GET['requestReference'];

  $deleteRequestQuery = $dbConnect->prepare("DELETE FROM document_requests WHERE request_reference = ? LIMIT 1");
  $deleteRequestQuery->bind_param("s", $requestReference);

  if (!$deleteRequestQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $deleteRequestQuery->error);
    $deleteRequestQuery->close();
    exit;
  } else {
    // Request document successfully deleted
    // Modify
    header("Location: user-view-history.php");
  }

  $deleteRequestQuery->close(); // Close prepared statement
}
?>