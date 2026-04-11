<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Doctor</title>
    <link rel="stylesheet" href="../bootstrap/bootstrap.min.css">

    <link rel="stylesheet" href="../styles/search_doctor.css">
</head>

<body>

    <!-- Top Header -->
    <div class="top-header d-flex align-items-center px-4 py-3">
        <img src="../Assets/CareSyncLogo.png" width="45">
        <h4 class="ms-3 mb-0 text-white fw-bold">Search Doctor</h4>
    </div>

    <div class="container py-5">

        <!-- Search & Filter Card -->
        <div class="card shadow-lg border-0 p-4 mb-5 search-card">

            <div class="input-group mb-4">
                <span class="input-group-text bg-primary text-white">
                    <img src="../icons/medical-staff.png" class="mx-auto mb-3" width="30">
                </span>
                <input type="text" class="form-control form-control-lg" placeholder="Search by name or specialization">
            </div>

            <div class="row g-4">

                <div class="col-md-4">
                    <label class="form-label fw-semibold">Department</label>
                    <select class="form-select form-select-lg">
                        <option value="">Select Department</option>
                        <option value="Cardiology">Cardiology</option>
                        <option value="Neurology">Neurology</option>
                        <option value="Orthopedics">Orthopedics</option>
                        <option value="Gynecology">Gynecology</option>
                        <option value="Pediatrics">Pediatrics</option>
                        <option value="General Medicine">General Medicine</option>
                    </select>
                </div>

                <div class="col-md-8">
                    <label class="form-label fw-semibold">
                        Experience: <span id="expValue">5</span> Years
                    </label>
                    <input type="range" class="form-range" min="1" max="30" value="5"
                        oninput="expValue.innerText = this.value">
                </div>

            </div>
        </div>

        <!-- Doctor Results -->
        <div class="row g-4">

            <!-- Doctor 1 -->
            <div class="col-lg-4 col-md-6">
                <div class="card doctor-card border-0 shadow h-100">
                    <div class="card-body text-center">
                        <img src="../Assets/doctor1.jpg" class="doctor-img mb-3">
                        <h5 class="fw-bold text-primary">Dr. Amit Mehta</h5>
                        <p class="text-muted mb-2">
                            Cardiologist | 12 Years Exp
                        </p>
                        <span class="badge bg-warning text-dark mb-3">
                            ⭐ 4.8 Rating
                        </span>

                        <div class="d-grid gap-2">
                            <a class="btn btn-outline-primary">
                                View Profile
                            </a>
                            <a class="btn btn-success" href="./check_availability.php">
                                Check Availability
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Doctor 2 -->
            <div class="col-lg-4 col-md-6">
                <div class="card doctor-card border-0 shadow h-100">
                    <div class="card-body text-center">
                        <img src="../Assets/doctor2.jpg" class="doctor-img mb-3">
                        <h5 class="fw-bold text-primary">Dr. Priya Sharma</h5>
                        <p class="text-muted mb-2">
                            Neurologist | 9 Years Exp
                        </p>
                        <span class="badge bg-warning text-dark mb-3">
                            ⭐ 4.6 Rating
                        </span>

                        <div class="d-grid gap-2">
                            <button class="btn btn-outline-primary">
                                View Profile
                            </button>
                            <button class="btn btn-success">
                                Check Availability
                            </button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>