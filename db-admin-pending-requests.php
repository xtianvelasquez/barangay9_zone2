<?php

if (isset($_SESSION['adminId'])) {
  require "dbconnection.php";

  $requestStatus = "pending";

  $viewPendingRequestsQuery = $dbConnect->prepare("SELECT
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
  table3.request_status
  FROM masterlist AS table1
  LEFT JOIN user_contact_details AS TABLE2 ON table1.user_id = table2.user_id
  LEFT JOIN document_requests AS TABLE3 ON table2.user_id = table3.user_id
  WHERE table3.request_status = ?
  ORDER BY table3.date_request, table3.time_request");
  $viewPendingRequestsQuery->bind_param("s", $requestStatus);

  if (!$viewPendingRequestsQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $viewPendingRequestsQuery->error);
    $viewPendingRequestsQuery->close();
    exit;
  } else {
    $viewPendingRequestsResult = $viewPendingRequestsQuery->get_result();
    if ($viewPendingRequestsResult->num_rows <= 0) {
      // No history found
      echo "<tr><td colspan='11'>No pending document request yet.</td></tr>";
    } else {
      while ($displayPendingRequest = $viewPendingRequestsResult->fetch_assoc()) {
        echo "<tr>";

        echo "<td>" . htmlspecialchars($displayPendingRequest['first_name']) . "</td>";
        echo "<td>" . htmlspecialchars($displayPendingRequest['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($displayPendingRequest['contact_number']) . "</td>";
        echo "<td>" . htmlspecialchars($displayPendingRequest['home_address']) . "</td>";
        echo "<td>" . htmlspecialchars($displayPendingRequest['document']) . "</td>";
        echo "<td>" . htmlspecialchars($displayPendingRequest['request_purpose']) . "</td>";
        echo "<td>" . htmlspecialchars($displayPendingRequest['date_request']) . "</td>";
        echo "<td>" . htmlspecialchars(date("h:i A", strtotime($displayPendingRequest['time_request']))) . "</td>";

        echo "<td>";
        echo "<form action='db-admin-update-release-date.php' method='POST'>";
        echo "<input type='hidden' name='userId' value='" . htmlspecialchars($displayPendingRequest['user_id']) . "'>";
        echo "<input type='hidden' name='requestReference' value='" . htmlspecialchars($displayPendingRequest['request_reference']) . "'>";
        echo "<input type='date' name='releaseDate' id='releaseDate' class='form-control form-control-sm rounded-0' required>";
        echo "</td>";
        echo "<script language='javascript'>
                var date = new Date();
                var year = date.getUTCFullYear();
                var month = date.getMonth() + 1;
                if (month < 10) {
                  month = '0' + month;
                }
                var day = date.getDate() + 1;
                if (day < 10) {
                  day = '0' + day;
                }
                var restrictedDate = year + '-' + month + '-' + day;
                document.getElementById('releaseDate').setAttribute('min', restrictedDate);
                console.log(restrictedDate);
              </script>";

        echo "<td>" . htmlspecialchars($displayPendingRequest['request_status']) . "</td>";
        echo "<td>";
        echo "<button type='submit' class='btn btn-primary btn-sm rounded-0'>Approved</button>";
        echo "</form>";
        echo "<a href='admin-denied-request-process.php?requestReference={$displayPendingRequest['request_reference']}' class='btn btn-secondary btn-sm rounded-0'>denied</a>";
        echo "<a href='admin-delete-request-process.php?requestReference={$displayPendingRequest['request_reference']}' class='btn btn-danger btn-sm rounded-0'>delete</a>";
        echo "</td>";

        echo "</tr>";
      }
    }
    $viewPendingRequestsQuery->close();
  }
}
?>