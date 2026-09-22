<?php
include '../config/db.php';
session_start();

if (isset($_SESSION['user_id'])) {
    if ($_SESSION['role'] === 'admin') {
        header("Location: ../admin/dashboard.php");
    } else {
        header("Location: ../pages/user-dashboard.php");
    }
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($email === "" || $password === "") {
        $error = "Please fill in all fields.";
    } else {
        $stmt = $conn->prepare("SELECT id, full_name, email, password, role FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['full_name'] = $user['full_name'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['role'] = $user['role'];

            if ($user['role'] === 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../pages/user-dashboard.php");
            }
            exit();
        } else {
            $error = "Invalid email or password.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | SmartRoute Navigator</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/css/style.css" rel="stylesheet">

  <style>
    body.login-page-body {
      margin: 0;
      min-height: 100vh;
      background: #0f172a;
      font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .login-page {
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 40px 20px;
      background:
        linear-gradient(rgba(15, 23, 42, 0.45), rgba(15, 23, 42, 0.60)),
        url('../assets/img/login-bg.png') center/cover no-repeat;
    }

    .login-card {
      background: rgba(255, 255, 255, 0.95);
      border-radius: 28px;
      padding: 42px 36px;
      box-shadow: 0 20px 50px rgba(0, 0, 0, 0.18);
      border: 1px solid rgba(255, 255, 255, 0.35);
    }

    .login-card h2 {
      text-align: center;
      font-size: 2.4rem;
      font-weight: 800;
      margin-bottom: 10px;
      color: #0f172a;
    }

    .login-card p {
      text-align: center;
      color: #64748b;
      margin-bottom: 28px;
    }

    .login-card .form-label {
      font-weight: 700;
      margin-bottom: 10px;
      color: #0f172a;
    }

    .login-card .form-control {
      min-height: 56px;
      border-radius: 14px;
      border: 1px solid #e2e8f0;
      background: #eef4ff;
      padding: 12px 16px;
      box-shadow: none;
    }

    .login-card .btn-main {
      width: 100%;
      min-height: 56px;
      border-radius: 16px;
      margin-top: 6px;
      background: #2563eb;
      color: #fff;
      border: none;
      font-weight: 600;
    }

    .login-card .btn-main:hover {
      background: #1d4ed8;
    }

    .login-back-link {
      display: inline-block;
      margin-top: 24px;
      font-weight: 600;
      color: #2563eb;
      text-decoration: none;
    }

    .login-back-link:hover {
      color: #1d4ed8;
    }

    @media (max-width: 576px) {
      .login-card {
        padding: 28px 22px;
        border-radius: 22px;
      }

      .login-card h2 {
        font-size: 2rem;
      }
    }
  </style>
</head>
<body class="login-page-body">

<section class="login-page">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-7 col-lg-5">
        <div class="login-card">
          <h2>Login</h2>
          <p>User and Admin access portal</p>

          <?php if ($error): ?>
            <div class="alert alert-danger"><?php echo htmlspecialchars($error); ?></div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-4">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-main">Login</button>
            <div class="signup-link">
    <p>
        Don't have an account?
        <a href="signup.php">Create Account</a>
    </p>
</div>
          </form>

          <div class="text-center">
            <a href="../index.php" class="login-back-link">← Back to Home</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>
</html>