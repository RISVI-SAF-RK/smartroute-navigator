<?php
include '../auth/user-check.php';
include '../config/db.php';

$pageTitle = "My Plans | SmartRoute Navigator";
$basePath = "../";
$currentPage = "";

$userName = $_SESSION['full_name'] ?? 'User';

$stmt = $conn->prepare("SELECT * FROM trip_plans WHERE user_name = ? ORDER BY id DESC");
$stmt->bind_param("s", $userName);
$stmt->execute();
$result = $stmt->get_result();

include '../includes/header.php';
?>

<section class="section-padding" style="padding-top: 48px;">
  <div class="container">
    <div class="page-header text-center">
      <h1><i class="bi bi-journal-text me-2" style="color:var(--primary);"></i>My Travel Plans</h1>
      <p>View your saved itineraries and continue planning your next visit.</p>
    </div>

    <div class="row g-4">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <?php
            $placeIds = array_filter(array_map('trim', explode(',', $row['selected_places'])));
            $placeNames = [];

            if (!empty($placeIds)) {
                $safeIds = implode(',', array_map('intval', $placeIds));
                $placesRes = $conn->query("SELECT name FROM places WHERE id IN ($safeIds)");
                if ($placesRes) {
                    while ($p = $placesRes->fetch_assoc()) {
                        $placeNames[] = $p['name'];
                    }
                }
            }
          ?>

          <div class="col-lg-6">
            <div class="place-card">
              <div class="place-top">
                <div class="place-emoji">🗺️</div>
                <div>
                  <h3><?php echo htmlspecialchars($row['trip_type']); ?></h3>
                  <div style="color:var(--muted); font-size:1rem;">
                    <?php echo htmlspecialchars($row['created_at']); ?>
                  </div>
                </div>
              </div>

              <p>
                This plan starts from <strong><?php echo htmlspecialchars($row['start_point']); ?></strong>
                at <strong><?php echo htmlspecialchars($row['start_time']); ?></strong>.
              </p>

              <div class="place-meta">
                <span><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($row['start_point']); ?></span>
                <span><i class="bi bi-clock"></i> <?php echo htmlspecialchars($row['start_time']); ?></span>
                <span><i class="bi bi-signpost"></i> <?php echo htmlspecialchars($row['total_distance']); ?> km</span>
              </div>

              <div class="mt-3">
                <strong style="display:block; margin-bottom:10px;">Selected Places</strong>
                <div class="d-flex flex-wrap gap-2">
                  <?php if (!empty($placeNames)): ?>
                    <?php foreach ($placeNames as $name): ?>
                      <span class="category-pill pill-heritage" style="margin:0;">
                        <?php echo htmlspecialchars($name); ?>
                      </span>
                    <?php endforeach; ?>
                  <?php else: ?>
                    <span style="color:var(--muted);">No places found</span>
                  <?php endif; ?>
                </div>
              </div>

              <div class="mt-4 d-flex flex-wrap gap-3">
                <a href="trip-planner.php" class="btn btn-main">Plan Again</a>
                <a href="route.php" class="btn btn-soft">Open Route Map</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="info-card p-5 text-center">
            <h3 class="mb-3">No saved travel plans yet</h3>
            <p class="text-muted mb-4">
              You have not created any trip plans yet. Start building your one-day itinerary now.
            </p>
            <a href="trip-planner.php" class="btn btn-main">Create Trip Plan</a>
          </div>
        </div>
      <?php endif; ?>
    </div>

    <div class="help-footer mt-5">
      <h3 style="font-size:2rem;">Keep Exploring Mihintale</h3>
      <p style="color:var(--muted); margin-bottom:20px;">
        Revisit your saved plans, create a new itinerary, or explore more attractions around the Mihintale area.
      </p>
      <div class="d-flex justify-content-center flex-wrap gap-3">
        <a href="trip-planner.php" class="btn btn-main">New Trip Plan</a>
        <a href="poi-list.php" class="btn btn-soft">Browse Places</a>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>