<?php

if (isset($_SESSION['userId'])) {
  require "dbconnection.php";

  $viewHistoryQuery = $dbConnect->prepare("SELECT request_reference, document, request_purpose, date_request, time_request, date_release, request_status FROM document_requests WHERE user_id = ? ORDER BY date_request, time_request");
  $viewHistoryQuery->bind_param("i", $_SESSION['userId']);

  if (!$viewHistoryQuery->execute()) { 
    // Log error and exit
    error_log("Failed to execute query: " . $viewHistoryQuery->error);
    $viewHistoryQuery->close();
    exit;
  } else {
    $viewHistoryResult = $viewHistoryQuery->get_result();
    if ($viewHistoryResult->num_rows <= 0) {
      // No history found
      echo "<tr><td colspan='7'>No history found</td></tr>";
    } else {
      while ($displayHistory = $viewHistoryResult->fetch_assoc()) {
        $releaseDate = $displayHistory['date_release'];
        echo "<tr>";
        echo "<td>" . htmlspecialchars($displayHistory['document']) . "</td>";
        echo "<td>" . htmlspecialchars($displayHistory['request_purpose']) . "</td>";
        echo "<td>" . htmlspecialchars($displayHistory['date_request']) . "</td>";
        echo "<td>" . htmlspecialchars(date("h:i A", strtotime($displayHistory['time_request']))) . "</td>";
        echo "<td>" . htmlspecialchars($displayHistory['date_release']) . "</td>";
        echo "<td>" . htmlspecialchars($displayHistory['request_status']) . "</td>";
        echo "<td><a href='db-user-delete-request.php?requestReference={$displayHistory['request_reference']}' class='btn btn-danger btn-sm rounded-0'>delete</a></td>";
        echo "</tr>";
      }
    }
    
    $viewHistoryQuery->close();
  }
}
?>