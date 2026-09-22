<?php
include '../auth/admin-check.php';
include '../config/db.php';

$sql = "SELECT places.*, categories.name AS category_name
        FROM places
        JOIN categories ON places.category_id = categories.id
        ORDER BY places.id DESC";
$result = $conn->query($sql);

$totalPlaces = 0;
$totalCategories = 0;

$res1 = $conn->query("SELECT COUNT(*) AS total FROM places");
if ($res1) {
    $totalPlaces = $res1->fetch_assoc()['total'];
}

$res2 = $conn->query("SELECT COUNT(*) AS total FROM categories");
if ($res2) {
    $totalCategories = $res2->fetch_assoc()['total'];
}

$adminPageTitle = "Manage POI";
$adminCurrentPage = "manage-poi";
include 'includes/admin-header.php';
?>

<div class="admin-page-wrap">
  <div class="admin-page-hero mb-4 d-flex justify-content-between align-items-center flex-wrap gap-3">
    <div>
      <h1 class="admin-page-title mb-2">Manage Places of Interest</h1>
      <p class="admin-page-subtitle mb-0">
        Add, edit, and organize place details used by the public system.
      </p>
    </div>
    <a href="add-place.php" class="btn btn-main">Add New Place</a>
  </div>

  <div class="row g-4 mb-4 mt-1">
    <div class="col-md-6 col-xl-4">
      <div class="admin-summary-card">
        <span class="admin-summary-label">Total Places</span>
        <h3><?php echo $totalPlaces; ?></h3>
        <p>Total points of interest currently stored</p>
      </div>
    </div>

    <div class="col-md-6 col-xl-4">
      <div class="admin-summary-card">
        <span class="admin-summary-label">Categories</span>
        <h3><?php echo $totalCategories; ?></h3>
        <p>Available place categories in the system</p>
      </div>
    </div>

    <div class="col-md-12 col-xl-4">
      <div class="admin-summary-card">
        <span class="admin-summary-label">Management</span>
        <h3>Enabled</h3>
        <p>Create, update, and remove public place data</p>
      </div>
    </div>
  </div>

  <div class="admin-table-card mt-2">
    <div class="admin-table-head">
      <div>
        <h4>POI Records</h4>
        <p>All registered places of interest available in SmartRoute Navigator.</p>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table admin-modern-table align-middle mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Name</th>
            <th>Category</th>
            <th>Location</th>
            <th>Distance</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td>
                  <?php
                    $imagePath = $row['image_url'];
                    if (!preg_match('/^https?:\/\//', $imagePath)) {
                        $imagePath = "../" . $imagePath;
                    }
                  ?>
                  <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="" style="width:72px; height:52px; object-fit:cover; border-radius:10px;">
                </td>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['category_name']); ?></td>
                <td><?php echo htmlspecialchars($row['location_name']); ?></td>
                <td><?php echo htmlspecialchars($row['distance_km']); ?> km</td>
                <td class="text-center">
                  <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <a href="edit-place.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-soft admin-action-btn-small">Edit</a>
                    <a href="delete-place.php?id=<?php echo $row['id']; ?>" class="btn btn-sm btn-danger admin-action-btn-small" onclick="return confirm('Are you sure you want to delete this place?');">Delete</a>
                  </div>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center py-5 text-muted" style="height: 180px;">
                No places found.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'includes/admin-footer.php'; ?>