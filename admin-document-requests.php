<?php
session_start();

date_default_timezone_set('Asia/Manila');

if (!isset($_SESSION['adminId'])) {
  // Redirect to the user profile
  header("Location: admin-login.php");
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
  <link rel="stylesheet" href="CSS/admin-docureq.css">
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

  <?php include "admin-navbar.php" ?>

  <!--pending request-->
  <section id="pending-requests" class="pt-3 pb-1 px-3 bg-light">
    <div class="table-responsive">
      <table class="table table-bordered caption-top">
        <caption>Pending Requests</caption>
        <thead>
          <tr>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Contact Number</th>
            <th scope="col">Home Address</th>
            <th scope="col">Document</th>
            <th scope="col">Purpose</th>
            <th scope="col">Date of Request</th>
            <th scope="col">Time of Request</th>
            <th scope="col">Date of Release</th>
            <th scope="col">Request Status</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php include "db-admin-pending-requests.php" ?>
        </tbody>
      </table>
    </div>
    
  </section>

  <!--approved request-->
  <section id="approved-requests" class="pt-2 pb-1 px-3 bg-light">
    <div class="table-responsive">
      <table class="table table-bordered caption-top">
        <caption>Approved Requests</caption>
        <thead>
          <tr>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Contact Number</th>
            <th scope="col">Home Address</th>
            <th scope="col">Document</th>
            <th scope="col">Purpose</th>
            <th scope="col">Date of Request</th>
            <th scope="col">Time of Request</th>
            <th scope="col">Date of Release</th>
            <th scope="col">Request Status</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php include "db-admin-approved-requests.php" ?>
        </tbody>
      </table>
    </div>
  </section>

  <!--completed transaction-->
  <section id="completed-transaction" class="pt-2 pb-1 px-3 bg-light">
    <div class="table-responsive">
      <table class="table table-bordered caption-top">
        <caption>Completed Transaction</caption>
        <thead>
          <tr>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Contact Number</th>
            <th scope="col">Home Address</th>
            <th scope="col">Document</th>
            <th scope="col">Purpose</th>
            <th scope="col">Date of Request</th>
            <th scope="col">Time of Request</th>
            <th scope="col">Date of Release</th>
            <th scope="col">Request Status</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php include "db-admin-completed-transaction.php" ?>
        </tbody>
      </table>
    </div>
  </section>

  <!--denied request-->
  <section id="denied-request" class="pt-1 pb-3 px-3 bg-light">
    <div class="table-responsive">
      <table class="table table-bordered caption-top">
        <caption>Denied Request</caption>
        <thead>
          <tr>
            <th scope="col">First Name</th>
            <th scope="col">Last Name</th>
            <th scope="col">Contact Number</th>
            <th scope="col">Home Address</th>
            <th scope="col">Document</th>
            <th scope="col">Purpose</th>
            <th scope="col">Date of Request</th>
            <th scope="col">Time of Request</th>
            <th scope="col">Date of Release</th>
            <th scope="col">Request Status</th>
            <th scope="col">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php include "db-admin-denied-request.php" ?>
        </tbody>
      </table>
    </div>
  </section>

  <script src="bootstrap/js/bootstrap.min.js?v=5.3"></script>
  <footer>
      <div class="container">
          <p>Copyright &copy; <?php echo date("Y"); ?> Barangay 9 Zone 2. All rights reserved. | Designed by BSIT 2-1 From PLM.</p>
      </div>
  </footer>
</body>

</html>