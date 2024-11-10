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
  <title>Barangay 9 Zone 2 Official Admin Website</title>
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css?v=5.3">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link rel="stylesheet" href="CSS/admin-masterlist.css">
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

  <section class="bg-light py-4">
    <div class="container bg-light">
      <div class="table-responsive">
        <table class="table table-bordered caption-top">
          <caption>Masterlist</caption>
          <thead>
            <tr>
              <th scope="col">Profile</th>
              <th scope="col">First Name</th>
              <th scope="col">Middle Name</th>
              <th scope="col">Last Name</th>
              <th scope="col">Contact Number</th>
              <th scope="col">Email Address</th>
              <th scope="col">Home Address</th>
              <th scope="col">Password</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
            <?php include "db-admin-masterlist.php" ?>
          </tbody>
        </table>
      </div>
    </div>
  </section>

  <div id="greeting-popup"></div>

  <script src="bootstrap/js/bootstrap.min.js?v=5.3"></script>
  <script>
    function showGreeting() {
      const now = new Date();
      const hours = now.getHours();
      let greeting;
      if (hours < 12) {
        greeting = 'Good Morning, Secretary :)';
      } else if (hours < 18) {
        greeting = 'Good Afternoon, Secretary :)';
      } else {
        greeting = 'Good Evening, Secretary :)';
      }

      const popup = document.getElementById('greeting-popup');
      popup.textContent = greeting;
      popup.style.display = 'block';
      console.log("Greeting shown:", greeting); 

      setTimeout(() => {
        popup.style.display = 'none';
        console.log("Greeting hidden"); 
      }, 10000);
    }

    window.onload = showGreeting;
    console.log("Script loaded"); 
  </script>
</body>

</html>
