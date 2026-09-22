<?php
include '../config/db.php';
include '../auth/user-check.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;

$sql = "SELECT places.*, categories.name AS category_name
        FROM places
        JOIN categories ON places.category_id = categories.id
        WHERE places.id = $id";

$result = $conn->query($sql);
$place = $result->fetch_assoc();

if (!$place) {
    die("Place not found.");
}

$pageTitle = $place['name'] . " | SmartRoute Navigator";
$basePath = "../";
$currentPage = "places";
include '../includes/header.php';
?>

<section class="page-banner">
  <div class="container">
    <h1><?php echo htmlspecialchars($place['name']); ?></h1>
    <p>Detailed information about this selected point of interest</p>
  </div>
</section>

<section class="section-padding">
  <div class="container">
    <div class="row g-4">
      
      <div class="col-lg-8">
        <div class="info-card overflow-hidden">
          <?php
$imagePath = $place['image_url'] ?? '';

if (!empty($imagePath) && !preg_match('/^https?:\/\//', $imagePath)) {
    $imagePath = "../" . ltrim($imagePath, '/');
}
?>
          <?php if (!empty($place['image_url'])): ?>
  <img
    src="<?php echo htmlspecialchars($imagePath); ?>"
    alt="<?php echo htmlspecialchars($place['name']); ?>"
    style="width:100%; height:420px; object-fit:cover; border-radius:20px;"
  >
<?php else: ?>
  <div style="width:100%; height:420px; display:flex; align-items:center; justify-content:center; background:#f3f4f6; border-radius:20px; color:#64748b;">
    No image available
  </div>
<?php endif; ?>
          <div class="p-4 p-lg-5">
            <span class="place-category"><?php echo htmlspecialchars($place['category_name']); ?></span>
            <h2 class="mb-3 fw-bold"><?php echo htmlspecialchars($place['name']); ?></h2>
            <p class="text-muted mb-4">
              <?php echo nl2br(htmlspecialchars($place['description'])); ?>
            </p>

            <h5 class="fw-bold mb-3">Travel Tips</h5>
            <p class="text-muted mb-0">
              <?php echo nl2br(htmlspecialchars($place['tips'])); ?>
            </p>
          </div>
        </div>
      </div>

      <div class="col-lg-4">
        <div class="info-card p-4 mb-4">
          <h5 class="fw-bold mb-4">Place Information</h5>

          <div class="mb-3">
            <strong><i class="bi bi-tag me-2 text-primary"></i>Category:</strong>
            <div class="text-muted mt-1"><?php echo htmlspecialchars($place['category_name']); ?></div>
          </div>

          <div class="mb-3">
            <strong><i class="bi bi-geo-alt me-2 text-primary"></i>Location:</strong>
            <div class="text-muted mt-1"><?php echo htmlspecialchars($place['location_name']); ?></div>
          </div>

          <div class="mb-3">
            <strong><i class="bi bi-signpost-2 me-2 text-primary"></i>Distance:</strong>
            <div class="text-muted mt-1"><?php echo htmlspecialchars($place['distance_km']); ?> km</div>
          </div>

          <div class="mb-3">
            <strong><i class="bi bi-clock me-2 text-primary"></i>Recommended Time:</strong>
            <div class="text-muted mt-1"><?php echo htmlspecialchars($place['recommended_time']); ?></div>
          </div>

          <div class="mb-4">
            <strong><i class="bi bi-hourglass-split me-2 text-primary"></i>Estimated Visit Duration:</strong>
            <div class="text-muted mt-1"><?php echo htmlspecialchars($place['visit_duration']); ?></div>
          </div>

          <div class="d-grid gap-2">
            <a href="route.php" class="btn btn-main">View Route</a>
            <a href="trip-planner.php" class="btn btn-soft">Add to Trip Plan</a>
          </div>
        </div>

        <div class="info-card p-4">
          <h5 class="fw-bold mb-3">Map Preview</h5>
          <div class="rounded overflow-hidden" style="height: 260px;">
            <iframe
              src="<?php echo htmlspecialchars($place['map_embed_url']); ?>"
              width="100%"
              height="100%"
              style="border:0;"
              allowfullscreen=""
              loading="lazy">
            </iframe>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<section class="pb-5">
  <div class="container">
    <div class="cta-box text-center">
      <h2 class="section-title">Continue Exploring</h2>
      <p class="section-subtitle">
        Browse more attractions, check travel routes, or build your one-day travel itinerary.
      </p>
      <div class="d-flex justify-content-center flex-wrap gap-3">
        <a href="poi-list.php" class="btn btn-main">Back to Places</a>
        <a href="trip-planner.php" class="btn btn-soft">Open Trip Planner</a>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>