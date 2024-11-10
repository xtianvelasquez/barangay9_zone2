<?php

if (isset($_SESSION['adminId'])) {
  require "dbconnection.php";

  $requestStatus = "completed";

  $viewCompletedTransactionQuery = $dbConnect->prepare("SELECT
  table1.user_id,
  table1.first_name,
  table1.last_name,
  table2.contact_number,
  table2.home_address,
  table3.request_reference,
  table3.document,
  table3.request_purpose,
  table3.date_request,
  table3.time_request,
  table3.date_release,
  table3.request_status
  FROM masterlist AS table1
  LEFT JOIN user_contact_details AS TABLE2 ON table1.user_id = table2.user_id
  LEFT JOIN document_requests AS TABLE3 ON table2.user_id = TABLE3.user_id
  WHERE table3.request_status = ?
  ORDER BY table3.date_request, table3.time_request");
  $viewCompletedTransactionQuery->bind_param("s", $requestStatus);

  if (!$viewCompletedTransactionQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $viewCompletedTransactionQuery->error);
    $viewCompletedTransactionQuery->close();
    exit;
  } else {
    $viewCompletedTransactionResult = $viewCompletedTransactionQuery->get_result();
    if ($viewCompletedTransactionResult->num_rows <= 0) {
      // No history found
      echo "<tr><td colspan='11'>No completed transaction of document request yet.</td></tr>";
    } else {
      while ($displayCompletedTransactionRequest = $viewCompletedTransactionResult->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($displayCompletedTransactionRequest['first_name']) . "</td>";
        echo "<td>" . htmlspecialchars($displayCompletedTransactionRequest['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($displayCompletedTransactionRequest['contact_number']) . "</td>";
        echo "<td>" . htmlspecialchars($displayCompletedTransactionRequest['home_address']) . "</td>";
        echo "<td>" . htmlspecialchars($displayCompletedTransactionRequest['document']) . "</td>";
        echo "<td>" . htmlspecialchars($displayCompletedTransactionRequest['request_purpose']) . "</td>";
        echo "<td>" . htmlspecialchars($displayCompletedTransactionRequest['date_request']) . "</td>";
        echo "<td>" . htmlspecialchars(date("h:i A", strtotime($displayCompletedTransactionRequest['time_request']))) . "</td>";
        echo "<td>" . htmlspecialchars($displayCompletedTransactionRequest['date_release']) . "</td>";
        echo "<td>" . htmlspecialchars($displayCompletedTransactionRequest['request_status']) . "</td>";
        echo "<td>";
        echo "<a href='admin-delete-request-process.php?requestReference={$displayCompletedTransactionRequest['request_reference']}' class='btn btn-danger btn-sm rounded-0'>delete</a>";
        echo "</td>";
        echo "</tr>";
      }
    }

    $viewCompletedTransactionQuery->close();
  }
}
?>