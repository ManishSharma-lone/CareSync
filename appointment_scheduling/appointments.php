<?php
session_start();
require_once '../dbconnect.php';

if (!function_exists('connectDB')) {
    function connectDB() {
        global $conn;
        return $conn;
    }
}

if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$conn = connectDB();
$user_id = $_SESSION['user_id'];
$role = $_SESSION['role'];

// Handle AJAX cancellation
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['ajax_cancel'])) {
    header('Content-Type: application/json');

    if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
        echo json_encode(['success' => false, 'message' => 'Invalid CSRF token']);
        exit;
    }

    $appointment_id = filter_var($_POST['appointment_id'], FILTER_VALIDATE_INT);
    if ($appointment_id === false || $appointment_id <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid appointment ID']);
        exit;
    }

    $cancellation_reason = isset($_POST['reason']) ? trim($_POST['reason']) : '';

    try {
        $conn->begin_transaction();

        $stmt = $conn->prepare("
            SELECT a.*, t.start_time, t.doctor_code, 
                   d.name as doctor_name, p.name as patient_name
            FROM appointments a
            JOIN time_slots t ON a.slot_id = t.id
            JOIN users d ON t.doctor_code = d.id
            JOIN users p ON a.patient_code = p.id
            WHERE a.id = ? AND (a.patient_code = ? OR t.doctor_code = ?) AND a.status = 'confirmed'
        ");

        $stmt->bind_param("iii", $appointment_id, $user_id, $user_id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            throw new Exception("Appointment not found or already cancelled.");
        }

        $appointment = $result->fetch_assoc();
        $canceller_type = ($appointment['patient_code'] == $user_id) ? 'patient' : 'doctor';
        $canceller_name = ($canceller_type == 'patient') ? $appointment['patient_name'] : $appointment['doctor_name'];

        $update = $conn->prepare("UPDATE appointments SET status = 'cancelled', updated_at = NOW() WHERE id = ?");
        $update->bind_param("i", $appointment_id);
        $update->execute();

        $notification_recipient_id = ($canceller_type == 'patient') ? $appointment['doctor_code'] : $appointment['patient_code'];
        $notification_message = "Your appointment on " . date('l, F j, Y', strtotime($appointment['start_time'])) . " has been cancelled.";
        $notify = $conn->prepare("INSERT INTO notifications (user_id, message, type) VALUES (?, ?, 'appointment')");
        $notify->bind_param("is", $notification_recipient_id, $notification_message);
        $notify->execute();

        $free_slot = $conn->prepare("UPDATE time_slots SET status = 'available', booked_count = GREATEST(booked_count - 1, 0) WHERE id = ?");
        $free_slot->bind_param("i", $appointment['slot_id']);
        $free_slot->execute();

        $conn->commit();
        echo json_encode(['success' => true, 'message' => 'Appointment cancelled successfully', 'appointment_id' => $appointment_id]);
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        exit;
    }
}

// Fetch all up-to-date appointments for the user/doctor
$appointments = [];
$error_message = "";

