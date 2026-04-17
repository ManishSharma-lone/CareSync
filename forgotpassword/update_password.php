<?php
require "../dbconnect.php";

$token = $_POST['token'];
$password = $_POST['password'];
$confirm = $_POST['confirm_password'];

if ($password != $confirm) {
    echo "Passwords do not match";
    exit();
}

// Hash password
$hashed = password_hash($password, PASSWORD_DEFAULT);

// Update password
$sql = "UPDATE users 
        SET password=?, reset_token=NULL, token_expiry=NULL 
        WHERE reset_token=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $hashed, $token);
$stmt->execute();
?>

<!DOCTYPE html>
<html>

<head>

    <title>Password Updated</title>

    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">

    <meta http-equiv="refresh" content="4;url=../login.php">

    <style>
        body {
            height: 100vh;
            background: linear-gradient(135deg, #2563EB, #0F172A);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-card {
            max-width: 420px;
            border-radius: 15px;
        }

        .success-icon {
            font-size: 60px;
            color: #2563EB;
        }
    </style>

</head>

<body>

    <div class="card success-card shadow-lg text-center p-4">

        <div class="success-icon mb-3">
            ✔
        </div>

        <h3 class="text-primary">Password Updated Successfully</h3>

        <p class="text-muted">
            Your password has been reset.
            You will be redirected to the login page shortly.
        </p>

        <a href="../login.php" class="btn btn-primary mt-3">
            Go to Login
        </a>

    </div>

    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>

</body>

</html>