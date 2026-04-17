<?php
session_start();
require_once '../dbconnect.php';
if (!isset($_SESSION['doctor_id'])) {
    header('location:../login.php');
    exit();
}

$id = $_SESSION['doctor_id'];
$qry = "SELECT * FROM doctors WHERE doctor_code=?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = ($result->num_rows > 0) ? $result->fetch_assoc() : die("Doctor not found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareSync | Premium Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/doctor_dashboard.css?v=<?php echo time(); ?>">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

<div class="sidebar shadow">
    <div class="text-center mb-5">
        <img src="../Assets/CareSyncLogo.png" width="40" alt="Logo">
        <h4 class="text-white fw-bold mt-2">CareSync</h4>
    </div>
    <nav class="nav flex-column">
        <a class="nav-link active" href="#"><i data-lucide="layout-dashboard"></i> <span>Dashboard</span></a>
        <a class="nav-link" href="../appointment_scheduling/appointments.php"><i data-lucide="calendar"></i> <span>Appointments</span></a>
        <a class="nav-link" href="manage_schedule.php"><i data-lucide="clock"></i> <span>My Schedule</span></a>
        <a class="nav-link" href="#"><i data-lucide="users"></i> <span>Patients</span></a>
        <a class="nav-link" href="#"><i data-lucide="clipboard-list"></i> <span>Notes</span></a>
        <div style="margin-top: auto; padding-top: 100px;">
            <a href="../logout.php" class="nav-link text-danger"><i data-lucide="log-out"></i> <span>Logout</span></a>
        </div>
    </nav>
</div>

<div class="main-content">
    
    <div class="d-flex justify-content-between align-items-center mb-5">
        <div>
            <h2 class="fw-bold mb-0">Daily Overview</h2>
            <p class="text-muted">Welcome back, Dr. <?php echo explode(' ', $row['full_name'])[0]; ?></p>
        </div>
        <div class="d-flex align-items-center gap-3">
            <div class="glass-card p-2 px-3 d-flex align-items-center gap-2">
                <i data-lucide="bell" size="18"></i>
                <div class="profile-pic">
                    <img src="../icons/doctor.png" width="35" class="rounded-circle shadow-sm">
                </div>
            </div>
        </div>
    </div>

    <div class="welcome-banner mb-5 shadow-lg">
        <div class="row align-items-center">
            <div class="col-lg-8">
                <span class="badge bg-glass mb-3 px-3 py-2">System Live</span>
                <h1 class="fw-800 display-5">Pulse Analytics</h1>
                <p class="opacity-75 fs-5">You have 8 consultations today. Your efficiency rating is up by 14% compared to last week.</p>
                <button class="btn btn-glass rounded-pill px-5 py-2 fw-bold mt-3">View Full Schedule</button>
            </div>
        </div>
        <i data-lucide="activity" size="200"></i>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="glass-card p-4 border-0">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box text-primary"><i data-lucide="calendar-check"></i></div>
                    <span class="badge bg-soft-success rounded-pill">+2.4%</span>
                </div>
                <h6 class="text-muted fw-bold">Today's Visits</h6>
                <div class="stat-value">08</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card p-4 border-0">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box text-info"><i data-lucide="user-plus"></i></div>
                </div>
                <h6 class="text-muted fw-bold">New Patients</h6>
                <div class="stat-value">12</div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="glass-card p-4 border-0">
                <div class="d-flex justify-content-between mb-3">
                    <div class="icon-box text-danger"><i data-lucide="clock"></i></div>
                    <span class="text-danger small fw-bold mt-2">Urgent</span>
                </div>
                <h6 class="text-muted fw-bold">Pending Notes</h6>
                <div class="stat-value">03</div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-lg-8">
            <div class="glass-card p-4 border-0 h-100">
                <h5 class="fw-bold mb-4">Patient Volume Trends</h5>
                <canvas id="visitChart" height="300"></canvas>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="glass-card p-4 border-0 h-100">
                <h5 class="fw-bold mb-4">Task Status</h5>
                <canvas id="statusChart"></canvas>
            </div>
        </div>
    </div>

    <div class="glass-card p-4 border-0">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5 class="fw-bold mb-0">Upcoming Consultations</h5>
            <button class="btn btn-link text-decoration-none fw-bold">View All</button>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th>Patient</th>
                        <th>Scheduled Time</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-3">
                                <div class="avatar-sm">RK</div>
                                <span class="fw-bold">Ravi Kumar</span>
                            </div>
                        </td>
                        <td class="text-muted">12 Feb | 10:30 AM</td>
                        <td><span class="badge bg-light text-dark">Checkup</span></td>
                        <td><span class="badge bg-soft-success">Confirmed</span></td>
                        <td><button class="btn btn-primary btn-sm rounded-pill px-3">Manage</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    lucide.createIcons();

    // Updated Line Chart with Blue Gradient Fill
    const ctx1 = document.getElementById('visitChart').getContext('2d');
    const chartFill = ctx1.createLinearGradient(0, 0, 0, 350);
    chartFill.addColorStop(0, 'rgba(0, 97, 255, 0.3)'); // Light Blue start
    chartFill.addColorStop(1, 'rgba(96, 239, 255, 0)');  // Transparent end

    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                data: [25, 45, 30, 60, 40, 80, 65],
                borderColor: '#0061ff', // Deep Blue Line
                borderWidth: 4,
                backgroundColor: chartFill,
                fill: true,
                tension: 0.4,
                pointRadius: 4,
                pointBackgroundColor: '#fff',
                pointBorderColor: '#0061ff',
                pointBorderWidth: 2
            }]
        },
        options: {
            plugins: { legend: { display: false } },
            scales: {
                y: { display: false },
                x: { grid: { display: false }, border: { display: false } }
            }
        }
    });

    // Updated Doughnut Chart
    const ctx2 = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx2, {
        type: 'doughnut',
        data: {
            labels: ['Done', 'Pending'],
            datasets: [{
                data: [70, 30],
                backgroundColor: ['#0061ff', '#e2e8f0'], // Blue and Light Gray
                hoverOffset: 4,
                borderWidth: 0
            }]
        },
        options: {
            cutout: '80%',
            plugins: { legend: { position: 'bottom' } }
        }
    });
</script>
</body>
</html>