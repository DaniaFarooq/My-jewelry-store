<?php
require_once 'db.php';
session_start();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullName = trim($_POST['fullName']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);

    // Validation
    if (empty($fullName) || empty($email) || empty($password) || empty($confirmPassword)) {
        $error = "Please fill in all fields.";
    } elseif ($password !== $confirmPassword) {
        $error = "Passwords do not match.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format.";
    } else {
        // Check if email exists
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        
        if ($stmt->num_rows > 0) {
            $error = "Email already exists.";
        } else {
            // Hash password and create pending account
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users (username, password, full_name, role, is_approved) VALUES (?, ?, ?, 'manager', 0)");
            $stmt->bind_param("sss", $email, $hashedPassword, $fullName);
            
            if ($stmt->execute()) {
                $success = "Signup request submitted! An admin will approve your account.";
            } else {
                $error = "Error creating account. Please try again.";
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Sign Up</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
    rel="stylesheet"
  />
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <style>
    body {
      background-color: #f8f9fa;
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    h2 {
      color: #7a1bc2;
    }
    .signup-container {
      background-color: white;
      padding: 2rem;
      border-radius: 1rem;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
      width: 100%;
      max-width: 400px;
    }
    .gradient-btn {
      background: linear-gradient(to right, #8e2de2, #c31432);
      color: white;
      border: none;
    }
    .gradient-btn:hover {
      background: linear-gradient(to right, #7a1bc2, #aa1a2e);
    }
    #signup-message {
      color: red;
      font-size: 0.9rem;
    }
  </style>
</head>
<body>

  <div class="signup-container text-center">
    <h2 class="mb-4">Sign Up</h2>
    <form id="signupForm" method="POST" action="signup.php">
    <div class="mb-3 text-start">
        <input type="text" class="form-control" id="fullName" name="fullName" placeholder="Full Name" required value="<?= isset($_POST['fullName']) ? htmlspecialchars($_POST['fullName']) : '' ?>" />
    </div>
    <div class="mb-3 text-start">
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" required value="<?= isset($_POST['email']) ? htmlspecialchars($_POST['email']) : '' ?>" />
    </div>
    <div class="mb-3 text-start">
        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required />
    </div>
    <div class="mb-3 text-start">
        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm Password" required />
    </div>
    <button type="submit" class="btn gradient-btn w-100 mb-3">Sign Up</button>
    
    <?php if (!empty($error)): ?>
        <div id="signup-message" class="mt-2" style="color: red;"><?= htmlspecialchars($error) ?></div>
    <?php elseif (!empty($success)): ?>
        <div id="signup-message" class="mt-2" style="color: green;"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>
</form>
    <p>Already have an account? <a href="login.php">Login</a></p>
  </div> 
</body>
</html>
