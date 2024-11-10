<?php
session_start();

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
  <link rel="stylesheet" href="CSS/user-settings.css">
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
  include "user-settings-subattachments.php";
  ?>

  <section class="bg-light py-4" id="generalInformations">
    <div class="row justify-content-center mx-3 mx-sm-0 g-3 gap-3">
      <div class="col-sm-3">
        <div class="btn-group g-2 row">
          <a href="user-settings-general.php" class="btn btn-secondary rounded-0">Update General Details</a>
          <a href="user-settings-contact.php" class="btn btn-outline-secondary">Update Contact Details</a>
          <a href="user-settings-attachments.php" class="btn btn-outline-secondary">Update Attachments</a>
          <a href="user-settings-password.php" class="btn btn-outline-secondary">Change Password</a>
          <a href="user-settings-contact-person.php" class="btn btn-outline-secondary rounded-0">Contact Person</a>
          <a href="user-delete-account.php" class="btn btn-outline-secondary rounded-0">Delete Account</a>
        </div>
      </div>
      <div class="col-sm-4 my-3">
        <div class="card rounded-0">

          <div class="card-header">Update Attachments</div>

          <div class="card-body p-3">
            <form action="db-user-settings-attachments.php" method="post" autocomplete="off" enctype="multipart/form-data">
              <!--formal picture-->
              <div class="col d-block mb-4">
                <label for="formalPicture">Please attach your formal picture here</label>
                <input type="file" name="formalPicture" id="formalPicture" class="form-control rounded-0" required>
                <p class="form-text">Please ensure that you provide a clearer image. Below 10 MB in size. With only png, jpg or jpeg file extension.</p>
              </div>
              <!--id card-->
              <div class="col d-block mb-4">
                <label for="idCard">Please attach your ID here</label>
                <input type="file" name="idCard" id="idCard" class="form-control rounded-0" required>
                <p class="form-text">Please ensure that you provide a clearer image. Below 10 MB in size. With only png, jpg or jpeg file extension.</p>
              </div>
              <!--id type-->
              <div class="col d-block mb-4">
                <label for="idType">ID Type</label>
                <select name="idType" id="idType" class='form-select rounded-0'>
                  <option value="national id">National ID</option>
                  <option value="passport">Passport</option>
                  <option value="philhealth">PhilHealth</option>
                  <option value="postal ID">Postal ID</option>
                  <option value="driver's license">Driver's License</option>
                  <option value="student id">School ID</option>
                  <option value="others">Others</option>
                </select>
              </div>
              <!--hidden input-->
              <input type="hidden" value="<?php echo $currentFormalPicture ?>" name="currentFormalPicture">
              <input type="hidden" value="<?php echo $currentIdCard ?>" name="currentIdCard">
              <!--submit-->
              <div class="col d-block mb-2">
                <input type="submit" value="Update" class="btn btn-outline-primary rounded-0 w-100">
              </div>
            </form>
          </div>

          <div class="card-footer"><b>Last update on : </b><span><?php echo $lastDateUpdate ?></span></div>

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