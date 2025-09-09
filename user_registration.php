<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name   = $_POST['first_name'];
    $last_name    = $_POST['last_name'];
    $email        = $_POST['email'];
    $phone_number = $_POST['phone_number']; 
    $password     = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $nid          = $_POST['nid'];
    $u_address    = $_POST['address']; 
    $gender       = $_POST['gender'];
    $is_owner     = isset($_POST['is_owner']) ? 1 : 0;
    $is_bkash     = (isset($_POST['account_type']) && $_POST['account_type'] == 'bkash') ? 1 : 0;

    $sql = "INSERT INTO user 
                (f_name, l_name, email, phone_number, password, NID, u_address, gender, is_owner, isBkashAccount) 
            VALUES 
                ('$first_name', '$last_name', '$email', '$phone_number', '$password', '$nid', '$u_address', '$gender', '$is_owner', '$is_bkash')";

    if ($conn->query($sql) === TRUE) {
        echo "Registration successful. <a href='user_login.php'>Login</a>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .registration-container {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 500px;
            text-align: center;
        }
        .registration-container h2 {
            margin-bottom: 1.5rem;
            color: #333;
        }
        .registration-container input[type="text"],
        .registration-container input[type="email"],
        .registration-container input[type="password"],
        .registration-container select,
        .registration-container button {
            width: calc(100% - 20px);
            padding: 10px;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .registration-container .checkbox-label {
            display: block;
            margin-bottom: 1rem;
            text-align: left;
        }
        .registration-container button {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #28a745;
            color: #fff;
            font-size: 1rem;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .registration-container button:hover {
            background-color: #218838;
        }
        .error-message {
            color: red;
            margin-top: 1rem;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h2>User Registration</h2>
        <?php
        if (isset($error_message)) {
            echo "<p class='error-message'>" . $error_message . "</p>";
        }
        ?>
        <form method="POST">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone_number" placeholder="Phone Number" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="text" name="nid" placeholder="NID">
            <input type="text" name="address"
