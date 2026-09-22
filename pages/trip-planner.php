<?php
include '../config/db.php';
include '../auth/user-check.php';

$pageTitle = "Trip Planner | SmartRoute Navigator";
$basePath = "../";
$currentPage = "planner";

$startPoint = isset($_GET['start_point']) ? trim($_GET['start_point']) : 'Kanadara Katukeliyawa Ihalagama';
$startTime = isset($_GET['start_time']) ? trim($_GET['start_time']) : '06:00';
$tripType = isset($_GET['trip_type']) ? trim($_GET['trip_type']) : 'One-Day Trip';
$selectedPlaces = isset($_GET['places']) && is_array($_GET['places']) ? array_map('intval', $_GET['places']) : [];

$allPlaces = [];
$res = $conn->query("SELECT places.*, categories.name AS category_name
                     FROM places
                     JOIN categories ON places.category_id = categories.id
                     ORDER BY places.id ASC");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $allPlaces[] = $row;
    }
}

$selectedData = [];
$totalDistance = 0;

if (!empty($selectedPlaces)) {
    $ids = implode(',', $selectedPlaces);
    $sql = "SELECT places.*, categories.name AS category_name
            FROM places
            JOIN categories ON places.category_id = categories.id
            WHERE places.id IN ($ids)
            ORDER BY places.distance_km ASC";
    $result = $conn->query($sql);

    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $selectedData[] = $row;
            $totalDistance += (float)$row['distance_km'];
        }
    }

    if (isset($_SESSION['user_id'])) {
        $selectedPlacesText = implode(',', $selectedPlaces);
        $userName = $_SESSION['full_name'] ?? 'Guest User';

        $save = $conn->prepare("INSERT INTO trip_plans (user_name, start_point, start_time, trip_type, selected_places, total_distance, status)
                                VALUES (?, ?, ?, ?, ?, ?, 'Current')");
        $save->bind_param("sssssd", $userName, $startPoint, $startTime, $tripType, $selectedPlacesText, $totalDistance);
        $save->execute();
    }
}

include '../includes/header.php';
?>

