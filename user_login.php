<?php
session_start();
include 'db.php';

$error_message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email    = $_POST['email'];
    $password = $_POST['password'];

    // Use prepared statement for security
    $stmt = $conn->prepare("SELECT * FROM user WHERE email = ? LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Verify password (either hashed or plain text)
        if (password_verify($password, $row['password']) || $password === $row['password']) {
            $_SESSION['user_id'] = $row['user_id'];
            $_SESSION['name']    = $row['f_name'] . ' ' . $row['l_name']; // fixed

            header("Location: user_profile_page.php");
            exit();
        } else {
            $error_message = "❌ Invalid password.";
        }
    } else {
        $error_message = "❌ No account found with that email.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Login</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .login-container {
      background: #fff;
      padding: 2rem;
      border-radius: 8px;
      box-shadow: 0 4px 8px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }
    .login-container h2 {
      margin-bottom: 1.5rem;
      color: #333;
    }
    .login-container input {
      width: 100%;
      padding: 10px;
      margin-bottom: 1rem;
      border: 1px solid #ddd;
      border-radius: 4px;
      box-sizing: border-box;
    }
    .login-container button {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 4px;
      background: #007bff;
      color: #fff;
      font-size: 1rem;
      cursor: pointer;
    }
    .login-container button:hover {
      background: #0056b3;
    }
    .error-message {
      color: red;
      margin-top: 1rem;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php if (!empty($error_message)) echo "<p class='error-message'>$error_message</p>"; ?>
    <form method="POST">
      <input type="email" name="email" placeholder="Email" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
