<?php
$pageTitle = "Home | SmartRoute Navigator";
$basePath = "";
$currentPage = "home";
include 'includes/header.php';
?>

<section class="hero">
  <div class="container">
    <div class="hero-content">
      <div class="hero-badge">
        <i class="bi bi-geo-alt-fill"></i>
        Explore Mihintale Smartly
      </div>

      <h1>Discover Mihintale</h1>

      <p>
        Your smart travel companion for exploring sacred temples, ancient heritage,
        and natural beauty within a 25 km radius.
      </p>

      <div class="d-flex justify-content-center flex-wrap gap-3">
        <a href="pages/poi-list.php" class="btn btn-main">Explore Places</a>
        <a href="pages/trip-planner.php" class="btn btn-soft">Plan a Trip</a>
      </div>
    </div>
  </div>
</section>

<section class="section-padding">
  <div class="container">
    <h2 class="section-title">Plan Your Perfect Visit</h2>

    <div class="row g-4 mt-4">
      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="icon-box">
            <i class="bi bi-compass"></i>
          </div>
          <h4>Explore Places</h4>
          <p>10 categorized points of interest in the Mihintale area.</p>
          <a href="pages/poi-list.php" class="learn-link">
            Learn more <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="icon-box">
            <i class="bi bi-map"></i>
          </div>
          <h4>Route Planning</h4>
          <p>Interactive map with navigation and route guidance.</p>
          <a href="pages/route.php" class="learn-link">
            Learn more <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>

      <div class="col-md-6 col-lg-4">
        <div class="feature-card">
          <div class="icon-box">
            <i class="bi bi-calendar-event"></i>
          </div>
          <h4>One-Day Trip</h4>
          <p>Optimized itinerary from 6 AM to 6 PM.</p>
          <a href="pages/trip-planner.php" class="learn-link">
            Learn more <i class="bi bi-arrow-right"></i>
          </a>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="section-padding" style="background:#fbf7f2;">
  <div class="container">
    <h2 class="section-title">Categories of Interest</h2>

    <div class="row g-4 mt-4">
      <div class="col-6 col-md-3">
        <div class="category-card">
          <span class="category-pill pill-religious">Religious</span>
          <h3>4</h3>
          <p>Places</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="category-card">
          <span class="category-pill pill-nature">Nature</span>
          <h3>2</h3>
          <p>Places</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="category-card">
          <span class="category-pill pill-heritage">Heritage</span>
          <h3>2</h3>
          <p>Places</p>
        </div>
      </div>

      <div class="col-6 col-md-3">
        <div class="category-card">
          <span class="category-pill pill-cultural">Cultural</span>
          <h3>2</h3>
          <p>Places</p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>