<?php
session_start();
require_once '../dbconnect.php';

if (!isset($_SESSION['email']) || $_SESSION['role'] != "admin") {
    header('location:../login.php');
    exit();
}

$patient_id = "";

if (isset($_GET['id'])) {
    $patient_id = $_GET['id'];

    $sql = "SELECT * FROM patients WHERE patient_code=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $patient_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $name = $row['full_name'];
        $email = $row['email'];
        $mobile = $row['mobile'];
        $dob = $row['dob'];
        $gender = $row['gender'];
        $aadhar = $row['aadhar'];
        $blood = $row['blood_group'];
        $city = $row['city'];
        $address = $row['address'];
    } else {
        echo "Patient not found";
        exit();
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $patient_id = $_POST['patient_id'];

    $name = $_POST['name'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $aadhar = $_POST['aadhar'];
    $blood = $_POST['blood'];
    $city = $_POST['city'];
    $address = $_POST['address'];

    $update = "UPDATE patients SET 
                full_name=?, 
                email=?, 
                mobile=?, 
                dob=?, 
                gender=?, 
                aadhar=?, 
                blood_group=?, 
                city=?, 
                address=? 
               WHERE patient_code=?";

    $stmt = $conn->prepare($update);
    $stmt->bind_param("ssssssssss", $name, $email, $mobile, $dob, $gender, $aadhar, $blood, $city, $address, $patient_id);

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
    <title>CareSync - Update Patient</title>

    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/add_patient.css">
</head>

<body class="patient-bg">

<div class="container mt-5 mb-5">

    <div class="card patient-card border-0">

        <!-- Header -->
        <div class="patient-header d-flex align-items-center gap-3">
            <div class="icon-circle">
                <img src="../icons/crowd.png" width="50">
            </div>

            <div>
                <h3 class="mb-0">Update Patient</h3>
            </div>
        </div>

        <!-- FORM -->
        <div class="card-body p-4">

            <form method="POST">

                <input type="hidden" name="patient_id" value="<?php echo $patient_id; ?>">

                <div class="row">

                    <div class="col-md-6 mb-3">
                        <label>Full Name</label>
                        <input type="text" name="name" class="form-control" value="<?php echo $name; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" value="<?php echo $email; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Mobile</label>
                        <input type="text" name="mobile" class="form-control" value="<?php echo $mobile; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Date of Birth</label>
                        <input type="date" name="dob" class="form-control" value="<?php echo $dob; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Gender</label><br>
                        <input type="radio" name="gender" value="male" <?php if($gender=="male") echo "checked"; ?>> Male
                        <input type="radio" name="gender" value="female" <?php if($gender=="female") echo "checked"; ?>> Female
                        <input type="radio" name="gender" value="Other" <?php if($gender=="Other") echo "checked"; ?>> Other
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Aadhar</label>
                        <input type="text" name="aadhar" class="form-control" value="<?php echo $aadhar; ?>">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>Blood Group</label>
                        <select name="blood" class="form-select">
                            <option <?php if($blood=="A+") echo "selected"; ?>>A+</option>
                            <option <?php if($blood=="B+") echo "selected"; ?>>B+</option>
                            <option <?php if($blood=="AB+") echo "selected"; ?>>AB+</option>
                            <option <?php if($blood=="O+") echo "selected"; ?>>O+</option>
                            <option <?php if($blood=="A-") echo "selected"; ?>>A-</option>
                            <option <?php if($blood=="O-") echo "selected"; ?>>O-</option>
                        </select>
                    </div>

                    <div class="col-md-6 mb-3">
                        <label>City</label>
                        <input type="text" name="city" class="form-control" value="<?php echo $city; ?>">
                    </div>

                    <div class="col-12 mb-3">
                        <label>Address</label>
                        <textarea name="address" class="form-control"><?php echo $address; ?></textarea>
                    </div>

                </div>

                <div class="text-center mt-4">
                    <button type="submit" class="btn register-btn">Update Patient</button>
                </div>

            </form>

        </div>

    </div>

</div>

<script src="../Bootstrap/bootstrap.bundle.min.js"></script>

<!-- ✅ SUCCESS MODAL -->
<?php if (isset($success)) { ?>
<script>
document.addEventListener("DOMContentLoaded", function() {

    var modal = new bootstrap.Modal(document.getElementById('successModal'));
    modal.show();

    setTimeout(function(){
        window.location.href = "admin_dashboard.php";
    }, 2000);

});
</script>
<?php } ?>

<div class="modal fade" id="successModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content text-center p-4">
            <h4 class="text-success">Success!</h4>
            <p>Patient Updated Successfully</p>
        </div>
    </div>
</div>

</body>
</html>