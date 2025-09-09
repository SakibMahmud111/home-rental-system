<?php
session_start();


if (!isset($_POST['payment_method']) || !isset($_POST['account_number']) || !isset($_POST['amount'])) {
    header("Location: booking_page.php?status=error&message=Payment data missing.");
    exit();
}


$payment_method = $_POST['payment_method'];
$account_number = $_POST['account_number'];
$paid_amount = (float)$_POST['amount'];


$sender_account = isset($_SESSION['tenant_id']) ? $_SESSION['tenant_id'] : null;
$receiver_account = isset($_SESSION['owner_id']) ? $_SESSION['owner_id'] : null;


$servername = "localhost";
$username = "root";
$password = "";
$dbname = "home_rental_system_v3";


$conn = new mysqli($servername, $username, $password, $dbname);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


$sql = "INSERT INTO payment (receiver_account, sender_account, paid_amount, payment_time) VALUES (?, ?, ?, CURRENT_TIMESTAMP())";


$stmt = $conn->prepare($sql);
$stmt->bind_param("iid", $receiver_account, $sender_account, $paid_amount);


if ($stmt->execute()) {
    header("Location: booking_page.php?status=success&amount=" . urlencode($paid_amount));
} else {
    header("Location: booking_page.php?status=error&message=Database error: " . $stmt->error);
}


$stmt->close();
$conn->close();

unset($_SESSION['tenant_id']);
unset($_SESSION['owner_id']);


exit();
?>
