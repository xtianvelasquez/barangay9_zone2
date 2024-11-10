<?php
if (isset($_SESSION['userId'])) {
  require "dbconnection.php";

  // User informations
  $getAllInformations = "SELECT * FROM masterlist AS table1 
  LEFT JOIN user_contact_details AS table2 ON table2.user_id = table1.user_id
  LEFT JOIN user_personal_details AS table3 ON table3.user_id = table2.user_id
  LEFT JOIN user_attachments AS table4 ON table4.user_id = table3.user_id
  LEFT JOIN user_contact_person AS table5 ON table4.user_id = table5.user_id
  WHERE table1.user_id = ? LIMIT 1;";
  $allInformationsQuery = $dbConnect->prepare($getAllInformations);
  $allInformationsQuery->bind_param('i', $_SESSION['userId']);

  if (!$allInformationsQuery->execute()) {
    // Log error and exit
    error_log("Failed to execute query: " . $allInformationsQuery->error);
    $allInformationsQuery->close();
    exit;
  } else {
    $allInformationsResult = $allInformationsQuery->get_result();

    if ($allInformationsResult->num_rows == 1) {
      $displayAllInformations = $allInformationsResult->fetch_assoc();

      $formalPicture = htmlspecialchars($displayAllInformations['formal_picture']);
      $firstName = htmlspecialchars($displayAllInformations['first_name']);
      $middleName = htmlspecialchars($displayAllInformations['middle_name']);
      $lastName = htmlspecialchars($displayAllInformations['last_name']);
      $gender = htmlspecialchars($displayAllInformations['gender']);
      $birthdate = htmlspecialchars($displayAllInformations['birthdate']);
      $contactNum = htmlspecialchars($displayAllInformations['contact_number']);
      $emailAddress = htmlspecialchars($displayAllInformations['email_address']);
      $homeAddress = htmlspecialchars($displayAllInformations['home_address']);
      $residency = htmlspecialchars($displayAllInformations['residency']);
      $residentYears = htmlspecialchars($displayAllInformations['resident_years']);
      $idType = htmlspecialchars($displayAllInformations['id_type']);
      $idCard = htmlspecialchars($displayAllInformations['id_card']);
      $contactName = htmlspecialchars($displayAllInformations['contact_name']);
      $contactRelationship = htmlspecialchars($displayAllInformations['contact_relationship']);
      $contactPhone = htmlspecialchars($displayAllInformations['contact_phone']);
      $contactAddress = htmlspecialchars($displayAllInformations['contact_address']);
    } else {
      // No information found
      // Modify
      echo "No information found for the current user.";
    }
    
    $allInformationsQuery->close();
  }
}
?>