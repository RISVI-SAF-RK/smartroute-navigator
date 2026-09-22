<?php
include '../auth/user-check.php';
include '../config/db.php';

$pageTitle = "My Dashboard | SmartRoute Navigator";
$basePath = "../";
$currentPage = "";

$userName = $_SESSION['full_name'] ?? 'User';

$totalPlans = 0;
$totalFeedback = 0;

$stmt1 = $conn->prepare("SELECT COUNT(*) AS total FROM trip_plans WHERE user_name = ?");
$stmt1->bind_param("s", $userName);
$stmt1->execute();
$res1 = $stmt1->get_result()->fetch_assoc();
if ($res1) {
    $totalPlans = $res1['total'];
}

$stmt2 = $conn->prepare("SELECT COUNT(*) AS total FROM feedback WHERE user_name = ?");
$stmt2->bind_param("s", $userName);
$stmt2->execute();
$res2 = $stmt2->get_result()->fetch_assoc();
if ($res2) {
    $totalFeedback = $res2['total'];
}

include '../includes/header.php';
?>

<section class="section-padding" style="padding-top: 48px;">
  <div class="container">
    <div class="page-header text-center">
      <h1><i class="bi bi-person-circle me-2" style="color:var(--primary);"></i>My Dashboard</h1>
      <p>
        Welcome back, <?php echo htmlspecialchars($userName); ?>.
        Manage your travel plans, routes, and feedback in one place.
      </p>
    </div>

    <div class="row g-4 mb-5">
      <div class="col-md-6 col-xl-4">
        <div class="category-card">
          <span class="category-pill pill-heritage">My Plans</span>
          <h3><?php echo $totalPlans; ?></h3>
          <p>Saved Travel Plans</p>
        </div>
      </div>

      <div class="col-md-6 col-xl-4">
        <div class="category-card">
          <span class="category-pill pill-cultural">My Feedback</span>
          <h3><?php echo $totalFeedback; ?></h3>
          <p>Submitted Reviews</p>
        </div>
      </div>

      <div class="col-md-6 col-xl-4">
        <div class="category-card">
          <span class="category-pill pill-religious">Account</span>
          <h3>Active</h3>
          <p>User Status</p>
        </div>
      </div>
    </div>

    <div class="row g-4">
      <div class="col-md-6 col-xl-4">
        <div class="help-card">
          <div class="icon-box">
            <i class="bi bi-calendar-event"></i>
          </div>
          <h4>Trip Planner</h4>
          <p>Create a one-day itinerary by choosing attractions and generating a structured travel schedule.</p>
          <a href="trip-planner.php" class="learn-link">
            Open planner <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="col-md-6 col-xl-4">
        <div class="help-card">
          <div class="icon-box">
            <i class="bi bi-journal-text"></i>
          </div>
          <h4>My Plans</h4>
          <p>View your saved itineraries and continue exploring with your previously generated travel plans.</p>
          <a href="my-plans.php" class="learn-link">
            View plans <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="col-md-6 col-xl-4">
        <div class="help-card">
          <div class="icon-box">
            <i class="bi bi-map"></i>
          </div>
          <h4>Route Map</h4>
          <p>View route guidance, map previews, and destination details for attractions in the Mihintale area.</p>
          <a href="route.php" class="learn-link">
            View map <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="col-md-6 col-xl-4">
        <div class="help-card">
          <div class="icon-box">
            <i class="bi bi-chat-left-text"></i>
          </div>
          <h4>Feedback</h4>
          <p>Submit your comments and reviews to help improve the SmartRoute Navigator experience.</p>
          <a href="feedback.php" class="learn-link">
            Submit feedback <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="col-md-6 col-xl-4">
        <div class="help-card">
          <div class="icon-box">
            <i class="bi bi-clock-history"></i>
          </div>
          <h4>My Feedback</h4>
          <p>Review your submitted ratings, comments, and feedback history in one convenient place.</p>
          <a href="my-feedback.php" class="learn-link">
            View feedback <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="col-md-6 col-xl-4">
        <div class="help-card">
          <div class="icon-box">
            <i class="bi bi-question-circle"></i>
          </div>
          <h4>Help Center</h4>
          <p>Find answers to common questions and learn how to use the system features effectively.</p>
          <a href="help.php" class="learn-link">
            Get help <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>

    <div class="help-footer mt-5">
      <h3 style="font-size:2rem;">Start Planning Your Next Visit</h3>
      <p style="color:var(--muted); margin-bottom:20px;">
        Explore attractions, generate a new itinerary, review your previous activity, and enjoy a smoother travel experience in the Mihintale area.
      </p>
      <div class="d-flex justify-content-center flex-wrap gap-3">
        <a href="trip-planner.php" class="btn btn-main">Create Trip Plan</a>
        <a href="../auth/logout.php" class="btn btn-soft">Logout</a>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>