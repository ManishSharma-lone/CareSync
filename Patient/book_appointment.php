<?php
include __DIR__ . '/../dbconnect.php';
session_start();

// TEMP (later replace with session)
$patient_id = 2;

// Fetch doctors
$doctors = $conn->query("SELECT * FROM doctors");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Appointment - CareSync</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../styles/book_appointment.css">
</head>

<body>

<!-- 🔷 MAIN CONTAINER -->
<div class="container mt-4">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

                <div class="row g-0">

                    <!-- 🔷 LEFT IMAGE -->
                    <div class="col-md-5 d-none d-md-block">
                        <img src="../Assets/Hero.jpg" 
                             class="img-fluid h-100 w-100 object-fit-cover" 
                             alt="Hospital">
                    </div>

                    <!-- 🔷 RIGHT FORM -->
                    <div class="col-md-7">

                        <!-- HEADER -->
                        <div class="bg-primary text-white text-center p-4">
                            <h3 class="mb-0">Book Appointment</h3>
                            <small>Quick & Easy Scheduling</small>
                        </div>

                        <!-- FORM -->
                        <div class="p-4">

                            <form action="book_appointment_process.php" method="POST" onsubmit="return validateBooking()">
                                <!-- Doctor -->
                                <label class="form-label">Select Doctor</label>
                                <select name="doctor_id" id="doctor" class="form-select mb-3" required>
                                    <option value="">Choose Doctor</option>
                                    <?php while($row = $doctors->fetch_assoc()) { ?>
                                        <option value="<?= $row['id'] ?>">
                                            Dr <?= $row['full_name'] ?> - <?= $row['department'] ?>
                                        </option>
                                    <?php } ?>
                                </select>

                                <!-- Date -->
                                <label class="form-label">Appointment Date</label>
                                <input type="date" id="date" name="date"
                                    class="form-control mb-3"
                                    min="<?= date('Y-m-d') ?>" required>

                                <!-- Slots -->
                                <label class="form-label">Available Slots</label>

                                <div class="d-flex flex-wrap gap-2 mb-3">
                                    

                                    <input type="radio" class="btn-check" name="slot" value="09:00:00" id="s1">
                                    <label class="btn btn-outline-primary" for="s1">09:00 AM</label>

                                    <input type="radio" class="btn-check" name="slot" value="09:30:00" id="s2">
                                    <label class="btn btn-outline-primary" for="s2">09:30 AM</label>

                                    <input type="radio" class="btn-check" name="slot" value="10:00:00" id="s3">
                                    <label class="btn btn-outline-primary" for="s3">10:00 AM</label>

                                </div>

                                <!-- Status 
                                <div class="mb-3 text-end">
                                    <span class="badge bg-warning text-dark px-3 py-2" id="statusText">
                                        Check Availability
                                    </span>
                                </div>-->

                                <!-- Hidden -->
                               

                                <!-- Submit -->
                                <button type="submit" class="btn btn-primary w-100 py-2 rounded-3">
                                    Confirm Appointment
                                </button>

                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ✅ 🔥 BACK BUTTON AT BOTTOM (CORRECT PLACE) -->
    <div class="text-center mt-4">
       <a href="patient_dashboard.php" 
   class="btn back-btn px-4 py-2 rounded-pill shadow-sm">
    ← Back to Dashboard
</a>
    </div>

</div>

<!-- 🔷 AJAX SCRIPT -->
<script>
document.getElementById("date").addEventListener("change", checkSlots);
document.getElementById("doctor").addEventListener("change", checkSlots);

document.querySelectorAll("input[name='slot']").forEach(el => {
    el.addEventListener("change", checkAvailability);
});

// 🔥 Check all slots and disable booked ones
function checkSlots() {

    let doctor = document.getElementById("doctor").value;
    let date = document.getElementById("date").value;

    if(doctor && date){

        document.querySelectorAll("input[name='slot']").forEach(slot => {

            let label = document.querySelector(`label[for='${slot.id}']`);

            // reset
            slot.disabled = false;
            label.classList.remove("btn-danger");

            // remove ❌ safely
            label.innerText = label.innerText.replace(" ❌", "");

            fetch(`check_availability.php?doctor_id=${doctor}&date=${date}&time=${slot.value}`)
            .then(res => res.text())
            .then(data => {

                if(data.trim() === "Not Available"){
                    slot.disabled = true;
                    label.classList.add("btn-danger");
                    label.innerText += " ❌";
                }

            });

        });

    }
}

// 🔥 Check selected slot
function checkAvailability() {

    let doctor = document.getElementById("doctor").value;
    let date = document.getElementById("date").value;
    let slot = document.querySelector("input[name='slot']:checked");

    if(doctor && date && slot){

        fetch(`check_availability.php?doctor_id=${doctor}&date=${date}&time=${slot.value}`)
        .then(res => res.text())
        .then(data => {

            // just store result internally
            window.currentStatus = data.trim();

        });

    }
}

// 🔥 Prevent wrong booking
function validateBooking(){

    if(window.currentStatus !== "Available"){
        alert("Slot not available!");
        return false;
    }

    return true;
}
</script>
<script>
function validateBooking(){

    let status = document.getElementById("statusText").innerText;

    // If not available → stop form
    if(status !== "Available"){
        alert("Please select an available slot!");
        return false; // ❌ stops form submission
    }

    return true; // ✅ allows form submission
}
</script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>