<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Doctor Schedule - CareSync</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../styles/doctor_schedule.css">
</head>

<body class="admin-bg">

    <div class="container-fluid px-4 py-4">

        <div class="card shadow-lg border-0">

            <!-- HEADER -->
            <div class="card-header schedule-header d-flex justify-content-between align-items-center">

                <div class="d-flex align-items-center gap-3">
                    <div class="icon-circle">
                        <img src="../icons/hospital.png" class="mx-auto mb-3" width="50">
                    </div>

                    <div class="appoint">
                        <h4 class="mb-0 fw-bold">
                            Appointment Scheduled
                        </h4>
                        <small>View appointments by department</small>
                    </div>
                </div>

                <a href="manage_doctor.php" class="btn btn-light btn-rounded ">
                    Go Back
                </a>

            </div>


            <!-- BODY -->
            <div class="card-body">

                <!-- FILTER SECTION -->
                <div class="row mb-4">

                    <!-- Department Dropdown -->
                    <div class="col-md-4">
                        <label class="fw-semibold mb-1">Select Department</label>
                        <select class="form-select shadow-sm">
                            <option>Select Department</option>
                            <option>Cardiology</option>
                            <option>Neurology</option>
                            <option>Orthopedics</option>
                            <option>Gynecology</option>
                            <option>Pediatrics</option>
                            <option>General Medicine</option>
                        </select>
                    </div>

                    <!-- Doctor Dropdown -->
                    <div class="col-md-4">
                        <label class="fw-semibold mb-1">Select Doctor</label>
                        <select class="form-select shadow-sm">
                            <option>Select Doctor</option>
                            <option>Dr. Sharma</option>
                            <option>Dr. Mehta</option>
                            <option>Dr. Das</option>
                        </select>
                    </div>

                    <!-- Date Filter -->
                    <div class="col-md-3">
                        <label class="fw-semibold mb-1">Select Date</label>
                        <input type="date" class="form-control shadow-sm">
                    </div>

                    <div class="col-md-1 d-flex align-items-end">
                        <button class="btn btn-primary btn-rounded w-100 fw-bold">
                            Go
                        </button>
                    </div>

                </div>


                <!-- TABLE -->
                <div class="table-responsive">

                    <table class="table table-hover align-middle text-center">

                        <thead class="table-dark">

                            <tr>
                                <th>Date</th>
                                <th>Doctor</th>
                                <th>Patient Name</th>
                                <th>Time Slot</th>
                                <th>Status</th>
                            </tr>

                        </thead>

                        <tbody>

                            <tr>
                                <td>10 Feb</td>
                                <td>Dr. Sharma</td>
                                <td>Ravi Kumar</td>
                                <td>09:30 AM</td>
                                <td>
                                    <span class="badge bg-success px-3 py-2">
                                        Confirmed
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>10 Feb</td>
                                <td>Dr. Sharma</td>
                                <td>Anita Das</td>
                                <td>10:00 AM</td>
                                <td>
                                    <span class="badge bg-primary px-3 py-2">
                                        Completed
                                    </span>
                                </td>
                            </tr>

                            <tr>
                                <td>10 Feb</td>
                                <td>Dr. Mehta</td>
                                <td>Suresh Nayak</td>
                                <td>11:30 AM</td>
                                <td>
                                    <span class="badge bg-danger px-3 py-2">
                                        Cancelled
                                    </span>
                                </td>
                            </tr>

                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
        <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>