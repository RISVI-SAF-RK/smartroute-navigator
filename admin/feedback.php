<?php
include '../auth/admin-check.php';
include '../config/db.php';

$result = $conn->query("SELECT * FROM feedback ORDER BY id DESC");

$totalFeedback = 0;
$avgRating = 0;

$countRes = $conn->query("SELECT COUNT(*) AS total, AVG(rating) AS avg_rating FROM feedback");
if ($countRes) {
    $stats = $countRes->fetch_assoc();
    $totalFeedback = $stats['total'] ?? 0;
    $avgRating = $stats['avg_rating'] ? number_format($stats['avg_rating'], 1) : 0;
}

$adminPageTitle = "Feedback & Reviews";
$adminCurrentPage = "feedback";
include 'includes/admin-header.php';
?>

<div class="admin-page-wrap">
  <div class="admin-page-hero mb-4">
    <div>
      <h1 class="admin-page-title mb-2">Feedback & Reviews</h1>
      <p class="admin-page-subtitle mb-0">
        Review ratings, comments, and suggestions submitted by users.
      </p>
    </div>
  </div>

  <div class="row g-4 mb-4 mt-1">
    <div class="col-md-6 col-xl-4">
      <div class="admin-summary-card">
        <span class="admin-summary-label">Total Feedback</span>
        <h3><?php echo $totalFeedback; ?></h3>
        <p>Total number of submitted feedback records</p>
      </div>
    </div>

    <div class="col-md-6 col-xl-4">
      <div class="admin-summary-card">
        <span class="admin-summary-label">Average Rating</span>
        <h3><?php echo $avgRating; ?>/5</h3>
        <p>Overall user satisfaction score</p>
      </div>
    </div>

    <div class="col-md-12 col-xl-4">
      <div class="admin-summary-card">
        <span class="admin-summary-label">Review Status</span>
        <h3>Open</h3>
        <p>Feedback available for analysis and improvement</p>
      </div>
    </div>
  </div>

  <div class="admin-table-card mt-2">
    <div class="admin-table-head">
      <div>
        <h4>Feedback Records</h4>
        <p>All user reviews and ratings submitted through the system.</p>
      </div>
    </div>

    <div class="table-responsive">
      <table class="table admin-modern-table align-middle mb-0">
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Rating</th>
            <th>Message</th>
            <th>Date</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <tr>
                <td>#<?php echo $row['id']; ?></td>
                <td><?php echo htmlspecialchars($row['user_name']); ?></td>
                <td><?php echo htmlspecialchars($row['user_email']); ?></td>
                <td><?php echo htmlspecialchars($row['rating']); ?>/5</td>
                <td style="min-width: 280px;"><?php echo htmlspecialchars($row['message']); ?></td>
                <td><?php echo htmlspecialchars($row['created_at']); ?></td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center py-5 text-muted" style="height: 180px;">
                No feedback found.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include 'includes/admin-footer.php'; ?>