<?php
include '../auth/admin-check.php';
include '../config/db.php';

$totalPlaces = 0;
$totalCategories = 0;

$result1 = $conn->query("SELECT COUNT(*) AS total FROM places");
if ($result1) {
    $totalPlaces = $result1->fetch_assoc()['total'];
}

$result2 = $conn->query("SELECT COUNT(*) AS total FROM categories");
if ($result2) {
    $totalCategories = $result2->fetch_assoc()['total'];
}

$adminPageTitle = "Dashboard";
$adminCurrentPage = "dashboard";
include 'includes/admin-header.php';
?>

<div class="dashboard-wrap">
  <div class="dashboard-header mb-4">
    <span class="badge bg-primary">Admin Panel</span>
    <h1 class="admin-page-title mt-3">Dashboard</h1>
    <p class="admin-page-subtitle">Manage places, categories, and overall system content.</p>
  </div>

  <div class="row g-4">
    <div class="col-12 col-xl-8">
      <div class="admin-card dashboard-main-card p-4 p-lg-5">
        <h3 class="fw-bold mb-3">Welcome to SmartRoute Admin</h3>
        <p class="text-muted mb-4">
          Use this dashboard to manage points of interest, update place details, and monitor your tourism information system.
        </p>

        <div class="d-flex flex-wrap gap-3">
          <a href="manage-poi.php" class="btn btn-main">Manage Places</a>
          <a href="add-place.php" class="btn btn-soft">Add New Place</a>
        </div>
      </div>
    </div>

    <div class="col-12 col-xl-4">
      <div class="row g-3">
        <div class="col-12 col-md-4 col-xl-12">
          <div class="admin-card admin-stat">
            <h3><?php echo $totalPlaces; ?></h3>
            <p>Total Places</p>
          </div>
        </div>

        <div class="col-12 col-md-4 col-xl-12">
          <div class="admin-card admin-stat">
            <h3><?php echo $totalCategories; ?></h3>
            <p>Total Categories</p>
          </div>
        </div>

        <div class="col-12 col-md-4 col-xl-12">
          <div class="admin-card admin-stat">
            <h3>Active</h3>
            <p>System Status</p>
          </div>
        </div>
      </div>
    </div>

    <div class="col-12">
      <div class="admin-card p-4">
        <h4 class="fw-bold mb-4">Quick Actions</h4>
        <div class="row g-3">
          <div class="col-md-4">
            <a href="manage-poi.php" class="btn btn-main w-100">Manage POI</a>
          </div>
          <div class="col-md-4">
            <a href="add-place.php" class="btn btn-soft w-100">Add New Place</a>
          </div>
          <div class="col-md-4">
            <a href="../pages/poi-list.php" class="btn btn-soft w-100">Open Public Site</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'includes/admin-footer.php'; ?>