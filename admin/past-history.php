<?php
include '../auth/admin-check.php';
include '../config/db.php';

$result = $conn->query("SELECT * FROM trip_plans WHERE status = 'Completed' ORDER BY id DESC");

$totalCompleted = 0;
if ($result) {
    $totalCompleted = $result->num_rows;
}

$adminPageTitle = "Past History";
$adminCurrentPage = "past-history";
include 'includes/admin-header.php';
?>

<div class="admin-page-wrap">
  <div class="admin-page-hero mb-4">
    <div>
      <h1 class="admin-page-title mb-2">Past History</h1>
      <p class="admin-page-subtitle mb-0">
        Review completed travel plans and previously finalized user itineraries.
      </p>
    </div>
  </div>

  <div class="row g-4 mb-4 mt-1">
    <div class="col-md-6 col-xl-4">
      <div class="admin-summary-card">
        <span class="admin-summary-label">Completed Plans</span>
        <h3><?php echo $totalCompleted; ?></h3>
        <p>Total plans moved to history</p>
      </div>
    </div>

    <div class="col-md-6 col-xl-4">
      <div class="admin-summary-card">
        <span class="admin-summary-label">History Status</span>
        <h3>Archived</h3>
        <p>Completed and stored travel records</p>
      </div>
    </div>

    <div class="col-md-12 col-xl-4">
      <div class="admin-summary-card">
        <span class="admin-summary-label">Access</span>
        <h3>Read</h3>
        <p>Used for review, evidence, and monitoring</p>
      </div>
    </div>
  </div>

  <div class="admin-table-card mt-2">
    <div class="admin-table-head">
      <div>
        <h4>Completed Plan Records</h4>
        <p>All travel plans with status marked as Completed.</p>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table admin-modern-table align-middle mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>User</th>
            <th>Start Point</th>
            <th>Start Time</th>
            <th>Trip Type</th>
            <th>Selected Places</th>
            <th>Total Distance</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                <td><?php echo htmlspecialchars($row['start_point']); ?></td>
                <td><?php echo htmlspecialchars($row['start_time']); ?></td>
                <td><?php echo htmlspecialchars($row['trip_type']); ?></td>
                <td><?php echo htmlspecialchars($row['selected_places']); ?></td>
                <td><?php echo htmlspecialchars($row['total_distance']); ?> km</td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="text-center py-5 text-muted" style="height: 180px;" >
                No completed travel history found.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'includes/admin-footer.php'; ?>