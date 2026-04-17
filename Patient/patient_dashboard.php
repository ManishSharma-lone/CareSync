<?php
session_start();
require_once '../dbconnect.php';
if (!isset($_SESSION['patient_id'])) {
    header('location:../login.php');
    exit();
}

$id = $_SESSION['patient_id'];
$qry = "SELECT * FROM patients WHERE patient_code=?";
$stmt = $conn->prepare($qry);
$stmt->bind_param("s", $id);
$stmt->execute();
$result = $stmt->get_result();
$row = ($result->num_rows > 0) ? $result->fetch_assoc() : die("Patient not found");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CareSync | Patient Portal</title>
    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/patient_dashboard.css?v=<?php echo time(); ?>">
    <script src="https://unpkg.com/lucide@latest"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>

    <div class="sidebar shadow">
        <div class="text-center mb-5">
            <img src="../Assets/CareSyncLogo.png" width="45" alt="Logo">
            <h4 class="text-white fw-bold mt-2" style="font-family: 'Custom';">CareSync</h4>
        </div>
        
        <nav class="nav flex-column">
            <a class="nav-link active" href="#"><i data-lucide="layout-dashboard"></i> <span>Dashboard</span></a>
            <a class="nav-link" href="./search_doctor.php"><i data-lucide="search"></i> <span>Search Doctor</span></a>
            <a class="nav-link" href="#"><i data-lucide="calendar"></i> <span>Appointments</span></a>
            <a class="nav-link" href="#"><i data-lucide="pill"></i> <span>Prescriptions</span></a>
            <a class="nav-link" href="#"><i data-lucide="file-text"></i> <span>Health Reports</span></a>
        </nav>

        <a href="../logout.php" class="nav-link logout-link">
            <i data-lucide="log-out"></i> <span>Logout</span>
        </a>
    </div>

    <div class="main-content">
        
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold mb-0">Patient Overview</h2>
                <p class="text-muted">Welcome back, <?php echo explode(' ', $row['full_name'])[0]; ?></p>
            </div>
            <div class="glass-card p-2 px-3 d-flex align-items-center gap-3 shadow-sm">
                <i data-lucide="bell" size="20" class="text-primary"></i>
                <div class="vr"></div>
                <img src="../icons/crowd.png" width="35" class="rounded-circle shadow-sm">
            </div>
        </div>

        <div class="welcome-banner mb-5 shadow-lg">
            <div class="row align-items-center">
                <div class="col-lg-8">
                    <span class="badge bg-light text-primary mb-3 px-3 py-2 rounded-pill fw-bold">Health Status: Great</span>
                    <h1 class="fw-bold display-5">Stay Healthy, Stay Fit!</h1>
                    <p class="opacity-75 fs-5">You have a follow-up appointment in 2 days. Check your vitals below.</p>
                    <button class="btn btn-light rounded-pill px-5 py-2 fw-bold text-primary mt-3">My Appointments</button>
                </div>
            </div>
            <i data-lucide="heart-pulse" size="180" class="banner-icon"></i>
        </div>

        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="glass-card p-4 h-100">
                    <div class="icon-box bg-light text-danger mb-3"><i data-lucide="droplet"></i></div>
                    <h6 class="text-muted fw-bold small">BLOOD GROUP</h6>
                    <div class="h3 fw-bold text-primary"><?php echo $row['blood_group']; ?></div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-4 h-100">
                    <div class="icon-box bg-light text-primary mb-3"><i data-lucide="calendar"></i></div>
                    <h6 class="text-muted fw-bold small">UPCOMING VISITS</h6>
                    <div class="h3 fw-bold text-primary">02</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-4 h-100">
                    <div class="icon-box bg-light text-warning mb-3"><i data-lucide="pill"></i></div>
                    <h6 class="text-muted fw-bold small">PRESCRIPTIONS</h6>
                    <div class="h3 fw-bold text-primary">01</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="glass-card p-4 h-100">
                    <div class="icon-box bg-light text-success mb-3"><i data-lucide="file-check"></i></div>
                    <h6 class="text-muted fw-bold small">READY REPORTS</h6>
                    <div class="h3 fw-bold text-primary">03</div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="glass-card p-4">
                    <h5 class="fw-bold mb-4">Activity & Wellness</h5>
                    <div class="chart-container">
                        <canvas id="healthChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="glass-card p-4 h-100">
                    <h5 class="fw-bold mb-4">Medication</h5>
                    <div class="p-3 bg-white rounded-4 border mb-3">
                        <h6 class="mb-1 fw-bold">Amoxicillin</h6>
                        <small class="text-muted">Twice daily - After food</small>
                    </div>
                    <button class="btn btn-primary w-100 rounded-pill py-3 fw-bold mt-auto">View Full List</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        lucide.createIcons();

        const ctx = document.getElementById('healthChart').getContext('2d');
        const chartGradient = ctx.createLinearGradient(0, 0, 0, 300);
        chartGradient.addColorStop(0, 'rgba(0, 97, 255, 0.2)');
        chartGradient.addColorStop(1, 'rgba(0, 97, 255, 0)');

        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4'],
                datasets: [{
                    data: [4000, 6500, 5200, 8500],
                    borderColor: '#0061ff',
                    borderWidth: 4,
                    backgroundColor: chartGradient,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#fff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { display: false },
                    x: { grid: { display: false } }
                }
            }
        });
    </script>
</body>
</html>