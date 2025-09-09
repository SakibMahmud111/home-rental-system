<?php
session_start();
include 'db.php';

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user info
$stmt = $conn->prepare("SELECT * FROM user WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>User Profile</title>
</head>
<body>
  <h2>Welcome, <?php echo htmlspecialchars($user['f_name'] . ' ' . $user['l_name']); ?></h2>

  <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
  <p><strong>NID:</strong> <?php echo htmlspecialchars($user['nid']); ?></p>
  <p><strong>Address:</strong> <?php echo htmlspecialchars($user['u_address']); ?></p>
  <p><strong>Gender:</strong> <?php echo htmlspecialchars($user['gender']); ?></p>
  <p><strong>Account Type:</strong> <?php echo $user['is_owner'] ? "Owner" : "Tenant"; ?></p>

  <a href="logout.php">Logout</a>
</body>
</html>
