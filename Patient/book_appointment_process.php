<?php
session_start();
include '../dbconnect.php';

// 🔥 Get patient_code from session
$patient_code = $_SESSION['patient_id'];

// 🔥 Get real patient ID
$q = "SELECT id FROM patients WHERE patient_code='$patient_code'";
$res = $conn->query($q);

if($res->num_rows == 0){
    die("Invalid patient!");
}

$row = $res->fetch_assoc();
$patient_id = $row['id']; // ✅ REAL numeric ID

// Get form data
$doctor_id = $_POST['doctor_id'];
$date = $_POST['date'];
$time = $_POST['slot'];

// 🔥 CHECK SLOT BEFORE INSERT
$check = "SELECT * FROM appointments 
          WHERE doctor_id='$doctor_id' 
          AND appointment_date='$date' 
          AND appointment_time='$time' 
          AND status!='Cancelled'";

$result = $conn->query($check);

if($result->num_rows > 0){
    echo "<script>
    alert('Slot already booked!');
    window.location='book_appointment.php';
    </script>";
    exit();
}

// ✅ INSERT APPOINTMENT
$query = "INSERT INTO appointments 
(patient_id, doctor_id, appointment_date, appointment_time, status)
VALUES ('$patient_id','$doctor_id','$date','$time','Pending')";

if($conn->query($query)){
    echo "<script>
    alert('Appointment Booked Successfully');
    window.location='patient_dashboard.php';
    </script>";
} else {
    echo "Error: " . $conn->error;
}
?>