<?php
session_start();

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
  <link rel="stylesheet" href="CSS/user-request-document.css">

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
  ?>

  <section class="bg-light py-4">
    <div class="container bg-light">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card rounded-0">

            <div class="card-header">Request Document</div>

            <div class="card-body p-3">
              <form action="db-user-request-document.php" method="post" autocomplete="off">
                <!--document-->
                <div class="form-group mb-3">
                  <label for="documentRequest"><b>Select Document</b></label>
                  <select class="form-select rounded-0" name="documentRequest" id="userDocumentRequest" style="margin-top: 10px;">
                    <option value="Barangay ID">Barangay ID</option>
                    <option value="Barangay Clearance">Barangay Clearance</option>
                    <option value="Certificate of Residency">Certificate of Residency</option>
                    <option value="Certificate of Indigency">Certificate of Indigency</option>
                  </select>
                </div>
                <!--purpose-->
               <div class="form-group mb-4">
                 <label for="purposeRequest"><b>Purpose</b></label>
                   <textarea class="form-control rounded-0" name="purposeRequest" id="userPurposeRequest" style="margin-top: 10px; margin-bottom: 20px; height: 200px;" maxlength="500" required></textarea>
                     <small class="form-text text-muted">
                      <ul class="list-style">
                        <li class="do-not">Do not start with "for" (huwag magsimula sa "para sa").</li>
                        <li class="do-not">Do not use punctuation marks at the end (huwag gumamit ng mga bantas sa dulo).</li>
                        <li class="purpose">Purpose must fit within the context of the word "for" (dapat kasya ang layunin sa konteksto ng salitang "para sa").</li>
                        <li class="example-text"><b>Halimbawa : employment purpose, school enrollment, medical assistance, business permit application, government benefits, at iba pa.</b></li>
                        </ul>
                    </small>
                </div>
                <!--submit-->
                <input type="submit" value="Submit" class="btn btn-primary w-100 rounded-0" style="font-weight: bold;"></input>
              </form>
            </div>

          </div>
        </div>
      </div>
    </div>
  </section>
<footer>
      <div class="container" >
          <p>Copyright &copy; <?php echo date("Y"); ?> Barangay 9 Zone 2. All rights reserved. | Designed by BSIT 2-1 From PLM.</p>
      </div>
  </footer>
<script src="bootstrap/js/bootstrap.min.js?v=5.3"></script>
</body>

</html>