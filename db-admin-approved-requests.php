<?php

function redirectTo($approvedDocument)
{

  if ($approvedDocument == "Barangay ID") {
    return "generate-id.php";
  } else {
    return "generate-document.php";
  }
}

if (isset($_SESSION['adminId'])) {
  require "dbconnection.php";

  $requestStatus = "approved";

  $viewApprovedRequestsQuery = $dbConnect->prepare("SELECT
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
  $viewApprovedRequestsQuery->bind_param("s", $requestStatus);

  if (!$viewApprovedRequestsQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $viewApprovedRequestsQuery->error);
    $viewApprovedRequestsQuery->close();
    exit;
  } else {
    $viewApprovedRequestsResult = $viewApprovedRequestsQuery->get_result();
    if ($viewApprovedRequestsResult->num_rows <= 0) {
      // No history found
      echo "<tr><td colspan='11'>No approved requests yet.</td></tr>";
    } else {
      while ($displayApprovedRequest = $viewApprovedRequestsResult->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($displayApprovedRequest['first_name']) . "</td>";
        echo "<td>" . htmlspecialchars($displayApprovedRequest['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($displayApprovedRequest['contact_number']) . "</td>";
        echo "<td>" . htmlspecialchars($displayApprovedRequest['home_address']) . "</td>";
        echo "<td>" . htmlspecialchars($displayApprovedRequest['document']) . "</td>";
        $approvedDocument = htmlspecialchars($displayApprovedRequest['document']);
        echo "<td>" . htmlspecialchars($displayApprovedRequest['request_purpose']) . "</td>";
        echo "<td>" . htmlspecialchars($displayApprovedRequest['date_request']) . "</td>";
        echo "<td>" . htmlspecialchars(date("h:i A", strtotime($displayApprovedRequest['time_request']))) . "</td>";
        echo "<td>" . htmlspecialchars($displayApprovedRequest['date_release']) . "</td>";
        echo "<td>" . htmlspecialchars($displayApprovedRequest['request_status']) . "</td>";
        echo "<td>";
        echo "<a href='" . redirectTo($approvedDocument) . "?requestReference={$displayApprovedRequest['request_reference']}' class='btn btn-success btn-sm rounded-0'>generate</a>";
        echo "<a href='admin-completed-transcation-process.php?requestReference={$displayApprovedRequest['request_reference']}' class='btn btn-secondary btn-sm rounded-0'>completed</a>";
        echo "<a href='admin-delete-request-process.php?requestReference={$displayApprovedRequest['request_reference']}' class='btn btn-danger btn-sm rounded-0'>delete</a>";
        echo "</td>";
        echo "</tr>";
      }
    }

    $viewApprovedRequestsQuery->close();
  }
}
?>