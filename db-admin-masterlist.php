<?php

function displayUserPassword($passwordDateUpdate, $userPassword)
{
  if ($passwordDateUpdate == '') {
    return $userPassword;
  } else {
    return '';
  }
};

if (isset($_SESSION['adminId'])) {
  require "dbconnection.php";

  $viewInMasterlistQuery = $dbConnect->prepare("SELECT table1.user_id, table1.first_name, table1.middle_name, table1.last_name,
  table2.contact_number, table2.email_address, table2.home_address,
  table3.formal_picture,
  table4.user_password, table4.last_update
  FROM masterlist AS table1
  LEFT JOIN user_contact_details AS table2 ON table1.user_id = table2.user_id
  LEFT JOIN user_attachments AS table3 ON table2.user_id = table3.user_id
  LEFT JOIN user_credentials AS table4 ON table3.user_id = table4.user_id");

  if (!$viewInMasterlistQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $viewInMasterlistQuery->error);
    $viewInMasterlistQuery->close();
    exit;
  } else {
    $viewInMasterlistResult = $viewInMasterlistQuery->get_result();
    if ($viewInMasterlistResult->num_rows <= 0) {
      // No history found
      echo "<tr><td colspan='8'>No account yet</td></tr>";
    } else {
      while ($displayInMasterlist = $viewInMasterlistResult->fetch_assoc()) {
        $passwordDateUpdate = htmlspecialchars($displayInMasterlist['last_update']);
        $userPassword = htmlspecialchars($displayInMasterlist['user_password']);
        $displayUserPassword = displayUserPassword($passwordDateUpdate, $userPassword);

        echo "<tr>";
        // Formal Picture
        echo "<td><img src='" . htmlspecialchars($displayInMasterlist['formal_picture']) . "' alt='Formal Picture' style='width:30px; height:30px;'></td>";
        // User details
        echo "<td>" . htmlspecialchars($displayInMasterlist['first_name']) . "</td>";
        echo "<td>" . htmlspecialchars($displayInMasterlist['middle_name']) . "</td>";
        echo "<td>" . htmlspecialchars($displayInMasterlist['last_name']) . "</td>";
        echo "<td>" . htmlspecialchars($displayInMasterlist['contact_number']) . "</td>";
        echo "<td><a href='mailto:" . $displayInMasterlist['email_address'] . "' class='text-decoration-none'>"
          . htmlspecialchars($displayInMasterlist['email_address']) . "</td>";
        echo "<td>" . htmlspecialchars($displayInMasterlist['home_address']) . "</td>";
        echo "<td>" . $displayUserPassword . "</td>";
        // Buttons
        echo "<td><button type='button' class='btn btn-primary btn-sm rounded-0' data-bs-toggle='modal' data-bs-target='#modal{$displayInMasterlist['user_id']}'>Contact Person</button>";
        echo "<a href='admin-delete-user-account.php?userId={$displayInMasterlist['user_id']}' class='btn btn-danger btn-sm rounded-0'>delete</a></td>";
        echo "</tr>";

        // Fetch contact person details for the modal
        $viewInContactPersonQuery = $dbConnect->prepare('SELECT * FROM user_contact_person WHERE user_id = ?');
        $viewInContactPersonQuery->bind_param('i', $displayInMasterlist['user_id']);

        if ($viewInContactPersonQuery->execute()) {
          $viewInContactPersonResult = $viewInContactPersonQuery->get_result();
          if ($viewInContactPersonResult->num_rows > 0) {
            $displayInContactPerson = $viewInContactPersonResult->fetch_assoc();

            // Modal HTML
            echo "<div class='modal fade' id='modal{$displayInMasterlist['user_id']}' tabindex='-1' aria-labelledby='modalLabel{$displayInMasterlist['user_id']}' aria-hidden='true'>";
            echo "<div class='modal-dialog modal-dialog-centered modal-dialog-scrollable'>";
            echo "<div class='modal-content'>";
            echo "<div class='modal-header'>";
            echo "<h5 class='modal-title' id='modalLabel{$displayInMasterlist['user_id']}'>Contact Person</h5>";
            echo "<button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>";
            echo "</div>";
            echo "<div class='modal-body'>";
            echo "<p><strong>Full Name:</strong> " . htmlspecialchars($displayInContactPerson['contact_name']) . "</p>";
            echo "<p><strong>Relationship:</strong> " . htmlspecialchars($displayInContactPerson['contact_relationship']) . "</p>";
            echo "<p><strong>Phone Number:</strong> " . htmlspecialchars($displayInContactPerson['contact_phone']) . "</p>";
            echo "<p><strong>Address:</strong> " . htmlspecialchars($displayInContactPerson['contact_address']) . "</p>";
            echo "</div>";
            echo "<div class='modal-footer'>";
            echo "<button type='button' class='btn btn-secondary btn-sm' data-bs-dismiss='modal'>Close</button>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
            echo "</div>";
          }
        }
        $viewInContactPersonQuery->close();
      }
    }
    $viewInMasterlistQuery->close();
  }
}
?>