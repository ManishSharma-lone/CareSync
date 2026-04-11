<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareSync - Patient Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/add_patient.css?v=<?= time() ?>">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>

<body class="patient-page-bg">
    <div class="container py-5">
        <div class="mb-4">
            <a href="../home.php" class="text-decoration-none text-secondary fw-medium">
                <i class="bi bi-arrow-left me-1"></i> Back to Home
            </a>
        </div>

        <div class="card registration-card border-0 shadow-lg">
            <div class="registration-header text-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="header-icon-box">
                        <img src="../icons/crowd.png" width="40" alt="icon">
                    </div>
                    <div>
                        <h3 class="mb-0 fw-bold">Patient Registration</h3>
                        <p class="mb-0 opacity-75 small">Create a secure digital health profile</p>
                    </div>
                </div>
            </div>

            <div class="card-body p-4 p-md-5">
                <form id="patientForm" onsubmit="return validateForm()" method="post" novalidate>
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Full Name</label>
                            <div class="input-group-custom">
                                <i class="bi bi-person icon-input"></i>
                                <input type="text" id="name" class="form-control-custom" placeholder="John Doe" name="name" required>
                            </div>
                            <span id="nameError" class="text-danger small"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Email Address</label>
                            <div class="input-group-custom">
                                <i class="bi bi-envelope icon-input"></i>
                                <input type="email" id="email" class="form-control-custom" placeholder="john@example.com" name="email" required>
                            </div>
                            <span id="emailError" class="text-danger small"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Mobile Number</label>
                            <div class="input-group-custom">
                                <i class="bi bi-phone icon-input"></i>
                                <input type="tel" id="mobile" class="form-control-custom" placeholder="+91 XXXXX XXXXX" name="mobile" required>
                            </div>
                            <span id="mobileError" class="text-danger small"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Date of Birth</label>
                            <div class="input-group-custom">
                                <i class="bi bi-calendar-event icon-input"></i>
                                <input type="date" id="dob" class="form-control-custom" name="dob" required>
                            </div>
                            <span id="dobError" class="text-danger small"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase d-block">Gender</label>
                            <div class="gender-selection-box d-flex gap-3">
                                <div class="form-check custom-radio">
                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" required>
                                    <label class="form-check-label" for="male">Male</label>
                                </div>
                                <div class="form-check custom-radio">
                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                    <label class="form-check-label" for="female">Female</label>
                                </div>
                                <div class="form-check custom-radio">
                                    <input class="form-check-input" type="radio" name="gender" id="other" value="Other">
                                    <label class="form-check-label" for="other">Other</label>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Aadhar ID</label>
                            <div class="input-group-custom">
                                <i class="bi bi-card-heading icon-input"></i>
                                <input type="text" id="aadhar" class="form-control-custom" placeholder="12-digit Aadhar Number" name="aadhar" required>
                            </div>
                            <span id="aadharError" class="text-danger small"></span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Blood Group</label>
                            <div class="input-group-custom">
                                <i class="bi bi-droplet icon-input"></i>
                                <select id="blood" class="form-select custom-select-style" name="blood" required>
                                    <option value="">Select Group</option>
                                    <option>A+</option><option>B+</option><option>AB+</option><option>O+</option>
                                    <option>A-</option><option>B-</option><option>AB-</option><option>O-</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">City</label>
                            <div class="input-group-custom">
                                <i class="bi bi-geo-alt icon-input"></i>
                                <input type="text" id="city" class="form-control-custom" placeholder="Bhubaneswar" name="city" required>
                            </div>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-uppercase">Permanent Address</label>
                            <textarea id="address" class="form-control-custom ps-3" rows="2" name="address" placeholder="Full residential address..." required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Create Password</label>
                            <div class="input-group-custom">
                                <i class="bi bi-shield-lock icon-input"></i>
                                <input type="password" id="password" class="form-control-custom" name="password" required>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-uppercase">Confirm Password</label>
                            <div class="input-group-custom">
                                <i class="bi bi-shield-check icon-input"></i>
                                <input type="password" id="confirmPassword" class="form-control-custom" name="confirmpassword" required>
                            </div>
                        </div>
                    </div>

                    <div class="text-center mt-5">
                        <button type="submit" class="btn register-btn w-100 py-3">
                            Complete Registration <i class="bi bi-check-circle ms-2"></i>
                        </button>
                    </div>
                </form>
            </div>

            <div class="card-footer bg-light p-4 text-center">
                <p class="mb-0 text-muted small">
                    <i class="bi bi-lock-fill me-1"></i> Data is encrypted and stored securely according to healthcare standards.
                </p>
            </div>
        </div>
    </div>

    <div class="modal fade" id="successModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 p-4 text-center rounded-4 shadow">
                <div class="modal-body">
                    <div class="success-icon-box">
                        <i class="bi bi-check-lg"></i>
                    </div>
                    <h3 class="fw-bold mb-2">Registration Successful!</h3>
                    <p class="text-muted mb-4">Patient profile has been created. Redirecting to home...</p>
                    <button class="btn btn-primary px-5 rounded-pill" data-bs-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
    <script src="../js/add_patient.js"></script>

    <?php
    // (Your existing PHP logic here - ensure it handles the $success variable)
    if (isset($success) && $success) {
        echo "<script>
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
            setTimeout(function() { window.location.href = '../index.php'; }, 2500);
        </script>";
    }
    ?>
</body>
</html>