try {
    if ($role === 'doctor') {
        $query = "SELECT a.id, a.status, a.patient_code, a.reason, a.slot_id, u.name as username, t.start_time, t.end_time, t.location, t.doctor_code
            FROM appointments a JOIN time_slots t ON a.slot_id = t.id JOIN users u ON a.patient_code = u.id
            WHERE t.doctor_code = ? ORDER BY t.start_time DESC LIMIT 50";
    } else {
        $query = "SELECT a.id, a.status, a.patient_code, a.reason, a.slot_id, u.name as username, t.start_time, t.end_time, t.location, t.doctor_code
            FROM appointments a JOIN time_slots t ON a.slot_id = t.id JOIN users u ON t.doctor_code = u.id
            WHERE a.patient_code = ? ORDER BY t.start_time DESC LIMIT 50";
    }
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $date = date('Y-m-d', strtotime($row['start_time']));
        $appointments[$date][] = $row;
    }
} catch (Exception $e) {
    $error_message = "Error fetching appointments: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>CareSync | Appointments</title>
    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/<?php echo $role === 'doctor' ? 'doctor' : 'patient'; ?>_dashboard.css?v=<?php echo time(); ?>">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        .slot-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 16px; padding: 1.5rem; transition: 0.3s;
            border: 1px solid rgba(0,0,0,0.05); height: 100%;
        }
        .slot-card:hover { transform: translateY(-3px); box-shadow: 0 10px 20px rgba(0, 97, 255, 0.1); border-left: 4px solid var(--primary-blue, #0061ff); }
        .slot-card.cancelled { opacity: 0.6; border-left: 4px solid #dc3545; }
        .slot-card.completed { border-left: 4px solid #198754; }
        .slot-time { font-size: 1.25rem; font-weight: bold; color: #061727; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;}
        .slot-detail { color: #64748b; margin-bottom: 0.5rem; display: flex; align-items: center; gap: 8px;}
        .badge.cancelled { background-color: #f8d7da; color: #721c24; }
        .badge.confirmed { background-color: #cff4fc; color: #055160; }
        .badge.completed { background-color: #d1e7dd; color: #0f5132; }
    </style>
</head>
<body>

    <div class="sidebar shadow">
        <div class="text-center mb-5">
            <img src="../Assets/CareSyncLogo.png" width="45" alt="Logo">
            <h4 class="text-white fw-bold mt-2" style="font-family: 'Custom';">CareSync</h4>
        </div>
        
        <nav class="nav flex-column">
        <?php if ($role === 'doctor'): ?>
            <a class="nav-link" href="../Doctor/doctor_dashboard.php"><i data-lucide="layout-dashboard"></i> <span>Dashboard</span></a>
            <a class="nav-link active" href="appointments.php"><i data-lucide="calendar"></i> <span>Appointments</span></a>
            <a class="nav-link" href="../Doctor/manage_schedule.php"><i data-lucide="clock"></i> <span>My Schedule</span></a>
            <a class="nav-link" href="#"><i data-lucide="users"></i> <span>Patients</span></a>
            <a class="nav-link" href="#"><i data-lucide="clipboard-list"></i> <span>Notes</span></a>
        <?php else: ?>
            <a class="nav-link" href="../Patient/patient_dashboard.php"><i data-lucide="layout-dashboard"></i> <span>Dashboard</span></a>
            <a class="nav-link" href="../Patient/search_doctor.php"><i data-lucide="search"></i> <span>Search Doctor</span></a>
            <a class="nav-link active" href="appointments.php"><i data-lucide="calendar"></i> <span>Appointments</span></a>
            <a class="nav-link" href="#"><i data-lucide="pill"></i> <span>Prescriptions</span></a>
            <a class="nav-link" href="#"><i data-lucide="file-text"></i> <span>Health Reports</span></a>
        <?php endif; ?>
        </nav>

        <a href="../logout.php" class="nav-link logout-link mt-auto">
            <i data-lucide="log-out"></i> <span>Logout</span>
        </a>
    </div>

    <div class="main-content">
        <div class="d-flex justify-content-between align-items-center mb-5">
            <div>
                <h2 class="fw-bold mb-0">Appointments Log</h2>
                <p class="text-muted">Manage your upcoming and past consultations</p>
            </div>
            <?php if ($role === 'patient'): ?>
            <div class="d-flex gap-2">
                 <a href="calendar_booking.php" class="btn btn-primary rounded-pill px-4 fw-bold shadow-sm d-flex align-items-center gap-2">
                     <i data-lucide="calendar-plus" size="18"></i> Book New Session
                 </a>
            </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger rounded-4"><i data-lucide="alert-circle" class="me-2"></i> <?php echo htmlspecialchars($error_message); ?></div>
        <?php endif; ?>

        <?php if (empty($appointments)): ?>
            <div class="text-center py-5 opacity-50">
                <i data-lucide="calendar-x" size="64" class="mb-3 text-muted"></i>
                <h4>No appointments found</h4>
                <p>You have no scheduled history yet.</p>
            </div>
        <?php else: ?>
            <?php foreach ($appointments as $date => $day_apts): ?>
                <div class="mb-5">
                    <h5 class="fw-bold mb-3 d-flex align-items-center gap-2">
                        <i data-lucide="calendar-days" class="text-primary"></i> <?php echo date('l, F j, Y', strtotime($date)); ?>
                    </h5>
                    <div class="row g-4">
                        <?php foreach ($day_apts as $apt): ?>
                            <div class="col-md-6 col-lg-4">
                                <div class="slot-card <?php echo strtolower($apt['status']); ?>" id="apt-card-<?php echo $apt['id']; ?>">
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div class="slot-time">
                                            <i data-lucide="clock" size="20" class="text-muted"></i>
                                            <?php echo date('g:i A', strtotime($apt['start_time'])); ?>
                                        </div>
                                        <span class="badge rounded-pill <?php echo strtolower($apt['status']); ?>" id="status-badge-<?php echo $apt['id']; ?>">
                                            <?php echo ucfirst($apt['status']); ?>
                                        </span>
                                    </div>
                                    
                                    <div class="slot-detail fw-bold h6 text-dark mt-2">
                                        <i data-lucide="user" size="18" class="text-primary"></i> 
                                        <?php echo $role === 'doctor' ? $apt['username'] : 'Dr. ' . htmlspecialchars($apt['username']); ?>
                                    </div>
                                    <div class="slot-detail small text-muted">
                                        <i data-lucide="map-pin" size="16"></i> <?php echo htmlspecialchars($apt['location']); ?>
                                    </div>
                                    <?php if (!empty($apt['reason'])): ?>
                                    <div class="slot-detail small text-muted fst-italic">
                                        <i data-lucide="info" size="16"></i> "<?php echo htmlspecialchars($apt['reason']); ?>"
                                    </div>
                                    <?php endif; ?>

                                    <?php if ($apt['status'] === 'confirmed'): ?>
                                    <div class="mt-4" id="action-area-<?php echo $apt['id']; ?>">
                                        <button onclick="cancelApt(<?php echo $apt['id']; ?>)" class="btn btn-outline-danger w-100 rounded-pill fw-bold btn-sm">
                                            <i data-lucide="x-circle" size="16" class="me-1"></i> Cancel Session
                                        </button>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Toast Notification -->
    <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 1080">
        <div id="statusToast" class="toast align-items-center text-white border-0 bg-success rounded-4" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body fw-bold d-flex align-items-center gap-2">
                    <i data-lucide="check-circle"></i> <span id="toastMsg">Success</span>
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    </div>

    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
    <script>
        lucide.createIcons();

        function cancelApt(id) {
            if (!confirm('Are you sure you want to cancel this appointment?')) return;
            
            const formData = new FormData();
            formData.append('ajax_cancel', '1');
            formData.append('appointment_id', id);
            formData.append('csrf_token', '<?php echo $csrf_token; ?>');
            
            fetch('appointments.php', { method: 'POST', body: formData })
            .then(r => r.json())
            .then(data => {
                if (data.success) {
                    const card = document.getElementById('apt-card-' + id);
                    if (card) {
                        card.classList.remove('confirmed');
                        card.classList.add('cancelled');
                        document.getElementById('action-area-' + id).remove();
                        const badge = document.getElementById('status-badge-' + id);
                        badge.classList.remove('confirmed');
                        badge.classList.add('cancelled');
                        badge.innerText = 'Cancelled';
                    }
                    const toastMsg = document.getElementById('toastMsg');
                    toastMsg.innerText = data.message;
                    const toast = new bootstrap.Toast(document.getElementById('statusToast'));
                    toast.show();
                } else {
                    alert('Error: ' + data.message);
                }
            })
            .catch(e => alert('Connection failed'));
        }
    </script>
</body>
</html>