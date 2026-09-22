<?php
include '../config/db.php';

$pageTitle = "Tourist Places | SmartRoute Navigator";
$basePath = "../";
$currentPage = "places";

$search = isset($_GET['search']) ? trim($_GET['search']) : '';
$category = isset($_GET['category']) ? trim($_GET['category']) : '';

$sql = "SELECT places.*, categories.name AS category_name
        FROM places
        JOIN categories ON places.category_id = categories.id
        WHERE 1=1";

$params = [];
$types = "";

if ($search !== '') {
    $sql .= " AND (places.name LIKE ? OR places.description LIKE ? OR places.location_name LIKE ?)";
    $searchTerm = "%" . $search . "%";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= "sss";
}

if ($category !== '') {
    $sql .= " AND categories.name = ?";
    $params[] = $category;
    $types .= "s";
}

$sql .= " ORDER BY places.id ASC";

$stmt = $conn->prepare($sql);
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$result = $stmt->get_result();

include '../includes/header.php';
?>

<section class="section-padding" style="padding-top: 48px;">
  <div class="container">
    <div class="page-header">
      <h1>Tourist Places</h1>
      <p>Explore categorized attractions in the Mihintale area</p>
    </div>

    <form method="GET" action="" class="filter-bar">
      <div class="search-box">
        <i class="bi bi-search"></i>
        <input
          type="text"
          name="search"
          placeholder="Search places..."
          value="<?php echo htmlspecialchars($search); ?>"
        >
      </div>

      <div class="filter-pills">
        <a href="poi-list.php" class="<?php echo ($category === '' ? 'active' : ''); ?>">All</a>
        <a href="?category=Religious<?php echo $search !== '' ? '&search=' . urlencode($search) : ''; ?>" class="<?php echo ($category === 'Religious' ? 'active' : ''); ?>">Religious</a>
        <a href="?category=Nature<?php echo $search !== '' ? '&search=' . urlencode($search) : ''; ?>" class="<?php echo ($category === 'Nature' ? 'active' : ''); ?>">Nature</a>
        <a href="?category=Heritage<?php echo $search !== '' ? '&search=' . urlencode($search) : ''; ?>" class="<?php echo ($category === 'Heritage' ? 'active' : ''); ?>">Heritage</a>
        <a href="?category=Cultural<?php echo $search !== '' ? '&search=' . urlencode($search) : ''; ?>" class="<?php echo ($category === 'Cultural' ? 'active' : ''); ?>">Cultural</a>
      </div>
    </form>

    <div class="row g-4">
      <?php if ($result && $result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <?php
            $imagePath = $row['image_url'];
            if (!preg_match('/^https?:\/\//', $imagePath)) {
                $imagePath = "../" . $imagePath;
            }

            $emoji = "📍";
            if ($row['category_name'] === 'Religious') $emoji = "🛕";
            if ($row['category_name'] === 'Nature') $emoji = "🌿";
            if ($row['category_name'] === 'Heritage') $emoji = "🏛️";
            if ($row['category_name'] === 'Cultural') $emoji = "🎭";

            $pillClass = "pill-cultural";
            if ($row['category_name'] === 'Religious') $pillClass = "pill-religious";
            if ($row['category_name'] === 'Nature') $pillClass = "pill-nature";
            if ($row['category_name'] === 'Heritage') $pillClass = "pill-heritage";
            if ($row['category_name'] === 'Cultural') $pillClass = "pill-cultural";
          ?>
          <div class="col-lg-6">
            <div class="place-card">
              <div class="place-top">
                <div class="place-emoji"><?php echo $emoji; ?></div>
                <div>
                  <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                  <span class="category-pill <?php echo $pillClass; ?>" style="margin-bottom: 0;">
                    <?php echo htmlspecialchars($row['category_name']); ?>
                  </span>
                </div>
              </div>

              <p>
                <?php echo htmlspecialchars(mb_strimwidth($row['description'], 0, 130, '...')); ?>
              </p>

              <div class="place-meta">
                <span><i class="bi bi-geo-alt"></i> ~<?php echo htmlspecialchars($row['distance_km']); ?> km</span>
                <span><i class="bi bi-clock"></i> <?php echo htmlspecialchars($row['visit_duration']); ?></span>
              </div>

              <a href="poi-detail.php?id=<?php echo $row['id']; ?>" class="learn-link">
                View details <i class="bi bi-arrow-right"></i>
              </a>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-12">
          <div class="info-card p-5 text-center">
            <h3 class="mb-3">No places found</h3>
            <p class="text-muted mb-0">Try a different search or category filter.</p>
          </div>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>