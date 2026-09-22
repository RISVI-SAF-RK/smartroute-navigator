<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($pageTitle)) $pageTitle = "SmartRoute Navigator";
if (!isset($basePath)) $basePath = "";
if (!isset($currentPage)) $currentPage = "";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $pageTitle; ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="<?php echo $basePath; ?>assets/css/theme.css">
</head>
<body>

<nav class="navbar navbar-expand-lg custom-navbar">
  <div class="container-fluid px-4">
    <a class="navbar-brand" href="<?php echo $basePath; ?>index.php">
      SmartRoute Navigator
      <span class="brand-small">Mihintale Travel Guide</span>
    </a>

    <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item"><a class="nav-link <?php echo ($currentPage=='home')?'active':''; ?>" href="<?php echo $basePath; ?>index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link <?php echo ($currentPage=='places')?'active':''; ?>" href="<?php echo $basePath; ?>pages/poi-list.php">Tourist Places</a></li>
        <li class="nav-item"><a class="nav-link <?php echo ($currentPage=='route')?'active':''; ?>" href="<?php echo $basePath; ?>pages/route.php">Route Map</a></li>
        <li class="nav-item"><a class="nav-link <?php echo ($currentPage=='planner')?'active':''; ?>" href="<?php echo $basePath; ?>pages/trip-planner.php">Trip Planner</a></li>
        <li class="nav-item"><a class="nav-link <?php echo ($currentPage=='feedback')?'active':''; ?>" href="<?php echo $basePath; ?>pages/feedback.php">Feedback</a></li>
        <li class="nav-item"><a class="nav-link <?php echo ($currentPage=='help')?'active':''; ?>" href="<?php echo $basePath; ?>pages/help.php">Help</a></li>

        <?php if (isset($_SESSION['user_id'])): ?>
          <?php if ($_SESSION['role'] === 'admin'): ?>
            <li class="nav-item ms-lg-2"><a class="btn btn-main" href="<?php echo $basePath; ?>admin/dashboard.php">Admin Panel</a></li>
          <?php else: ?>
            <li class="nav-item ms-lg-2"><a class="btn btn-main" href="<?php echo $basePath; ?>pages/user-dashboard.php">My Dashboard</a></li>
          <?php endif; ?>
          <li class="nav-item ms-lg-2"><a class="btn btn-soft" href="<?php echo $basePath; ?>auth/logout.php">Logout</a></li>
        <?php else: ?>
          <li class="nav-item ms-lg-2"><a class="btn btn-main" href="<?php echo $basePath; ?>auth/login.php">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>