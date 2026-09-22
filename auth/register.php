<?php
include '../config/db.php';
session_start();

$success = "";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');

    if ($full_name === "" || $email === "" || $password === "" || $confirm_password === "") {
        $error = "Please fill in all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Enter a valid email address.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $exists = $check->get_result();

        if ($exists->num_rows > 0) {
            $error = "Email already registered.";
        } else {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (full_name, email, password, role) VALUES (?, ?, ?, 'user')");
            $stmt->bind_param("sss", $full_name, $email, $hashedPassword);

            if ($stmt->execute()) {
                $success = "Registration successful. You can now login.";
            } else {
                $error = "Registration failed.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>User Register | SmartRoute Navigator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">
</head>
<body>

<section class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-5">
        <div class="info-card p-4 p-lg-5">
          <div class="text-center mb-4">
            <h2 class="fw-bold">User Registration</h2>
            <p class="text-muted mb-0">Create your SmartRoute account</p>
          </div>

          <?php if ($success): ?>
            <div class="alert alert-success"><?php echo htmlspecialchars($success); ?></div>
          <?php endif; ?>

          <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label class="form-label fw-semibold">Full Name</label>
              <input type="text" name="full_name" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
              <label class="form-label fw-semibold">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-4">
              <label class="form-label fw-semibold">Confirm Password</label>
              <input type="password" name="confirm_password" class="form-control" required>
            </div>

            <div class="d-grid">
              <button type="submit" class="btn btn-main">Register</button>
            </div>
          </form>

          <div class="text-center mt-4">
            <a href="login.php" class="text-decoration-none">Already have an account? Login</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>