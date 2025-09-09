<?php
session_start();

if (!isset($_SESSION['fare'])) {
    $_SESSION['fare'] = 500; // Example fare amount
}

if (isset($_GET['status']) && $_GET['status'] == 'success' && isset($_GET['amount'])) {
    $_SESSION['paid_amount'] = $_GET['amount'];
}

$message = "";

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['confirm_booking'])) {
    $fare = $_SESSION['fare'];
    $paid_amount = isset($_SESSION['paid_amount']) ? $_SESSION['paid_amount'] : 0;

    if ($paid_amount >= $fare) {
        $message = "Your booking is successful!";
        unset($_SESSION['fare']);
        unset($_SESSION['paid_amount']);
    } else {
        $message = "Complete your payment first";
        // Redirect to the payment page
        header("Location: paymentindex.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Page</title>
    <style>
        body {
            font-family: serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #ffffff;
            margin: 0;
        }
        .container {
            background-color: #ffffffff;
            padding: 40px 60px;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 700px;
            text-align: center;
        }
        h2 {
            font-size: 2em;
            font-style: italic;
            margin-bottom: 20px;
        }
        .terms-list {
            list-style-type: none;
            padding: 0;
            text-align: left;
            margin-bottom: 25px;
            font-size: 1.4em;
        }
        .terms-list li {
            margin-bottom: 10px;
            line-height: 1.5;
        }
        .checkbox-container {
            display: flex;
            align-items: center;
            margin-bottom: 30px;
            font-size: 1.4em;
        }
        .checkbox-container input {
            margin-right: 15px;
            width: 20px;
            height: 20px;
            cursor: pointer;
        }
        .button-group {
            display: flex;
            flex-direction: column;
            gap: 20px;
            margin-top: 20px;
        }
        .btn {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 1.2em;
            cursor: pointer;
            font-style: italic;
            transition: background-color 0.3s, box-shadow 0.3s, opacity 0.3s;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-decoration: none;
            color: #333;
        }
        .btn-payment {
            background-color: #e0e0e0;
        }
        .btn-confirm {
            background-color: #e0e0e0;
        }
        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            box-shadow: none;
        }
        .message-box {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            font-size: 1.1em;
            display: <?php echo empty($message) ? 'none' : 'block'; ?>;
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .message-box.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Terms & conditions:</h2>
        <ul class="terms-list">
            <li>1. I will pay rent and monthly utility bills (like electricity, internet, and cable) on time as per the agreement.</li>
            <li>2. I will keep the rented premises clean and free from damage.</li>
            <li>3. If I want to leave the house, I will inform the house owner one month in advance.</li>
            <li>4. For booking, I will have to pay advance fare of one month.</li>
        </ul>
        
        <form method="POST" action="booking_page.php">
            <div class="checkbox-container">
                <input type="checkbox" id="terms-checkbox">
                <label for="terms-checkbox">I have read and agree to the Terms and Conditions.</label>
            </div>

            <div class="button-group">
                <a href="paymentindex.php" id="payment-btn" class="btn btn-payment" disabled>Payment</a>
                <button type="submit" id="confirm-booking-btn" class="btn btn-confirm" name="confirm_booking" disabled>Confirm Booking</button>
            </div>
        </form>

        <?php if (!empty($message)): ?>
            <div class="message-box <?php echo (strpos($message, 'successful') !== false) ? '' : 'error'; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
    </div>

    <script>
        const termsCheckbox = document.getElementById('terms-checkbox');
        const paymentBtn = document.getElementById('payment-btn');
        const confirmBtn = document.getElementById('confirm-booking-btn');

        paymentBtn.disabled = !termsCheckbox.checked;
        confirmBtn.disabled = !termsCheckbox.checked;

        termsCheckbox.addEventListener('change', () => {
            if (termsCheckbox.checked) {
                paymentBtn.disabled = false;
                confirmBtn.disabled = false;
            } else {
                paymentBtn.disabled = true;
                confirmBtn.disabled = true;
            }
        });
        
        paymentBtn.addEventListener('click', (event) => {
          if (paymentBtn.disabled) {
            event.preventDefault();
          }
        });

    </script>
</body>
</html>
