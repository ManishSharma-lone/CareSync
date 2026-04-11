<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareSync Admin Dashboard</title>

    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/admin_dashboard.css">
</head>

<body class="dashboard-bg">
    <?php
    session_start();
    require_once '../dbconnect.php';
    if (!isset($_SESSION['email'])) {
        header('location:../login.php');
        exit();
    }

    // Total Doctors
    $docQuery = "SELECT COUNT(*) as total FROM doctors";
    $docResult = $conn->query($docQuery);
    $docCount = $docResult->fetch_assoc()['total'];

    // Total Patients
    $patQuery = "SELECT COUNT(*) as total FROM patients";
    $patResult = $conn->query($patQuery);
    $patCount = $patResult->fetch_assoc()['total'];


    $activityQuery = "SELECT * FROM activity_logs ORDER BY created_at DESC LIMIT 5";
    $activityResult = $conn->query($activityQuery);

    ?>

    <!-- HEADER -->
    <div class="dashboard-header d-flex justify-content-between align-items-center px-4 py-3">

        <div class="d-flex align-items-center dash">
            <img src="../Assets/CareSyncLogo.png" width="45">
            <h4 class="ms-2 mb-0 fw-bold text-white">CareSync</h4>
            <h4 class="ms-4 mb-0 text-white"> Admin Pannel</h4>
        </div>

        <div class="text-white">
            <span class="me-3">Welcome, Admin</span>
            <a href="../logout.php" class="btn btn-light btn-rounded logout-btn">
                LogOut
            </a>
        </div>

    </div>

    <!-- NAVIGATION -->
    <div class="dashboard-nav px-4 py-2">
        <a href="#" class="nav-btn active">Dashboard</a>
        <a href="manage_doctor.php" class="nav-btn">Doctors</a>
        <a href="manage_patient.php" class="nav-btn">Patients</a>
        <a href="doctor_schedule.php" class="nav-btn">Appointments</a>
        <a href="records.php" class="nav-btn">Records</a>
        <a href="reports.php" class="nav-btn">Reports</a>

    </div>

    <!-- MAIN CONTENT -->
    <div class="container mt-4">
        <h4 class="fw-bold mb-4">Dashboard Overview</h4>
        <!-- STATS CARDS -->
        <div class="row g-4">
            <div class="col-md-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <img src="../icons/medical-staff.png" class="mx-auto mb-3" width="50">
                        <h3 class="fw-bold"><?php echo $docCount; ?></h3>
                        <p>Total Doctors</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <img src="../icons/crowd.png" class="mx-auto mb-3" width="50">
                        <h3 class="fw-bold"><?php echo $patCount; ?></h3>
                        <p>Total Patients</p>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <img src="../icons/calendar.png" class="mx-auto mb-3" width="50">
                        <h3 class="fw-bold">00</h3>
                        <p>Appointments Today</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <img src="../icons/prescription.png" class="mx-auto mb-3" width="50">
                        <h3 class="fw-bold">00</h3>
                        <p>Prescriptions Issued</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card stat-card shadow-sm">
                    <div class="card-body text-center">
                        <img src="../icons/hospital.png" class="mx-auto mb-3" width="50">
                        <h3 class="fw-bold">00</h3>
                        <p>Active Departments</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- QUICK ACTIONS -->
        <div class="card shadow-sm mt-4">

            <div class="card-header bg-primary text-white fw-bold">
                Quick Actions
            </div>

            <div class="card-body text-center">

                <a class="btn action-btn" href="./add_doctor.php">Add Doctor</a>
                <a class="btn action-btn" href="./add_patient.php">Add Patient</a>
                <a class="btn action-btn">View Appointments</a>
                <a class="btn action-btn">Upload Report</a>
                <a class="btn action-btn">Manage Records</a>
            </div>

        </div>

        <!-- RECENT ACTIVITY -->
        <div class="card shadow-sm mt-4 mb-5">

            <div class="card-header bg-primary text-white fw-bold">
                Recent Activity
            </div>

            <div class="card-body p-0">

                <table class="table table-hover mb-0">

                    <thead class="table-light">
                        <tr>
                            <th>Date</th>
                            <th>Activity</th>
                            <th>User</th>
                        </tr>
                    </thead>

                    <tbody>
                        <?php
                        if ($activityResult->num_rows > 0) {
                            while ($row = $activityResult->fetch_assoc()) {
                                echo "<tr>
                <td>" . date('d M Y', strtotime($row['created_at'])) . "</td>
                <td>" . $row['activity'] . "</td>
                <td>" . $row['user'] . "</td>
              </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='3'>No Activity Found</td></tr>";
                        }
                        ?>
                    </tbody>

                </table>

            </div>

        </div>

    </div>
    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>