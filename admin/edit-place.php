<?php
include '../auth/admin-check.php';
include '../config/db.php';

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$success = "";
$error = "";

$categories = $conn->query("SELECT * FROM categories ORDER BY name ASC");

$stmt = $conn->prepare("SELECT * FROM places WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$place = $result->fetch_assoc();

if (!$place) {
    die("Place not found.");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $category_id = trim($_POST['category_id'] ?? '');
    $name = trim($_POST['name'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $location_name = trim($_POST['location_name'] ?? '');
    $distance_km = trim($_POST['distance_km'] ?? '');
    $recommended_time = trim($_POST['recommended_time'] ?? '');
    $visit_duration = trim($_POST['visit_duration'] ?? '');
    $tips = trim($_POST['tips'] ?? '');
    $map_embed_url = trim($_POST['map_embed_url'] ?? '');

    $image_url = $place['image_url'];

    if (isset($_FILES['image_file']) && $_FILES['image_file']['error'] === 0) {
        $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
        $fileType = mime_content_type($_FILES['image_file']['tmp_name']);

        if (!in_array($fileType, $allowedTypes)) {
            $error = "Only JPG, JPEG, PNG, and WEBP images are allowed.";
        } else {
            $uploadDir = "../assets/upload/";
            $fileExtension = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $newFileName = time() . "_" . uniqid() . "." . $fileExtension;
            $targetPath = $uploadDir . $newFileName;

            if (move_uploaded_file($_FILES['image_file']['tmp_name'], $targetPath)) {
                $image_url = "assets/upload/" . $newFileName;
            } else {
                $error = "Failed to upload new image.";
            }
        }
    }

    if ($error === "") {
        $update = $conn->prepare("UPDATE places SET
            category_id = ?,
            name = ?,
            description = ?,
            location_name = ?,
            distance_km = ?,
            recommended_time = ?,
            visit_duration = ?,
            tips = ?,
            image_url = ?,
            map_embed_url = ?
            WHERE id = ?");

        $update->bind_param(
            "isssdsssssi",
            $category_id,
            $name,
            $description,
            $location_name,
            $distance_km,
            $recommended_time,
            $visit_duration,
            $tips,
            $image_url,
            $map_embed_url,
            $id
        );

        if ($update->execute()) {
            $success = "Place updated successfully.";

            $stmt = $conn->prepare("SELECT * FROM places WHERE id = ?");
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
            $place = $result->fetch_assoc();
        } else {
            $error = "Failed to update place.";
        }
    }
}

$adminPageTitle = "Edit Place";
$adminCurrentPage = "manage-poi";
include 'includes/admin-header.php';
?>

<div class="admin-page-wrap">
  <div class="admin-page-hero mb-4">
    <div>
      <h1 class="admin-page-title mb-2">Edit Place</h1>
      <p class="admin-page-subtitle mb-0">
        Update existing place details and keep the public information accurate.
      </p>
    </div>
  </div>

  <div class="row g-4 mb-4 mt-1">
    <div class="col-md-6 col-xl-4">
      <div class="admin-summary-card">
        <span class="admin-summary-label">Editing ID</span>
        <h3>#<?php echo $place['id']; ?></h3>
        <p>Currently selected place record</p>
      </div>
    </div>

    <div class="col-md-6 col-xl-4">
      <div class="admin-summary-card">
        <span class="admin-summary-label">Category</span>
        <h3><?php echo htmlspecialchars($place['category_id']); ?></h3>
        <p>Assigned category reference</p>
      </div>
    </div>

    <div class="col-md-12 col-xl-4">
      <div class="admin-summary-card">
        <span class="admin-summary-label">Visibility</span>
        <h3>Public</h3>
        <p>Changes will affect the user-facing system</p>
      </div>
    </div>
  </div>

  <div class="admin-form-card mt-2">
    <div class="admin-table-head">
      <div>
        <h4>Edit Place Form</h4>
        <p>Modify the fields below and save your updates.</p>
      </div>
    </div>

    <div class="p-4 p-lg-5">
      <?php if ($success): ?>
        <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
      <?php endif; ?>

      <?php if ($error): ?>
        <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>

      <form method="POST" enctype="multipart/form-data">
        <div class="row g-4">
          <div class="col-md-6">
            <label class="form-label fw-semibold">Category *</label>
            <select name="category_id" class="form-select" required>
              <option value="">Select category</option>
              <?php while ($cat = $categories->fetch_assoc()): ?>
                <option value="<?php echo $cat['id']; ?>" <?php echo ($place['category_id'] == $cat['id']) ? 'selected' : ''; ?>>
                  <?php echo htmlspecialchars($cat['name']); ?>
                </option>
              <?php endwhile; ?>
            </select>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Place Name *</label>
            <input type="text" name="name" class="form-control" value="<?php echo htmlspecialchars($place['name']); ?>" required>
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold">Description *</label>
            <textarea name="description" class="form-control" rows="5" required><?php echo htmlspecialchars($place['description']); ?></textarea>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Location Name</label>
            <input type="text" name="location_name" class="form-control" value="<?php echo htmlspecialchars($place['location_name']); ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Distance (km)</label>
            <input type="number" step="0.01" name="distance_km" class="form-control" value="<?php echo htmlspecialchars($place['distance_km']); ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Recommended Time</label>
            <input type="text" name="recommended_time" class="form-control" value="<?php echo htmlspecialchars($place['recommended_time']); ?>">
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Visit Duration</label>
            <input type="text" name="visit_duration" class="form-control" value="<?php echo htmlspecialchars($place['visit_duration']); ?>">
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold">Travel Tips</label>
            <textarea name="tips" class="form-control" rows="4"><?php echo htmlspecialchars($place['tips']); ?></textarea>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Current Image</label>
            <div class="admin-image-preview-card">
              <?php if (!empty($place['image_url'])): ?>
                <?php
                  $imagePath = $place['image_url'];
                  if (!preg_match('/^https?:\/\//', $imagePath)) {
                      $imagePath = "../" . $imagePath;
                  }
                ?>
                <img src="<?php echo htmlspecialchars($imagePath); ?>" alt="" class="admin-preview-image">
              <?php else: ?>
                <div class="text-muted">No image uploaded</div>
              <?php endif; ?>
            </div>
          </div>

          <div class="col-md-6">
            <label class="form-label fw-semibold">Upload New Image</label>
            <div class="custom-file-upload">
              <input type="file" name="image_file" id="imageUpload" accept=".jpg,.jpeg,.png,.webp" hidden>
              <label for="imageUpload" class="upload-btn">
                <i class="bi bi-upload"></i> Choose Image
              </label>
              <span id="fileName" class="file-name">No file chosen</span>
            </div>
            <small class="text-muted d-block mt-2">Allowed: JPG, PNG, WEBP</small>
          </div>

          <div class="col-12">
            <label class="form-label fw-semibold">Map Embed URL</label>
            <input type="text" name="map_embed_url" class="form-control" value="<?php echo htmlspecialchars($place['map_embed_url']); ?>">
          </div>

          <div class="col-12 d-flex flex-wrap gap-3 pt-2">
            <button type="submit" class="btn btn-main">Update Place</button>
            <a href="manage-poi.php" class="btn btn-soft">Back to Manage POI</a>
          </div>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.getElementById("imageUpload").addEventListener("change", function() {
    const fileName = this.files.length > 0 ? this.files[0].name : "No file chosen";
    document.getElementById("fileName").textContent = fileName;
});
</script>

<?php include 'includes/admin-footer.php'; ?>