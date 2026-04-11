<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body style="background-color:#2563EB">
    <?php
    require "../dbconnect.php";
    require "forgot_mail.php";
    $email = $_POST['email'];

    $token = bin2hex(random_bytes(50));
    $expiry = date("Y-m-d H:i:s", strtotime('+1 hour'));

    $sql = "UPDATE users SET reset_token=?, token_expiry=? WHERE email=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sss", $token, $expiry, $email);
    $stmt->execute();

    $reset_link = "http://localhost:8888/CareSync/forgotpassword/reset_password.php?token=" . $token;

    // Send email using PHPMailer
    sendResetEmail($email, $reset_link);

    // echo "Reset link sent to your email";
    ?>
    <div style="text-align:center; margin-top:50px">

        <!-- Circle with Check Sign -->
        <div style="
        width:70px;
        height:70px;
        background:#28a745;
        border-radius:50%;
        margin:auto;
        display:flex;
        align-items:center;
        justify-content:center;
        font-size:35px;
        color:white;
        font-weight:bold; ">
            ✓
        </div>

        <!-- Message -->
        <p style="
        color:white;
        font-weight:bold;
        font-size:18px;
        margin-top:15px;">
            Password Reset Link Sent To Your Email
        </p>
        <button style="background-color:white; padding: 15px; border-radius: 20px;"><a href="../login.php"
                style="color:black;text-decoration:none;font-weight:bold">Go to Login</a></button>

    </div>

    </div>
</body>

</html>