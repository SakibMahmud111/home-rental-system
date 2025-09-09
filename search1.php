<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "home_rental_system_v2");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Collect filters from GET
$location = $_GET['location'] ?? '';
$min_price = $_GET['min_price'] ?? '';
$max_price = $_GET['max_price'] ?? '';
$rooms = $_GET['rooms'] ?? '';
$type = $_GET['type'] ?? '';

// Build query
$sql = "SELECT a.post_id, a.a_area, a.fare, n.bedroom_no, a.apartment_type
        FROM apartment a
        JOIN num_of_rooms n ON a.post_id = n.p_id
        WHERE 1=1";

if ($location != '') {
    $sql .= " AND a.a_area LIKE '%" . $conn->real_escape_string($location) . "%'";
}
if ($min_price != '' && $max_price != '') {
    $sql .= " AND a.fare BETWEEN " . (int)$min_price . " AND " . (int)$max_price;
} elseif ($min_price != '') { // Handle min price only
    $sql .= " AND a.fare >= " . (int)$min_price;
} elseif ($max_price != '') { // Handle max price only
    $sql .= " AND a.fare <= " . (int)$max_price;
}

if ($rooms != '') {
    $sql .= " AND n.bedroom_no >= " . (int)$rooms;
}
if ($type != '') {
    $sql .= " AND a.apartment_type = '" . $conn->real_escape_string($type) . "'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Search Results</title>
</head>
<body>
  <h2>Search Results</h2>
  <a href="searchindex.php">🔍 New Search</a><br><br>

  <?php
  if ($result && $result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
          echo "<div style='border:1px solid #ccc; padding:10px; margin:10px;'>";
          echo "<h3>" . htmlspecialchars($row['title']) . "</h3>";
          echo "<p>Location: " . htmlspecialchars($row['location']) . "</p>";
          echo "<p>Rent: $" . htmlspecialchars($row['rent']) . "</p>";
          echo "<p>Rooms: " . htmlspecialchars($row['rooms']) . "</p>";
          echo "<p>Type: " . htmlspecialchars($row['apartment_type']) . "</p>";
          echo "</div>";
      }
  } else {
      echo "<p>No apartments found.</p>";
  }
  ?>
</body>
</html>