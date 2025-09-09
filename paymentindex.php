<?php
session_start();

$tenant_id = 101; // Example tenant user_id
$owner_id = 202; // Example owner user_id

$_SESSION['tenant_id'] = $tenant_id;
$_SESSION['owner_id'] = $owner_id;

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "home_rental_system_v3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT isBkashAccount FROM user WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $owner_id);
$stmt->execute();
$result = $stmt->get_result();
$owner_data = $result->fetch_assoc();
$stmt->close();

$intro_text = "The house owner has a bKash account.";
if ($owner_data && $owner_data['isBkashAccount'] == 0) {
    $intro_text = "The house owner has a Nagad account.";
}

$conn->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment</title>
    <style>
        body {
            font-family: serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f4f4f4;
            margin: 0;
        }
        .container {
            background-color: #fff;
            padding: 40px 60px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        .payment-form h3 {
            font-style: italic;
            margin-bottom: 30px;
            color: #555;
        }
        .intro-text {
            font-style: italic;
            color: #888;
            margin-bottom: 25px;
            font-size: 1.1em;
        }
        .form-group {
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        .form-group label {
            font-style: italic;
            margin-bottom: 8px;
            font-size: 1.1em;
            color: #333;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 12px;
            border-radius: 8px;
            border: 1px solid #ddd;
            font-size: 1em;
            box-sizing: border-box;
            transition: border-color 0.3s;
        }
        .form-group input:focus, .form-group select:focus {
            outline: none;
            border-color: #aaa;
        }
        .btn-proceed {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 1.2em;
            font-style: italic;
            cursor: pointer;
            background-color: #e0e0e0;
            transition: background-color 0.3s, box-shadow 0.3s, opacity 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        .btn-proceed:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            box-shadow: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <form id="payment-form" action="paymentGateway.php" method="POST">
            <h3 class="intro-text"><?php echo htmlspecialchars($intro_text); ?></h3>

            <div class="form-group">
                <label for="payment-method">Choose payment method:</label>
                <select id="payment-method" name="payment_method">
                    <option value="">Select a method</option>
                    <option value="bkash">bKash</option>
                    <option value="nagad">Nagad</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="account-number">Account number:</label>
                <input type="text" id="account-number" name="account_number" placeholder="Enter account number" required>
            </div>

            <div class="form-group">
                <label for="amount">Amount:</label>
                <input type="number" id="amount" name="amount" placeholder="Enter amount" required>
            </div>

            <button type="submit" id="proceed-btn" class="btn-proceed" disabled>Proceed to payment</button>
        </form>
    </div>

    <script>
        const paymentMethod = document.getElementById('payment-method');
        const accountNumber = document.getElementById('account-number');
        const amount = document.getElementById('amount');
        const proceedBtn = document.getElementById('proceed-btn');

        function validateForm() {
            const isMethodSelected = paymentMethod.value !== "";
            const isAccountNumberFilled = accountNumber.value.trim() !== "";
            const isAmountFilled = amount.value.trim() !== "" && parseInt(amount.value) > 0;
            
            proceedBtn.disabled = !(isMethodSelected && isAccountNumberFilled && isAmountFilled);
        }

        paymentMethod.addEventListener('change', validateForm);
        accountNumber.addEventListener('input', validateForm);
        amount.addEventListener('input', validateForm);
        
        validateForm();
    </script>
</body>
</html>
