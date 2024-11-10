<?php
session_start();

if (isset($_SESSION['userId'])) {
  // Redirect to the user profile
  header("Location: user-profile.php");
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
  <link rel="stylesheet" href="CSS/user-login.css">
  <link rel="icon" href="assets/brgylogo_9.png">
  <style>
    .toggle-password-btn:hover {
      background-color: #16a085;
    }

    .toggle-password-btn:hover .bi {
      color: white;
    }
  </style>
</head>

<body>
  <div class="container d-flex w-100 vh-100 justify-content-center align-items-center">
    <div class="card rounded-2">
      <div class="card-header">User Login</div>
      <div class="card-body px-3 px-lg-5 py-2 py-lg-4">
        <form action="db-user-login.php" method="post" autocomplete="off">
          <!--username-->
          <div class="input-group mb-3">
            <div class="input-group-text rounded-0"><i class="bi bi-person"></i></div>
            <input type="text" name="userUsername" maxlength="100" class="form-control rounded-0" required placeholder="Username">
          </div>
          <!--password-->
          <div class="input-group mb-3">
            <div class="input-group-text rounded-0"><i class="bi bi-lock-fill"></i></div>
            <input type="password" id="userPassword" name="userPassword" maxlength="100" class="form-control rounded-0" required placeholder="Password">
            <button type="button" class="btn btn-outline-secondary rounded-0 toggle-password-btn" onclick="togglePasswordVisibility()">
              <i id="passwordToggleIcon" class="bi bi-eye"></i>
            </button>
          </div>
          <!--submit-->
          <input type="submit" value="Login" class="btn btn-outline-primary rounded-0 w-100 mb-3">
        </form>
        <p class="text-center">Don't have an account? <a href="user-signup.php" class="text-decoration-none">Sign up here</a></p>
      </div>
    </div>
  </div>

  <script src="bootstrap/js/bootstrap.min.js?v=5.3"></script>
  <script>
    function togglePasswordVisibility() {
      const passwordField = document.getElementById('userPassword');
      const passwordToggleIcon = document.getElementById('passwordToggleIcon');
      if (passwordField.type === 'password') {
        passwordField.type = 'text';
        passwordToggleIcon.classList.remove('bi-eye');
        passwordToggleIcon.classList.add('bi-eye-slash');
      } else {
        passwordField.type = 'password';
        passwordToggleIcon.classList.remove('bi-eye-slash');
        passwordToggleIcon.classList.add('bi-eye');
      }
    }
  </script>
</body>

</html>