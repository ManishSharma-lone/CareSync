<?php
require_once 'dbconnect.php';
$res = $conn->query("DESCRIBE time_slots");
while ($row = $res->fetch_assoc()) {
    print_r($row);
}
?>
