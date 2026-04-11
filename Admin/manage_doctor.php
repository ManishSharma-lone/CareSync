<?php
require "../dbconnect.php";
session_start();
$search = isset($_GET['search']) ? trim($_GET['search']) : "";
$department = isset($_GET['department']) ? trim($_GET['department']) : "";

$sql = "SELECT * FROM doctors WHERE 1";

if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " AND (doctor_code LIKE '%$search%' 
               OR full_name LIKE '%$search%')";
}

if (!empty($department)) {
    $department = $conn->real_escape_string($department);
    $sql .= " AND LOWER(TRIM(department)) = LOWER(TRIM('$department'))";
}

$sql .= " ORDER BY doctor_code DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Doctor Management - CareSync</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../styles/manage_doctor.css">

</head>

<body class="admin-bg">
    <div class="container-fluid">
        <!-- HEADER -->
        <div class="card shadow-lg border-0 mt-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <div class="mb-0 manage_doctor">
                    <img src="../icons/medical-staff.png" class="mx-auto mb-3" width="50">
                    Doctor Management
                </div>
                <a href="admin_dashboard.php" class="btn btn-light btn-rounded">
                    Go Back
                </a>
            </div>


            <div class="card-body">

                <!-- SEARCH AND FILTER -->
                <form method="GET">
                    <div class="row mb-3">

                        <!-- Search by ID or Name -->
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control" placeholder="Search by ID or Name..."
                                value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                        </div>

                        <!-- Filter by Specialization -->
                        <div class="col-md-3">
                            <select name="department" class="form-control">
                                <option value="">--SELECT--</option>

                                <option value="Cardiology" <?php if ($department == "Cardiology")
                                    echo "selected"; ?>>
                                    Cardiology</option>

                                <option value="Neurology" <?php if ($department == "Neurology")
                                    echo "selected"; ?>>
                                    Neurology</option>

                                <option value="Orthopedics" <?php if ($department == "Orthopedics")
                                    echo "selected"; ?>>Orthopedics</option>

                                <option value="Gynecology" <?php if ($department == "Gynecology")
                                    echo "selected"; ?>>
                                    Gynecology</option>

                                <option value="Pediatrics" <?php if ($department == "Pediatrics")
                                    echo "selected"; ?>>
                                    Pediatrics</option>

                                <option value="General Medicine" <?php if ($department == "General Medicine")
                                    echo "selected"; ?>>General Medicine</option>
                            </select>
                        </div>

                        <!-- Search Button -->
                        <div class="col-md-2">
                            <button class="btn btn-primary btn-rounded px-4 fw-bold">
                                Search
                            </button>
                        </div>

                    </div>
                </form>

                <!-- TABLE -->
                <div class="table-responsive">
                    <table class="table table-hover align-middle text-center">
                        <thead class="table-dark">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Department</th>
                                <th>Specialization</th>
                                <th>Experience</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td>
                                            <?php echo $row['doctor_code']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['full_name']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['department']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['specialization']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['experience']; ?>
                                        </td>

                                        <td>

                                            <a class="btn btn-success btn-sm btn-rounded fw-bold me-2"
                                                href="view_doctor.php?id=<?php echo $row['doctor_code']; ?>">
                                                View
                                            </a>

                                            <a class="btn btn-success btn-sm btn-rounded fw-bold me-2"
                                                href="edit_doctor.php?id=<?php echo $row['doctor_code']; ?>">
                                                Edit
                                            </a>

                                            <a href="delete_doctor.php?id=<?php echo $row['doctor_code'] ?>"
                                                class="btn btn-danger btn-sm btn-rounded fw-bold" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                onclick="setDeleteId('<?php echo $row['doctor_code']; ?>')">
                                                Delete
                                            </a>

                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {

                                echo "<tr><td colspan='7'>No Doctors Found</td></tr>";

                            }
                            ?>
                        </tbody>

                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <h5>Are you sure you want to delete this doctor?</h5>
                </div>
                <div class="modal-footer justify-content-center">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <a id="deleteBtn" class="btn btn-danger">Delete</a>
                </div>
            </div>
        </div>
    </div>
    <script>
        /* PASS PATIENT ID TO DELETE BUTTON */
        function setDeleteId(doctorId) {
            document.getElementById("deleteBtn").href =
                "delete_doctor.php?id=" + doctorId;
        }

    </script>
</body>
</html>