<?php
session_start();
require_once '../dbconnect.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] != "admin") {
    header('location:../login.php');
    exit();
}

$doctor_id = "";

if (isset($_GET['id'])) {
    $doctor_id = $_GET['id'];

    $sql = "SELECT * FROM doctors WHERE doctor_code=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $doctor_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $name = $row['full_name'];
        $department = $row['department'];
        $specialization = $row['specialization'];
        $experience = $row['experience'];
        $contact = $row['contact'];
        $email = $row['email'];
    } else {
        echo "Doctor not found";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $doctor_id = $_POST['doctor_id']; 

    $name = $_POST['name'];
    $department = $_POST['department'];
    $specialization = $_POST['specialization'];
    $experience = $_POST['experience'];
    $contact = $_POST['contact'];
    $email = $_POST['email'];

    $update = "UPDATE doctors SET 
                full_name=?, 
                department=?, 
                specialization=?, 
                experience=?, 
                contact=?, 
                email=? 
               WHERE doctor_code=?";

    $stmt = $conn->prepare($update);
    $stmt->bind_param("sssisss", $name, $department, $specialization, $experience, $contact, $email, $doctor_id);

    if ($stmt->execute()) {
        $success = true;
    } else {
        $error = true;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Doctor | CareSync</title>

    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/add_doctor.css">
</head>

<body>

<div class="container main-container d-flex align-items-center justify-content-center">

    <div class="card doctor-card shadow-lg">

        <!-- Header -->
        <div class="doctor-header d-flex align-items-center gap-3">
            <div class="icon-circle">
                <img src="../icons/medical-staff.png" width="50">
            </div>

            <div class="add">
                <h3 class="mb-0">Update Doctor</h3>
                <small>Enter doctor professional details</small>
            </div>
        </div>

        <!-- Body -->
        <div class="card-body p-4">

            <form method="POST">

                <!-- ✅ IMPORTANT HIDDEN FIELD -->
                <input type="hidden" name="doctor_id" value="<?php echo $doctor_id; ?>">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Department</label>
                        <select name="department" class="form-select">
                            <option <?php if($department=="") echo "selected"; ?>>Select Department</option>
                            <option <?php if($department=="Cardiology") echo "selected"; ?>>Cardiology</option>
                            <option <?php if($department=="Neurology") echo "selected"; ?>>Neurology</option>
                            <option <?php if($department=="Orthopedics") echo "selected"; ?>>Orthopedics</option>
                            <option <?php if($department=="Dermatology") echo "selected"; ?>>Dermatology</option>
                            <option <?php if($department=="Pediatrics") echo "selected"; ?>>Pediatrics</option>
                            <option <?php if($department=="General Medicine") echo "selected"; ?>>General Medicine</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Specialization</label>
                        <input type="text" name="specialization" class="form-control" value="<?php echo $specialization; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Experience (Years)</label>
                        <input type="number" name="experience" class="form-control" value="<?php echo $experience; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Contact Number</label>
                        <input type="tel" name="contact" class="form-control" value="<?php echo $contact; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="add-btn">
                        Update Doctor
                    </button>
                </div>

            </form>

        </div>

        <!-- Footer -->
        <div class="card-footer footer-text">
            CareSync Admin Panel • Secure Doctor Registration
        </div>

    </div>

</div>

<script src="../Bootstrap/bootstrap.bundle.min.js"></script>

<!-- ✅ SUCCESS MODAL SCRIPT -->
<?php if (isset($success)) { ?>
<script>
document.addEventListener("DOMContentLoaded", function() {

    var successModal = new bootstrap.Modal(document.getElementById('successModal'));
    successModal.show();

    setTimeout(function() {
        window.location.href = "admin_dashboard.php";
    }, 2000);

});
</script>
<?php } ?>

<!-- ✅ SUCCESS MODAL -->
<div class="modal fade" id="successModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">

            <div class="mb-3">
                <img src="../icons/check.png" width="60">
            </div>

            <h4 class="text-success">Success!</h4>
            <p>Doctor Updated Successfully</p>

        </div>
    </div>
</div>

</body>
</html>