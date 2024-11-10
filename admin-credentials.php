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
  <link rel="stylesheet" href="CSS/admin-credentials.css">
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

          <div class="card-header">Update Admin Credentials</div>

          <div class="card-body p-3">
            <form action="db-admin-credentials.php" method="post" autocomplete="off">
              <!--first name-->
              <div class="col d-block mb-3">
                <label for="adminName">Full Name</label>
                <input type="text" name="adminName" id="adminName" maxlength="100" class='form-control rounded-0' required>
              </div>
              <!--admin role-->
              <div class="col d-block mb-3">
                <label for="adminRole">Admin Role</label>
                <input type="text" name="adminRole" id="adminRole" value="<?php echo $_SESSION['adminRole'] ?>" class="form-control rounded-0" readonly>
              </div>
              <!--admin username-->
              <div class="col d-block mb-3">
                <label for="adminUsername">Username</label>
                <input type="text" name="adminUsername" id="adminUsername" maxlength="100" class="form-control rounded-0" required>
              </div>
              <!--admin password-->
              <div class="col d-block mb-3">
                <label for="adminPassword">Password</label>
                <input type="password" name="adminPassword" id="adminPassword" maxlength="100" class="form-control rounded-0" required>
              </div>
              <!--submit-->
              <div class="col d-block mb-2">
                <input type="submit" value="Update" class="btn btn-outline-primary rounded-0 w-100" style="font-weight: bold;"></input>
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