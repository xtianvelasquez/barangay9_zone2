<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Styled Navbar</title>
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.5.0/font/bootstrap-icons.min.css" rel="stylesheet">
  <link rel="stylesheet" href="CSS/user-navbar.css">
  
</head>

<body>
  <nav class="navbar py-2">
    <div class="container-fluid">
      <i class="navbar-toggler border-0 rounded-0 bi bi-list fs-2" type="button" data-bs-toggle="offcanvas" data-bs-target="#userNavbar"></i>
      <div class="offcanvas offcanvas-start" tabindex="-1" id="userNavbar">
        <div class="offcanvas-header">
          <p class="offcanvas-title text-white" style="margin-left: 30px";>MENU</p>
          <i class="bi bi-x-lg text-white" role="button" data-bs-dismiss="offcanvas"></i>
        </div>
        <div class="offcanvas-body">
          <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
            <li class="nav-item">
              <a class="nav-link" href="user-profile.php">
                <i class="bi bi-person"></i>
                My Profile
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user-request-document.php">
                <i class="bi bi-file-earmark-arrow-up"></i>
                Request Document
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user-view-history.php">
                <i class="bi bi-calendar-event"></i>
                View History
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user-settings-general.php">
                <i class="bi bi-gear"></i>
                Settings
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="user-logout.php">
                <i class="bi bi-box-arrow-left"></i>
                Logout
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </nav>

  <!-- Bootstrap JS -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>
  
</body>
</html>
