<?php
include '../dbconnect.php';

$doctor_id = $_GET['doctor_id'] ?? '';
$date = $_GET['date'] ?? '';
$time = $_GET['time'] ?? '';

if($doctor_id && $date && $time){

    $query = "SELECT * FROM appointments 
              WHERE doctor_id='$doctor_id'
              AND appointment_date='$date'
              AND appointment_time='$time'
              AND status!='Cancelled'";

    $result = $conn->query($query);

    if($result->num_rows > 0){
        echo "Not Available";
    } else {
        echo "Available";
    }

} else {
    echo "Select all fields";
}
?>