<section class="section-padding" style="padding-top: 48px;">
  <div class="container">
    <div class="page-header text-center">
      <h1><i class="bi bi-calendar-event me-2" style="color:var(--primary);"></i>One-Day Trip Planner</h1>
      <p>Optimized itinerary for visiting Mihintale area · 6:00 AM – 6:00 PM</p>
      <p style="margin-top:10px;">Starting from <?php echo htmlspecialchars($startPoint); ?> · ~25 km radius</p>
    </div>

    <div class="feedback-box mb-5">
      <form method="GET">
        <div class="row g-3">
          <div class="col-md-4">
            <label class="form-label fw-semibold">Starting Point</label>
            <input type="text" name="start_point" class="form-control" value="<?php echo htmlspecialchars($startPoint); ?>">
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Start Time</label>
            <input type="time" name="start_time" class="form-control" value="<?php echo htmlspecialchars($startTime); ?>">
          </div>

          <div class="col-md-4">
            <label class="form-label fw-semibold">Trip Type</label>
            <select name="trip_type" class="form-select">
              <option value="One-Day Trip" <?php echo ($tripType === 'One-Day Trip') ? 'selected' : ''; ?>>One-Day Trip</option>
              <option value="Religious Tour" <?php echo ($tripType === 'Religious Tour') ? 'selected' : ''; ?>>Religious Tour</option>
              <option value="Mixed Heritage Tour" <?php echo ($tripType === 'Mixed Heritage Tour') ? 'selected' : ''; ?>>Mixed Heritage Tour</option>
            </select>
          </div>

          <div class="col-12 mt-2">
            <label class="form-label fw-semibold mb-3">Select Attractions</label>
            <div class="row g-3">
              <?php foreach ($allPlaces as $place): ?>
                <div class="col-md-6 col-lg-4">
                  <div class="place-card" style="padding:20px;">
                    <label class="d-flex align-items-start gap-3 w-100" style="cursor:pointer;">
                      <input
                        type="checkbox"
                        name="places[]"
                        value="<?php echo $place['id']; ?>"
                        <?php echo in_array((int)$place['id'], $selectedPlaces) ? 'checked' : ''; ?>
                        style="margin-top:7px;"
                      >
                      <div>
                        <h5 class="mb-2" style="font-size:1.4rem;"><?php echo htmlspecialchars($place['name']); ?></h5>
                        <div style="color:var(--muted); font-size:0.98rem;">
                          ~<?php echo htmlspecialchars($place['distance_km']); ?> km · <?php echo htmlspecialchars($place['visit_duration']); ?>
                        </div>
                      </div>
                    </label>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <div class="col-12 mt-4">
            <button type="submit" class="btn btn-main">Generate Trip Plan</button>
          </div>
        </div>
      </form>
    </div>

    <div class="timeline-wrap">
      <?php if (!empty($selectedData)): ?>
        <?php $currentTime = strtotime($startTime); ?>

        <div class="timeline-item">
          <div class="timeline-dot"></div>
          <div class="timeline-card">
            <div class="timeline-time"><i class="bi bi-clock me-2"></i><?php echo date('g:i A', $currentTime); ?></div>
            <h3>Departure</h3>
            <p class="mb-2" style="color:var(--muted);"><i class="bi bi-geo-alt me-2"></i><?php echo htmlspecialchars($startPoint); ?></p>
            <p class="mb-0">Begin journey early to avoid daytime heat. Carry water and wear comfortable footwear.</p>
          </div>
        </div>

        <?php foreach ($selectedData as $place): ?>
          <?php
            $currentTime += 30 * 60;

            $emoji = "📍";
            if ($place['category_name'] === 'Religious') $emoji = "🛕";
            if ($place['category_name'] === 'Nature') $emoji = "🌿";
            if ($place['category_name'] === 'Heritage') $emoji = "🏺";
            if ($place['category_name'] === 'Cultural') $emoji = "🎭";
          ?>
          <div class="timeline-item">
            <div class="timeline-dot"></div>
            <div class="timeline-card">
              <div class="d-flex justify-content-between align-items-start gap-3 flex-wrap">
                <div>
                  <div class="timeline-time"><i class="bi bi-clock me-2"></i><?php echo date('g:i A', $currentTime); ?></div>
                  <h3><?php echo htmlspecialchars($place['name']); ?></h3>
                  <p class="mb-2" style="color:var(--muted);">
                    <i class="bi bi-geo-alt me-2"></i><?php echo htmlspecialchars($place['location_name']); ?>
                  </p>
                  <p class="mb-3"><?php echo htmlspecialchars(mb_strimwidth($place['description'], 0, 120, '...')); ?></p>
                  <a href="route.php?place_id=<?php echo $place['id']; ?>" class="learn-link">
                    <i class="bi bi-geo-alt"></i> View on Map
                  </a>
                </div>
                <div style="font-size:2rem;"><?php echo $emoji; ?></div>
              </div>
            </div>
          </div>
        <?php endforeach; ?>

        <?php $currentTime += 30 * 60; ?>
        <div class="timeline-item">
          <div class="timeline-dot"></div>
          <div class="timeline-card">
            <div class="timeline-time"><i class="bi bi-clock me-2"></i><?php echo date('g:i A', $currentTime); ?></div>
            <h3>Trip Summary</h3>
            <p class="mb-2"><strong>Trip Type:</strong> <?php echo htmlspecialchars($tripType); ?></p>
            <p class="mb-2"><strong>Selected Places:</strong> <?php echo count($selectedData); ?></p>
            <p class="mb-0"><strong>Total Distance:</strong> <?php echo number_format($totalDistance, 2); ?> km</p>
          </div>
        </div>
      <?php else: ?>
        <div class="info-card p-5 text-center">
          <h3 class="mb-3">No itinerary generated yet</h3>
          <p class="text-muted mb-0">Select attractions above and click Generate Trip Plan.</p>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>