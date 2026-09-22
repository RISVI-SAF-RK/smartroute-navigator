<?php
$pageTitle = "Help | SmartRoute Navigator";
$basePath = "../";
$currentPage = "help";
include '../includes/header.php';
?>

<section class="section-padding" style="padding-top: 48px;">
  <div class="container">
    <div class="page-header text-center">
      <h1><i class="bi bi-question-circle me-2" style="color:var(--primary);"></i>Help & FAQ</h1>
      <p>Everything you need to know about using SmartRoute Navigator.</p>
    </div>

    <div class="row g-4 mt-2">
      <div class="col-md-6 col-xl-3">
        <div class="help-card">
          <div class="icon-box">
            <i class="bi bi-compass"></i>
          </div>
          <h4>Explore Places</h4>
          <p>Browse categorized attractions such as religious places, heritage sites, nature spots, and cultural locations.</p>
        </div>
      </div>

      <div class="col-md-6 col-xl-3">
        <div class="help-card">
          <div class="icon-box">
            <i class="bi bi-map"></i>
          </div>
          <h4>Route Guidance</h4>
          <p>Use the route map to view selected destinations and understand travel distance, location, and nearby attractions.</p>
        </div>
      </div>

      <div class="col-md-6 col-xl-3">
        <div class="help-card">
          <div class="icon-box">
            <i class="bi bi-calendar-event"></i>
          </div>
          <h4>Trip Planner</h4>
          <p>Create a one-day itinerary by choosing attractions and generating a structured travel schedule for your visit.</p>
        </div>
      </div>

      <div class="col-md-6 col-xl-3">
        <div class="help-card">
          <div class="icon-box">
            <i class="bi bi-chat-left-text"></i>
          </div>
          <h4>Feedback</h4>
          <p>Submit your review and suggestions to improve the system and help future users enjoy a better planning experience.</p>
        </div>
      </div>
    </div>

    <div class="mt-5">
      <h2 class="faq-title text-center">Frequently Asked Questions</h2>

      <div class="mx-auto" style="max-width: 980px;">
        <div class="faq-item">
          <button class="faq-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faq1">
            What is SmartRoute Navigator?
            <i class="bi bi-plus-lg"></i>
          </button>
          <div id="faq1" class="collapse show">
            <div class="p-4 pt-0" style="color:var(--muted); line-height:1.8;">
              SmartRoute Navigator is a web-based public transport navigation and one-day travel guide system designed to help users explore the Mihintale area within a 25 km radius. It provides categorized tourist information, route support, and travel planning assistance.
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq2">
            How can I view tourist places?
            <i class="bi bi-plus-lg"></i>
          </button>
          <div id="faq2" class="collapse">
            <div class="p-4 pt-0" style="color:var(--muted); line-height:1.8;">
              Go to the Tourist Places page from the navigation bar. You can browse all places, use the search box, and filter locations based on categories such as Religious, Nature, Heritage, and Cultural.
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq3">
            How does the route map work?
            <i class="bi bi-plus-lg"></i>
          </button>
          <div id="faq3" class="collapse">
            <div class="p-4 pt-0" style="color:var(--muted); line-height:1.8;">
              On the Route Map page, select a destination to display its map preview and route-related information. The system also shows travel distance, visit duration, and place details to help you plan efficiently.
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq4">
            How do I create a one-day trip plan?
            <i class="bi bi-plus-lg"></i>
          </button>
          <div id="faq4" class="collapse">
            <div class="p-4 pt-0" style="color:var(--muted); line-height:1.8;">
              Open the Trip Planner page, enter your starting point and preferred time, select attractions, and click Generate Trip Plan. The system will create a timeline-based itinerary for your one-day visit.
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq5">
            Do I need an account to use the system?
            <i class="bi bi-plus-lg"></i>
          </button>
          <div id="faq5" class="collapse">
            <div class="p-4 pt-0" style="color:var(--muted); line-height:1.8;">
              Basic browsing of public information can be available to guests, but account login is useful for accessing user-specific features such as trip planning, dashboard access, and submitting feedback.
            </div>
          </div>
        </div>

        <div class="faq-item">
          <button class="faq-btn collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#faq6">
            How can I contact support or share a problem?
            <i class="bi bi-plus-lg"></i>
          </button>
          <div id="faq6" class="collapse">
            <div class="p-4 pt-0" style="color:var(--muted); line-height:1.8;">
              You can use the Feedback page to submit your comments, suggestions, and issues. This helps improve the system and provides useful insight for future enhancements.
            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="help-footer mt-5">
      <h3 style="font-size:2rem;">Need More Help?</h3>
      <p style="color:var(--muted); margin-bottom:20px;">
        If you still have questions, explore the system features or send your suggestions through the feedback form.
      </p>
      <div class="d-flex justify-content-center flex-wrap gap-3">
        <a href="feedback.php" class="btn btn-main">Go to Feedback</a>
        <a href="trip-planner.php" class="btn btn-soft">Open Trip Planner</a>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>