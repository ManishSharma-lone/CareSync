<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    require_once "dbconnect.php";
    // Trim the input to remove spaces
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Prepare query
    $qry = "SELECT * FROM users WHERE email=?";
    $stmt = $conn->prepare($qry);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    // Fetch the row
    if ($row = $result->fetch_assoc()) {

        // Trim the DB password hash to avoid hidden spaces
        $hashFromDb = trim($row['password']);

        if (password_verify($password, $hashFromDb)) {

            $_SESSION['user_id'] = $row['id'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['role'] = $row['role'];

            // Redirect based on role
            if ($row['role'] == "admin") {
                $_SESSION['email']=$row['email'];
                header("Location: ./Admin/admin_dashboard.php");
                exit();
    
            } elseif ($row['role'] == "doctor") {

                if (empty($row['doctor_code'])) {
                    echo "<script>alert('Doctor ID missing');</script>";
                    exit();
                }
                $_SESSION['doctor_id'] = $row['doctor_code'];
                header("Location: ./Doctor/doctor_dashboard.php");
                exit();
            } elseif ($row['role'] == "patient") {
                if (empty($row['patient_code'])) {
                    echo "<script>alert('Patient ID missing');</script>";
                    exit();
                }
                $_SESSION['patient_id'] = $row['patient_code'];
                header("Location: ./Patient/patient_dashboard.php");
                exit();
            } elseif ($row['role'] == "attendee") {
                if (empty($row['attendee_code'])) {
                    echo "<script>alert('Attendee ID missing');</script>";
                    exit();
                }
                header("Location: ./Attendee/attendee_dashboard.php");
                exit();
            }

        } else {
            echo "<script>alert('Incorrect Password');</script>";
        }

    } else {
        echo "<script>alert('User not found');</script>";
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>CareSync - Secure Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="styles/login.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="login-page">

    <div class="back-to-home">
        <a href="home.php" class="text-decoration-none text-muted">
            <i class="bi bi-arrow-left me-1"></i> Back to Home
        </a>
    </div>

    <div class="login-container d-flex align-items-center justify-content-center">
        <div class="login-card shadow-lg border-0">
            
            <div class="login-header text-center">
                <div class="logo-wrapper mb-3">
                    <img src="/CARESYNC/Assets/CareSyncLogo.png" class="login-logo" alt="CareSync">
                </div>
                <h2 class="fw-bold h4 mb-1">Welcome Back</h2>
                <p class="text-muted small">Please enter your credentials to access CareSync</p>
            </div>

            <div class="login-body p-4 p-md-5">
                <form method="POST" onsubmit="return validateLogin()">
                    <div class="mb-4">
                        <label class="form-label fw-semibold small">Email or Username</label>
                        <div class="input-group-custom">
                            <i class="bi bi-envelope icon-input"></i>
                            <input type="text" name="email" id="email" class="form-control-custom" placeholder="name@example.com">
                        </div>
                        <small id="emailError" class="text-danger"></small>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold small">Password</label>
                        <div class="input-group-custom">
                            <i class="bi bi-lock icon-input"></i>
                            <input type="password" name="password" id="password" class="form-control-custom" placeholder="••••••••">
                        </div>
                        <small id="passwordError" class="text-danger"></small>
                    </div>

                    <div class="mb-4 text-end">
                        <a href="#" class="forgot-link small" data-bs-toggle="modal" data-bs-target="#successModal">
                            Forgot Password?
                        </a>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary login-submit-btn py-3">
                            Sign In <i class="bi bi-box-arrow-in-right ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="login-footer text-center p-4 border-top bg-light-soft">
                <small class="text-muted">
                    <i class="bi bi-shield-check text-primary me-1"></i> Authorized Medical Access Only
                </small>
            </div>
        </div>
    </div>

    <script src="Bootstrap/bootstrap.bundle.min.js"></script>
    <script src="./js/login.js"></script>
</body>
</html>