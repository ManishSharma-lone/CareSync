<?php
include __DIR__ . '/../dbconnect.php';
session_start();

// TEMP (replace with session later)
$patient_id = 2;

// Fetch appointments
$query = "SELECT a.*, d.full_name, d.department 
          FROM appointments a
          JOIN doctors d ON a.doctor_id = d.id
          WHERE a.patient_id = '$patient_id'
          ORDER BY a.appointment_date DESC, a.appointment_time DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>My Appointments - CareSync</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>

<?php include 'patient_nav.php'; ?>

<div class="container mt-4">

    <!-- Heading -->
    <div class="mb-4">
        <h3>My Appointments</h3>
        <p class="text-muted">View and manage your appointments</p>
    </div>

    <!-- Table -->
    <div class="card shadow">
        <div class="card-body">

            <div class="table-responsive">
                <table class="table table-striped">

                    <thead class="table-dark">
                        <tr>
                            <th>Date</th>
                            <th>Time</th>
                            <th>Doctor</th>
                            <th>Department</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                    <tbody>

                    <?php if($result->num_rows > 0) { ?>
                        <?php while($row = $result->fetch_assoc()) { ?>

                        <tr>
                            <td><?= date("d M Y", strtotime($row['appointment_date'])) ?></td>
                            <td><?= date("h:i A", strtotime($row['appointment_time'])) ?></td>
                            <td>Dr <?= $row['full_name'] ?></td>
                            <td><?= $row['department'] ?></td>

                            <!-- Status -->
                            <td>
                                <?php if($row['status'] == 'Completed') { ?>
                                    <span class="badge bg-success">Completed</span>
                                <?php } elseif($row['status'] == 'Cancelled') { ?>
                                    <span class="badge bg-danger">Cancelled</span>
                                <?php } else { ?>
                                    <span class="badge bg-warning text-dark">Upcoming</span>
                                <?php } ?>
                            </td>

                            <!-- Action -->
                            <td>
                                <?php if($row['status'] == 'Upcoming') { ?>
                                    <a href="cancel_appointment.php?id=<?= $row['id'] ?>" 
                                       class="btn btn-sm btn-danger">
                                        Cancel
                                    </a>
                                <?php } else { ?>
                                    <span class="text-muted">-</span>
                                <?php } ?>
                            </td>

                        </tr>

                        <?php } ?>
                    <?php } else { ?>

                        <tr>
                            <td colspan="6" class="text-center text-muted">
                                No appointments found
                            </td>
                        </tr>

                    <?php } ?>

                    </tbody>

                </table>
            </div>

        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="patient_dashboard.php" 
           class="btn btn-primary px-4 py-2 rounded-pill shadow-sm">
            ← Back to Dashboard
        </a>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>