<?php
// Generate unique request reference
function generateRequestReference($length = 10)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $requestReference = '';
  for ($i = 0; $i < $length; $i++) {
    $requestReference .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $requestReference;
}

session_start();

if (isset($_SESSION['userId']) && $_SERVER['REQUEST_METHOD'] === 'POST') {
  require "dbconnection.php";

  $requestReference = generateRequestReference();
  $documentRequest = $_POST['documentRequest'];
  $requestPurpose = $_POST['purposeRequest'];

  // Date and time request
  date_default_timezone_set("Asia/Manila");
  $dateRequest = date("Y-m-d");
  $timeRequest = date("h:i A");

  // Default values
  $requestStatusDefault = "pending";

  $documentRequestQuery = $dbConnect->prepare("INSERT INTO document_requests(user_id, request_reference, document, request_purpose, date_request, time_request, request_status) VALUES(?, ?, ?, ?, ?, ?, ?)");
  $documentRequestQuery->bind_param("issssss", $_SESSION['userId'], $requestReference, $documentRequest, $requestPurpose, $dateRequest,  $timeRequest, $requestStatusDefault);

  if (!$documentRequestQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $documentRequestQuery->error);
    $documentRequestQuery->close();
    exit;
  } else {
    // Request successfully submitted
    // Modify
    echo "<script>alert('Request successfully submitted.'); window.location.href = 'user-request-document.php';</script>";
  }

  $documentRequestQuery->close();
}
?>