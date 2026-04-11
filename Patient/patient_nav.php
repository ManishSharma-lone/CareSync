<!-- Navbar Start -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">

        <!-- Logo -->
        <a class="navbar-brand d-flex align-items-center" href="patient_dashboard.php">
            <img src="../Assets/CareSyncLogo.png" class="me-2" style="width:45px;height:45px;">
            CareSync
        </a>

        <!-- Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#patientNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Links -->
        <div class="collapse navbar-collapse" id="patientNavbar">
            <ul class="navbar-nav ms-auto">

                <li class="nav-item">
                    <a class="nav-link" href="patient_dashboard.php">Dashboard</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="book_appointment.php">Book Appointment</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="my_appointments.php">My Appointments</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="medical_records.php">Medical Records</a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#">
                        My Account
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a class="dropdown-item" href="profile.php">Profile</a></li>
                        <li><a class="dropdown-item" href="settings.php">Settings</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item text-danger" href="logout.php">Logout</a></li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>
<!-- Navbar End -->