<?php
require "../dbconnect.php";
if (!isset($_GET['token'])) {
    echo "Invalid request";
    exit();
}

$token = $_GET['token'];

// Check token in database
$sql = "SELECT * FROM users WHERE reset_token=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $token);
$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows == 0) {
    echo "Invalid or expired reset link";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <title>Reset Password - CareSync</title>
    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/reset_style.css">

</head>

<body>
    <div class="reset-card">

        <div class="logo-care">
            <img src="/CARESYNC/Assets/CareSyncLogo.png" class="logo me-2">
            <h2>CareSync</h2>
        </div>

        <h4 class="text-center mt-3 mb-4">Reset Password</h4>

        <form action="update_password.php" method="POST" onsubmit="return validatePassword()">

            <input type="hidden" name="token" value="<?php echo $token; ?>">

            <div class="mb-3">
                <label class="form-label">New Password</label>
                <input type="password" id="password" name="password" class="form-control">

                <p id="passError" style="color:red;display:none;">
                    Please enter new password
                </p>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" id="confirm_password" name="confirm_password" class="form-control">

                <p id="confirmError" style="color:red;display:none;">
                    Please confirm your password
                </p>

                <p id="matchError" style="color:red;display:none;">
                    Passwords do not match
                </p>

            </div>

            <button type="submit" class="btn btn-reset">Update Password</button>

        </form>

    </div>

    <div class="modal fade" id="successModal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content success-modal">

                <div class="success-icon">✔</div>

                <h4>Password Updated!</h4>
                <p>Your password has been successfully reset.</p>

                <a href="../login.php" class="btn btn-light mt-3">Login Now</a>

            </div>
        </div>
    </div>
    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
    <?php
    if (isset($_GET['success'])) {
        echo "
<script>
var myModal = new bootstrap.Modal(document.getElementById('successModal'));
myModal.show();
</script>
";
    }
    ?>
</body>

</html>