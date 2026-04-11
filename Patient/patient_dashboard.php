<?php
include '../dbconnect.php';
session_start();

// Use session instead of static ID
if (!isset($_SESSION['patient_id'])) {
    header('location:../login.php');
    exit();
}

$patient_id = $_SESSION['patient_id'];

// Fetch patient details
$qry = "SELECT * FROM patients WHERE patient_code=?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("s", $patient_id);
$stmt->execute();
$patientResult = $stmt->get_result();

if ($patientResult->num_rows > 0) {
    $patient = $patientResult->fetch_assoc();
    $real_patient_id = $patient['id'];
} else {
    echo "No patient found";
    exit();
}

// Fetch latest appointments
$query = "SELECT a.*, d.full_name, d.department 
          FROM appointments a
          JOIN doctors d ON a.doctor_id = d.id
          WHERE a.patient_id = '$real_patient_id'
          ORDER BY a.created_at DESC
          LIMIT 5";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Patient Dashboard - CareSync</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<style>
body { background: #f4f7fb; }
.dashboard-header {
    background: linear-gradient(135deg, #4a7cf3, #2d62d8);
    color: white;
    border-radius: 15px;
    padding: 25px;
}
.card-box { border-radius: 15px; }
.quick-btn { border-radius: 12px; }
.section-title { font-weight: 600; margin-bottom: 15px; }
</style>

</head>

<body>

<?php include 'patient_nav.php'; ?>

<div class="container mt-4">

<!-- HEADER -->
<div class="dashboard-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap">
        <div>
            <h3>Welcome, <?php echo $patient['full_name']; ?> 👋</h3>
            <p>Track your appointments and manage your health easily.</p>
        </div>

        <!-- COMBINED RIGHT SIDE -->
        <div class="d-flex align-items-center gap-3">
            
           <!-- <img src="../icons/examination.png" width="20">-->
            <a href="../logout.php" class="btn btn-light">Logout</a>
        </div>
    </div>
</div>

<!-- QUICK ACTIONS -->
<div class="mt-4">
    <h5 class="section-title">Quick Actions</h5>

    <div class="row g-3">

        <div class="col-6 col-md-3">
            <a href="book_appointment.php" class="btn btn-primary w-100 quick-btn">
                📅 Book Appointment
            </a>
        </div>

        <div class="col-6 col-md-3">
            <a href="my_appointments.php" class="btn btn-success w-100 quick-btn">
                📋 My Appointments
            </a>
        </div>

        <div class="col-6 col-md-3">
            <a href="medical_records.php" class="btn btn-warning w-100 quick-btn">
                🧾 Medical Records
            </a>
        </div>

        <div class="col-6 col-md-3">
            <a href="profile.php" class="btn btn-dark w-100 quick-btn">
                👤 Profile
            </a>
        </div>

    </div>
</div>

<!-- RECENT APPOINTMENTS -->
<div class="mt-5">
    <h5 class="section-title">Recent Appointments</h5>

    <div class="table-responsive">
        <table class="table table-hover text-center bg-white">

            <thead class="table-dark">
                <tr>
                    <th>Date</th>
                    <th>Doctor</th>
                    <th>Department</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

            <?php if($result->num_rows > 0) { ?>
                <?php while($row = $result->fetch_assoc()) { ?>

                <tr>
                    <td><?= date("d M Y", strtotime($row['appointment_date'])) ?></td>
                    <td>Dr <?= $row['full_name'] ?></td>
                    <td><?= $row['department'] ?></td>
                    <td><?= date("h:i A", strtotime($row['appointment_time'])) ?></td>

                    <td>
                        <?php if($row['status'] == 'Pending') { ?>
                            <span class="badge bg-warning">Pending</span>
                        <?php } elseif($row['status'] == 'Completed') { ?>
                            <span class="badge bg-success">Completed</span>
                        <?php } else { ?>
                            <span class="badge bg-danger">Cancelled</span>
                        <?php } ?>
                    </td>

                    <td>
                        <a href="my_appointments.php" class="btn btn-sm btn-outline-primary">
                            View
                        </a>
                    </td>
                </tr>

                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td colspan="6">No Appointments Found</td>
                </tr>
            <?php } ?>

            </tbody>

        </table>
    </div>
</div>

</div>

<footer class="text-center mt-5 p-3 bg-white">
    © 2026 CareSync | Patient Portal
</footer>

</body>
</html>