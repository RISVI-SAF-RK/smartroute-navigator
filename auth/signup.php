<?php
session_start();
require_once '../config/db.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';

    // Basic validation
    if (
        empty($full_name) ||
        empty($email) ||
        empty($password) ||
        empty($confirm_password)
    ) {
        $error = "Please fill in all fields.";
    }

    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    }

    elseif (strlen($password) < 8) {
        $error = "Password must contain at least 8 characters.";
    }

    elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    }

    else {

        // Check whether email already exists
        $check = $conn->prepare(
            "SELECT id FROM users WHERE email = ?"
        );

        $check->bind_param("s", $email);
        $check->execute();

        $result = $check->get_result();

        if ($result->num_rows > 0) {

            $error = "An account with this email already exists.";

        } else {

            // Secure password hash
            $hashed_password = password_hash(
                $password,
                PASSWORD_DEFAULT
            );

            // Public registration can only create normal users
            $role = 'user';

            $stmt = $conn->prepare(
                "INSERT INTO users
                (full_name, email, password, role)
                VALUES (?, ?, ?, ?)"
            );

            $stmt->bind_param(
                "ssss",
                $full_name,
                $email,
                $hashed_password,
                $role
            );

            if ($stmt->execute()) {

                $success = "Account created successfully. You can now login.";

            } else {

                $error = "Unable to create account. Please try again.";

            }

            $stmt->close();
        }

        $check->close();
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>Sign Up | SmartRoute Navigator</title>

    <style>

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;

            min-height: 100vh;

            display: flex;
            justify-content: center;
            align-items: center;

            background:
                linear-gradient(
                    rgba(0, 0, 0, 0.55),
                    rgba(0, 0, 0, 0.55)
                ),
                url('../assets/images/login-bg.jpg');

            background-size: cover;
            background-position: center;

            padding: 30px;
        }

        .signup-container {

            width: 100%;
            max-width: 630px;

            background: rgba(255,255,255,0.96);

            padding: 50px;

            border-radius: 30px;

            box-shadow:
                0 15px 45px rgba(0,0,0,0.25);
        }

        h1 {
            text-align: center;
            font-size: 42px;
            margin-bottom: 10px;
            color: #111827;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 35px;
            font-size: 18px;
        }

        .form-group {
            margin-bottom: 22px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #1e293b;
        }

        input {

            width: 100%;

            padding: 17px;

            border-radius: 15px;

            border: 1px solid #dbe2ea;

            background: #edf4ff;

            font-size: 16px;

            outline: none;
        }

        input:focus {
            border-color: #2563eb;
        }

        .signup-btn {

            width: 100%;

            padding: 17px;

            border: none;

            border-radius: 15px;

            background: #2563eb;

            color: white;

            font-size: 18px;
            font-weight: bold;

            cursor: pointer;

            margin-top: 10px;
        }

        .signup-btn:hover {
            background: #1d4ed8;
        }

        .message {

            padding: 14px;

            margin-bottom: 20px;

            border-radius: 10px;

            text-align: center;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .links {

            text-align: center;

            margin-top: 25px;

            line-height: 2;
        }

        .links a {

            color: #2563eb;

            text-decoration: none;

            font-weight: 600;
        }

        .links a:hover {
            text-decoration: underline;
        }

    </style>

</head>

<body>

<div class="signup-container">

    <h1>Create Account</h1>

    <p class="subtitle">
        Join SmartRoute Navigator
    </p>

    <?php if (!empty($error)): ?>

        <div class="message error">
            <?= htmlspecialchars($error) ?>
        </div>

    <?php endif; ?>

    <?php if (!empty($success)): ?>

        <div class="message success">
            <?= htmlspecialchars($success) ?>
        </div>

    <?php endif; ?>


    <form method="POST">

        <div class="form-group">

            <label>Full Name</label>

            <input
                type="text"
                name="full_name"
                placeholder="Enter your full name"
                required
            >

        </div>


        <div class="form-group">

            <label>Email</label>

            <input
                type="email"
                name="email"
                placeholder="Enter your email"
                required
            >

        </div>


        <div class="form-group">

            <label>Password</label>

            <input
                type="password"
                name="password"
                placeholder="Minimum 8 characters"
                required
            >

        </div>


        <div class="form-group">

            <label>Confirm Password</label>

            <input
                type="password"
                name="confirm_password"
                placeholder="Enter password again"
                required
            >

        </div>


        <button
            type="submit"
            class="signup-btn"
        >
            Create Account
        </button>

    </form>


    <div class="links">

        <p>
            Already have an account?
            <a href="login.php">
                Login
            </a>
        </p>

        <p>
            <a href="../index.php">
                ← Back to Home
            </a>
        </p>

    </div>

</div>

</body>
</html>