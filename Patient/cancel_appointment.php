<?php
include __DIR__ . '/../dbconnect.php';

$id = $_GET['id'];

$conn->query("UPDATE appointments SET status='Cancelled' WHERE id=$id");

header("Location: my_appointments.php");
?>