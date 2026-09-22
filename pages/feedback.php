<?php
include '../config/db.php';
include '../auth/user-check.php';

$pageTitle = "Feedback | SmartRoute Navigator";
$basePath = "../";
$currentPage = "feedback";

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_name = trim($_POST['user_name'] ?? '');
    $user_email = trim($_POST['user_email'] ?? '');
    $rating = (int)($_POST['rating'] ?? 0);
    $message = trim($_POST['message'] ?? '');

    if ($user_name === "" || $message === "" || $rating < 1 || $rating > 5) {
        $error = "Please fill in all required fields.";
    } else {
        $stmt = $conn->prepare("INSERT INTO feedback (user_name, user_email, rating, message) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $user_name, $user_email, $rating, $message);

        if ($stmt->execute()) {
            $success = "Thank you. Your feedback has been submitted successfully.";
        } else {
            $error = "Failed to submit feedback.";
        }
    }
}

$userName = $_SESSION['full_name'] ?? '';
$userEmail = $_SESSION['email'] ?? '';

include '../includes/header.php';
?>

<section class="section-padding" style="padding-top: 48px;">
  <div class="container">
    <div class="page-header text-center">
      <h1><i class="bi bi-chat-left-text me-2" style="color:var(--primary);"></i>Feedback & Reviews</h1>
      <p>We value your experience. Share your thoughts to help improve SmartRoute Navigator.</p>
    </div>

    <div class="row justify-content-center">
      <div class="col-lg-8">
        <div class="feedback-box">
          <?php if ($success): ?>
            <div class="alert alert-success" style="border-radius:16px;"><?php echo htmlspecialchars($success); ?></div>
          <?php endif; ?>

          <?php if ($error): ?>
            <div class="alert alert-danger" style="border-radius:16px;"><?php echo htmlspecialchars($error); ?></div>
          <?php endif; ?>

          <form method="POST">
            <div class="row g-4">
              <div class="col-md-6">
                <label class="form-label fw-semibold">Your Name *</label>
                <input
                  type="text"
                  name="user_name"
                  class="form-control"
                  value="<?php echo htmlspecialchars($userName); ?>"
                  required
                >
              </div>

              <div class="col-md-6">
                <label class="form-label fw-semibold">Email Address</label>
                <input
                  type="email"
                  name="user_email"
                  class="form-control"
                  value="<?php echo htmlspecialchars($userEmail); ?>"
                >
              </div>

              <div class="col-12">
                <label class="form-label fw-semibold">How would you rate your experience? *</label>
                <div class="star-row mb-2">
                  <span>★</span>
                  <span>★</span>
                  <span>★</span>
                  <span>★</span>
                  <span>★</span>
                </div>
                <select name="rating" class="form-select" required>
                  <option value="">Select rating</option>
                  <option value="5">5 - Excellent</option>
                  <option value="4">4 - Very Good</option>
                  <option value="3">3 - Good</option>
                  <option value="2">2 - Fair</option>
                  <option value="1">1 - Poor</option>
                </select>
              </div>

              <div class="col-12">
                <label class="form-label fw-semibold">Share your experience *</label>
                <textarea
                  name="message"
                  class="form-control"
                  rows="6"
                  placeholder="Tell us what you liked, what could be improved, or any suggestions you have..."
                  required
                ></textarea>
              </div>

              <div class="col-12">
                <button type="submit" class="btn btn-main">Submit Feedback</button>
              </div>
            </div>
          </form>
        </div>

        <div class="help-footer mt-5">
          <h3 style="font-size:2rem;">Thank you for helping us improve</h3>
          <p style="color:var(--muted); margin-bottom:0;">
            Your feedback helps make travel planning in the Mihintale area more useful, simple, and enjoyable for everyone.
          </p>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>