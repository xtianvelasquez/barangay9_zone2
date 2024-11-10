<?php
// Generate random password
function generateRandomPassword($length = 8)
{
  $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
  $password = '';
  for ($i = 0; $i < $length; $i++) {
    $password .= $characters[rand(0, strlen($characters) - 1)];
  }
  return $password;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  require "dbconnection.php";

  $firstName = ucwords(trim($_POST['firstName']));
  $middleName = trim($_POST['middleName']);
  $lastName = trim($_POST['lastName']);
  $gender = trim($_POST['gender']);
  $birthdate = trim($_POST['birthdate']);
  $contactNumber = trim("+63" . $_POST['contactNumber']);
  $emailAddress = filter_var(trim($_POST['emailAddress']), FILTER_SANITIZE_EMAIL);
  $homeAddress = trim($_POST['homeAddress']);
  $residency = trim($_POST['residency']);
  $residentYears = filter_var(trim($_POST['residentYears']), FILTER_SANITIZE_NUMBER_INT);
  $idType = trim($_POST['idType']);

  $contactName = ucwords(trim($_POST['contactName']));
  $contactRelationship = ucfirst(trim($_POST['contactRelationship']));
  $contactPhone = trim("+63" . $_POST['contactPhone']);
  $contactAddress = trim($_POST['contactAddress']);

  if (isset($_FILES['formalPicture']) && isset($_FILES['idCard'])) {

    // Checking file error
    $formalPictureError = $_FILES['formalPicture']['error'];
    $idCardError = $_FILES['idCard']['error'];
    if ($formalPictureError !== UPLOAD_ERR_OK || $idCardError !== UPLOAD_ERR_OK) {
      echo "<script>alert('Error uploading files. Please try again later.'); window.location.href = 'user-signup.php';</script>";
      exit;
    }

    // Checking file extension
    $allowedExtensions = array('png', 'jpg', 'jpeg');
    $formalPictureName = $_FILES['formalPicture']['name'];
    $idCardName = $_FILES['idCard']['name'];
    $formalPictureExtension = strtolower(pathinfo($formalPictureName, PATHINFO_EXTENSION));
    $idCardExtension = strtolower(pathinfo($idCardName, PATHINFO_EXTENSION));
    if (!in_array($formalPictureExtension, $allowedExtensions) || !in_array($idCardExtension, $allowedExtensions)) {
      echo "<script>alert('Invalid file type. Only PNG, JPG, and JPEG files are allowed.'); window.location.href = 'user-signup.php';</script>";
      exit;
    }

    // Checking file size
    $formalPictureSize = $_FILES['formalPicture']['size'];
    $idCardSize = $_FILES['idCard']['size'];
    if ($formalPictureSize >= 10000000 || $idCardSize >= 10000000) {
      echo "<script>alert('File size too large. Maximum size allowed is 10MB.'); window.location.href = 'user-signup.php';</script>";
      exit;
    }

    // Validate account
    $validateAccount = "SELECT first_name, middle_name, last_name, NULL AS email_address, NULL AS contact_number FROM masterlist
    WHERE first_name = ? AND middle_name = ? AND last_name = ?
    UNION
    SELECT NULL, NULL, NULL, email_address, contact_number FROM user_contact_details
    WHERE email_address = ? OR contact_number = ?";
    $validateAccountQuery = $dbConnect->prepare($validateAccount);
    $validateAccountQuery->bind_param("sssss", $firstName, $middleName, $lastName, $emailAddress, $contactNumber);

    if (!$validateAccountQuery->execute()) {
      // Log error and exit
      error_log("Failed to execute query: " . $validateAccountQuery->error);
      $validateAccountQuery->close();
      exit;
    } else {
      $validateAccountResult = $validateAccountQuery->get_result();

      if ($validateAccountResult->num_rows >= 1) {
        echo "<script>alert('An account with the same information already exists.'); window.location.href = 'user-signup.php';</script>";
        $validateAccountQuery->close();
        exit;
      }

      $validateAccountQuery->close();
    }

    // Ensure upload directory exists
    $targetDirectory = 'uploads/';
    if (!is_dir($targetDirectory)) {
      mkdir($targetDirectory, 0755, true);
    }

    // Generate unique file paths
    $formalPicturePath = $targetDirectory . uniqid() . '.' . $formalPictureExtension;
    $idCardPath = $targetDirectory . uniqid() . '.' . $idCardExtension;
    if (!move_uploaded_file($_FILES['formalPicture']['tmp_name'], $formalPicturePath) || !move_uploaded_file($_FILES['idCard']['tmp_name'], $idCardPath)) {
      echo "<script>alert('Error moving uploaded files. Please try again later.'); window.location.href = 'user-signup.php';</script>";
      exit;
    }

    // Generate user credentials
    $userUsername = $emailAddress;
    $userPassword = generateRandomPassword();

    // Insert into masterlist table
    $masterlistQuery = $dbConnect->prepare("INSERT INTO masterlist(first_name, middle_name, last_name) VALUES (?, ?, ?)");
    $masterlistQuery->bind_param("sss", $firstName, $middleName, $lastName);
    if (!$masterlistQuery->execute()) {
      // Log error and exit
      error_log("Failed to execute query: " . $validateAccountQuery->error);
      $validateAccountQuery->close();
      exit;
    }

    // Get user id
    $userId = $dbConnect->insert_id;

    // Insert into user_contact_details table
    $userContactDetailsQuery = $dbConnect->prepare("INSERT INTO user_contact_details(user_id, contact_number, email_address, home_address) VALUES (?, ?, ?, ?)");
    $userContactDetailsQuery->bind_param("isss", $userId, $contactNumber, $emailAddress, $homeAddress);

    // Insert into user_personal_details table
    $userPersonalDetailsQuery = $dbConnect->prepare("INSERT INTO user_personal_details(user_id, gender, birthdate, residency, resident_years) VALUES (?, ?, ?, ?, ?)");
    $userPersonalDetailsQuery->bind_param("isssi", $userId, $gender, $birthdate, $residency, $residentYears);

    // Insert into user_attachments table
    $userAttachmentsQuery = $dbConnect->prepare("INSERT INTO user_attachments(user_id, formal_picture, id_type, id_card) VALUES (?, ?, ?, ?)");
    $userAttachmentsQuery->bind_param("isss", $userId, $formalPicturePath, $idType, $idCardPath);

    // Insert into user_credentials table
    $userCredentialsQuery = $dbConnect->prepare("INSERT INTO user_credentials(user_id, user_username, user_password) VALUES (?, ?, ?)");
    $userCredentialsQuery->bind_param("iss", $userId, $userUsername, $userPassword);

    // Insert into user_contact_person table
    $userContactPersonQuery = $dbConnect->prepare("INSERT INTO user_contact_person(user_id, contact_name, contact_relationship, contact_phone, contact_address) VALUES (?, ?, ?, ?, ?)");
    $userContactPersonQuery->bind_param("issss", $userId, $contactName, $contactRelationship, $contactPhone, $contactAddress);

    if (!$userContactDetailsQuery->execute() || !$userPersonalDetailsQuery->execute() || !$userAttachmentsQuery->execute() || !$userCredentialsQuery->execute() || !$userContactPersonQuery->execute()) {
      echo "<script>alert('Error inserting user details. Please try again later.'); window.location.href = 'user-signup.php';</script>";
      exit;
    } else {
      echo "<script>alert('User data uploaded successfully.'); window.location.href = 'user-login.php';</script>";
    }

    // Closing prepared statements
    $masterlistQuery->close();
    $userContactDetailsQuery->close();
    $userPersonalDetailsQuery->close();
    $userAttachmentsQuery->close();
    $userCredentialsQuery->close();
    $userContactPersonQuery->close();
  } else {
    echo "<script>alert('File upload error. Please try again.'); window.location.href = 'user-signup.php';</script>";
    exit;
  }
}
?>