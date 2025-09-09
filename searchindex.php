<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Home Rental System</title>
</head>
<body>
  <h2>Search Apartments</h2>
  <form method="GET" action="search1.php">
    <label>Location:</label>
    <input type="text" name="location" placeholder="Enter location"><br><br>

    <label>Min Price:</label>
    <input type="number" name="min_price"><br><br>

    <label>Max Price:</label>
    <input type="number" name="max_price"><br><br>

    <label>Rooms:</label>
    <select name="rooms">
      <option value="">Any</option>
      <option value="1">1+</option>
      <option value="2">2+</option>
      <option value="3">3+</option>
    </select><br><br>

    <label>Type:</label>
    <select name="type">
      <option value="">Any</option>
      <option value="Family">Family</option>
      <option value="Bachelor">Bachelor</option>
      <option value="Sublet">Sublet</option>
    </select><br><br>

    <button type="submit">Search</button>
  </form>
</body>
</html>
