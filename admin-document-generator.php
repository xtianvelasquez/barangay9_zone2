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
  <link rel="icon" href="assets/brgylogo_9.png">
  <link rel="stylesheet" href="CSS/admin-docugenerator.css">
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
  include "admin-navbar.php";
  ?>

  <section class="bg-light py-4">
    <div class="row justify-content-center mx-3 mx-sm-0 g-3 gap-3">
      <div class="col-sm-4 my-3">
        <div class="card rounded-0">

          <div class="card-header">Generate Barangay Document</div>

          <div class="card-body p-3">
            <form action="db-admin-document-generator.php" method="post" autocomplete="off">
              <!--first name-->
              <div class="col d-block mb-3">
                <label for="requesterName">Name</label>
                <input type="text" name="requesterName" id="requesterName" maxlength="100" class='form-control rounded-0' required>
              </div>
              <!--gender-->
              <div class="col d-block mb-3">
                <label for="gender">Gender</label>
                <select name="gender" id="gender" class="form-select rounded-0">
                  <option value="male">Male</option>
                  <option value="female">Female</option>
                  <option value="others">Others</option>
                </select>
              </div>
              <!--birthdate-->
              <div class="col d-block mb-3">
                <label for="birthdate">Birthdate</label>
                <input type="date" name="birthdate" id="birthdate" class="form-control rounded-0" required>
              </div>
              <!--home address-->
              <div class="col d-block mb-3">
                <label for="homeAddress">Complete Address</label>
                <textarea name="homeAddress" id="homeAddress" maxlength="500" class="form-control rounded-0" required></textarea>
              </div>
              <!--document-->
              <div class="form-group mb-3">
                <label for="documentRequest">Select Document</label>
                <select class="form-select rounded-0" name="documentRequest" id="userDocumentRequest">
                  <option value="Barangay Clearance">Barangay Clearance</option>
                  <option value="Certificate of Residency">Certificate of Residency</option>
                  <option value="Certificate of Indigency">Certificate of Indigency</option>
                </select>
              </div>
              <!--purpose-->
              <div class="form-group mb-3">
                <label for="purposeRequest">Purpose</label>
                   <textarea class="form-control rounded-0" name="purposeRequest" id="userPurposeRequest" style="margin-bottom: 20px; height: 200px;" maxlength="500" required></textarea>
                     <small class="form-text text-muted">
                      <ul class="list-style">
                        <li class="do-not">Do not start with "for" (huwag magsimula sa "para sa").</li>
                        <li class="do-not">Do not use punctuation marks at the end (huwag gumamit ng mga bantas sa dulo).</li>
                        <li class="purpose">Purpose must fit within the context of the word "for" (dapat kasya ang layunin sa konteksto ng salitang "para sa").</li>
                        <li class="example-text"><b>Halimbawa : employment purpose, school enrollment, medical assistance, business permit application, government benefits, at iba pa.</b></li>
                        </ul>
                    </small>
              </div>
              <!--release date-->
              <div class="col d-block mb-4">
                <label for="releaseDate">Release Date</label>
                <input type="date" name="releaseDate" id="releaseDate" class="form-control rounded-0" required>
              </div>
              <!--submit-->
              <div class="col d-block mb-2">
                <input type="submit" value="Generate" class="btn btn-outline-primary rounded-0 w-100" style="font-weight: bold;"></input>
              </div>
            </form>
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