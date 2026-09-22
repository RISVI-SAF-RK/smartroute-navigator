<?php
include '../config/db.php';

$pageTitle = "Route Map | SmartRoute Navigator";
$basePath = "../";
$currentPage = "route";

$places = [];
$result = $conn->query("SELECT id, name, category_id, distance_km, visit_duration,description, map_embed_url FROM places ORDER BY id ASC");
if ($result) {
    while ($row = $result->fetch_assoc()) {
        $places[] = $row;
    }
}

$selectedId = isset($_GET['place_id']) ? (int)$_GET['place_id'] : 0;
$selectedPlace = null;

if ($selectedId > 0) {
    $stmt = $conn->prepare("SELECT places.*, categories.name AS category_name
                            FROM places
                            JOIN categories ON places.category_id = categories.id
                            WHERE places.id = ?");
    $stmt->bind_param("i", $selectedId);
    $stmt->execute();
    $selectedPlace = $stmt->get_result()->fetch_assoc();
}

include '../includes/header.php';
?>

<section class="section-padding" style="padding-top: 48px;">
  <div class="container">
    <div class="page-header">
      <h1><i class="bi bi-send me-2" style="color:var(--primary);"></i>Route Map</h1>
      <p>Click a place to view on map</p>
    </div>

    <div class="row g-4">
      <div class="col-lg-12">
        <div class="d-flex flex-column gap-3 mb-4">
          <?php foreach ($places as $place): ?>
            <?php
              $emoji = "📍";
              $subtitle = "~" . $place['distance_km'] . " km · " . $place['visit_duration'];

              $catId = (int)$place['category_id'];
              if ($catId === 1) $emoji = "🛕";
              if ($catId === 2) $emoji = "🌿";
              if ($catId === 3) $emoji = "🏺";
              if ($catId === 4) $emoji = "🎭";
            ?>
            <a href="?place_id=<?php echo $place['id'];?>#map-preview" class="place-card" style="padding:22px 28px;">
              <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="d-flex align-items-center gap-3">
                  <div class="place-emoji" style="font-size:1.9rem;"><?php echo $emoji; ?></div>
                  <div>
  <h5 style="margin:0; font-size:1.7rem;"><?php echo htmlspecialchars($place['name']); ?></h5>
  <div style="color:var(--muted); font-size:1rem; margin-top:4px;">
    <?php echo htmlspecialchars($subtitle); ?>
  </div>
  <div style="color:var(--muted); font-size:0.98rem; margin-top:10px; line-height:1.6; max-width:900px;">
    <?php echo htmlspecialchars(mb_strimwidth($place['description'], 0, 140, '...')); ?>
  </div>
</div>
                </div>

                <?php if ($selectedId === (int)$place['id']): ?>
                  <span class="category-pill pill-heritage" style="margin:0;">Viewing on Map</span>
                <?php endif; ?>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </div>

      <div class="col-lg-12" id="map-preview">
        <div class="info-card p-0 overflow-hidden position-relative">
          <div style="height: 520px;">
            <?php if ($selectedPlace): ?>
              <iframe
                src="<?php echo htmlspecialchars($selectedPlace['map_embed_url']); ?>"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy">
              </iframe>
            <?php else: ?>
              <iframe
                src="https://www.google.com/maps?q=Mihintale&output=embed"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy">
              </iframe>
            <?php endif; ?>
          </div>

          <div class="info-card p-4" style="position:absolute; right:20px; bottom:20px; width:280px; z-index:5;">
            <h5 class="fw-bold mb-3">Categories</h5>
            <div class="d-flex flex-column gap-2" style="color:var(--muted);">
              <div><span class="category-pill pill-religious" style="margin:0;">Religious</span></div>
              <div><span class="category-pill pill-nature" style="margin:0;">Nature</span></div>
              <div><span class="category-pill pill-heritage" style="margin:0;">Heritage</span></div>
              <div><span class="category-pill pill-cultural" style="margin:0;">Cultural</span></div>
            </div>
          </div>
        </div>
      </div>

      <?php if ($selectedPlace): ?>
        <div class="col-lg-12">
          <div class="info-card p-4 mt-2">
            <h3 class="mb-3"><?php echo htmlspecialchars($selectedPlace['name']); ?></h3>
            <p class="text-muted mb-3"><?php echo htmlspecialchars($selectedPlace['description']); ?></p>
            <div class="place-meta">
              <span><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($selectedPlace['location_name']); ?></span>
              <span><i class="bi bi-clock"></i> <?php echo htmlspecialchars($selectedPlace['visit_duration']); ?></span>
              <span><i class="bi bi-signpost"></i> ~<?php echo htmlspecialchars($selectedPlace['distance_km']); ?> km</span>
            </div>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>