<?php
include '../dbconnect.php';

$doctor_id = $_GET['doctor_id'] ?? 0;
$date = $_GET['date'] ?? '';

if(!$doctor_id || !$date) {
    echo '<div class="form-text mt-3 text-muted">Please select a doctor and date to view slots.</div>';
    exit;
}

// Get user ID of doctor
$stmt = $conn->prepare("SELECT users.id FROM users INNER JOIN doctors ON users.doctor_code = doctors.doctor_code WHERE doctors.id = ?");
$stmt->bind_param("i", $doctor_id);
$stmt->execute();
$res = $stmt->get_result();
if ($res->num_rows == 0) {
    echo '<div class="text-danger">Invalid doctor.</div>';
    exit;
}
$doctor_user_id = $res->fetch_assoc()['id'];

// Get slots
$slotsQuery = $conn->prepare("SELECT * FROM time_slots WHERE doctor_code = ? AND DATE(start_time) = ? AND status = 'available'");
$slotsQuery->bind_param("is", $doctor_user_id, $date);
$slotsQuery->execute();
$slots = $slotsQuery->get_result();

if($slots->num_rows == 0) {
    echo '<div class="text-danger fw-bold"><i data-lucide="calendar-x" size="18" class="me-1" style="vertical-align: text-bottom;"></i> No available slots found for this date. Please try another date.</div>';
    echo '<script>lucide.createIcons();</script>';
    exit;
}

$html = '<div class="d-flex flex-wrap gap-3">';
while($s = $slots->fetch_assoc()) {
    $time_str = date('h:i A', strtotime($s['start_time']));
    $id = "slot_" . $s['id'];
    $html .= '
        <input type="radio" class="btn-check" name="slot_id" value="'.$s['id'].'" id="'.$id.'" required>
        <label class="btn btn-outline-primary rounded-pill px-4 py-2 fw-medium border-2" for="'.$id.'">
            <i data-lucide="clock" size="16" class="me-1"></i> '.$time_str.'
        </label>
    ';
}
$html .= '</div>';
echo $html;
?>
