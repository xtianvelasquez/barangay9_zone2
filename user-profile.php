<?php
session_start();

// Set the time zone to Manila, Philippines
date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['userId'])) {
  // Redirect to the login
  header("Location: user-login.php");
  exit;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Barangay 9 Zone 2 Official Website</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="CSS/user-profile.css">
  <link rel="icon" href="assets/brgylogo_9.png">
</head>

<body>
  
<header class="navbar navbar-dark bg-dark">
    <div class="container d-flex justify-content-between align-items-center">
        <div>
            <a class="navbar-brand" href="#">
                <img src="CSS/brgyl.jpg" width="35" height="30" class="d-inline-block align-top" alt="">
                <strong class="light-up">
                  <span>B</span><span>a</span><span>r</span><span>a</span><span>n</span><span>g</span><span>a</span><span>y</span> <span>9</span> <span>Z</span><span>o</span><span>n</span><span>e</span> <span>2</span>
                </strong>
            </a>
        </div>
        <div class="text-white font-weight-bold" style="text-align: right;">
            <?php echo date("l, F j, Y") . " " . date("h:i A"); ?>
        </div>
    </div>
</header>

<?php
include "user-navbar.php";
include "db-user-profile.php";
?>

<section class="bg-light py-4">
  <div class="container bg-light">
    <div class="row justify-content-center mx-3 mx-md-0 g-3 gap-3">
      <div class="col-auto col-md-4"> <!--formal picture-->
        <img src="<?php echo $formalPicture ?>" alt='Formal Picture' class='img-fluid rounded-circle' style="margin-left: -50px" style="margin-right: 150px";>
      </div>
      <div class="col-md-6">

        <div class="card rounded-2 mb-4">
          <div class="card-header">Personal Informations</div>
          <div class="card-body"> <!--personal informations-->
            <p class="mb-0"><b>First Name : </b><?php echo $firstName ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>Middle Name : </b><?php echo $middleName ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>Last Name : </b><?php echo $lastName ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>Gender : </b><?php echo $gender ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>Birthdate : </b><?php echo $birthdate ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>Contact Number : </b><?php echo $contactNum ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>Email Address : </b><?php echo $emailAddress ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>Home Address : </b><?php echo $homeAddress ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>Residency : </b><?php echo $residency ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>Years in Barangay : </b><?php echo $residentYears ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>ID Type : </b><?php echo $idType ?></p>
            <hr class="mt-0">
            <img src="<?php echo $idCard ?>" alt="ID Image" class="img-fluid">
          </div>
        </div>

        <div class="card rounded-2">
          <div class="card-header">Contact Person Informations</div>
          <div class="card-body">
            <p class="mb-0"><b>Name : </b><?php echo $contactName ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>Relationship : </b><?php echo $contactRelationship ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>Contact Number : </b><?php echo $contactPhone ?></p>
            <hr class="mt-0">
            <p class="mb-0"><b>Home Address : </b><?php echo $contactAddress ?></p>
            <hr class="mt-0">
          </div>
        </div>

      </div>
    </div>
  </div>
</section>
<footer>
      <div class="container">
          <p>Copyright &copy; <?php echo date("Y"); ?> Barangay 9 Zone 2. All rights reserved. | Designed by BSIT 2-1 From PLM.</p>
      </div>
  </footer>
<script src="bootstrap/js/bootstrap.min.js?v=5.3"></script>
</body>

</html>
