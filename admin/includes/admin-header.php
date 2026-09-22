<?php
if (!isset($adminPageTitle)) {
    $adminPageTitle = "Admin Panel";
}

if (!isset($adminCurrentPage)) {
    $adminCurrentPage = "";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $adminPageTitle; ?> | SmartRoute Navigator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/admin.css" rel="stylesheet">
</head>
<body class="admin-body">

<nav class="admin-topbar">
  <div class="container-fluid px-4 d-flex justify-content-between align-items-center">
    <a href="dashboard.php" class="admin-brand">SmartRoute <span>Admin</span></a>
    <div class="d-flex align-items-center gap-3">
      <span class="text-white small">
        Welcome, <?php echo htmlspecialchars($_SESSION['admin_username'] ?? 'Admin'); ?>
      </span>
      <a href="logout.php" class="btn btn-light btn-sm">Logout</a>
    </div>
  </div>
</nav>

<div class="admin-layout">
  <aside class="admin-sidebar">
    <h6>Navigation</h6>
    <ul class="admin-menu">
      <li>
        <a href="dashboard.php" class="<?php echo ($adminCurrentPage === 'dashboard') ? 'active' : ''; ?>">
          Dashboard
        </a>
      </li>
      <li>
        <a href="manage-poi.php" class="<?php echo ($adminCurrentPage === 'manage-poi') ? 'active' : ''; ?>">
          Manage POI
        </a>
      </li>
      <li>
        <a href="add-place.php" class="<?php echo ($adminCurrentPage === 'add-place') ? 'active' : ''; ?>">
          Add New Place
        </a>
      </li>
      <li>
        <a href="../pages/poi-list.php">
          View Public Site
        </a>
      </li>
      <li>
  <a href="feedback.php" class="<?php echo ($adminCurrentPage === 'feedback') ? 'active' : ''; ?>">
    Feedback & Reviews
  </a>
</li>
<li>
  <a href="current-plans.php" class="<?php echo ($adminCurrentPage === 'current-plans') ? 'active' : ''; ?>">
    Current Travel Plans
  </a>
</li>
<li>
  <a href="past-history.php" class="<?php echo ($adminCurrentPage === 'past-history') ? 'active' : ''; ?>">
    Past History
  </a>
</li>
    </ul>
  </aside>

  <main class="admin-content"></main>