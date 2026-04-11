<?php
require "../dbconnect.php";
/* SEARCH LOGIC */
$search = "";
if (isset($_GET['search'])) {
    $search = $_GET['search'];
    $sql = "SELECT * FROM patients 
            WHERE patient_code LIKE '%$search%' 
            OR full_name LIKE '%$search%' 
            OR mobile LIKE '%$search%'
            ORDER BY patient_code DESC";
} else {
    $sql = "SELECT * FROM patients ORDER BY patient_code DESC";
}
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management - CareSync</title>
    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/manage_patient.css">
</head>
<body class="admin-bg">
    <div class="container-fluid px-4 py-4">
        <div class="card shadow-lg border-0">
            <!-- HEADER -->
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center gap-2 manage_patient">
                    <img src="../icons/crowd.png" width="40">
                    <h4 class="mb-0 fw-bold">Patient Management</h4>
                </div>
                <a href="admin_dashboard.php" class="btn btn-light btn-rounded px-4">
                    Go Back
                </a>
            </div>
            <!-- BODY -->

            <div class="card-body">
                <!-- SEARCH BAR -->
                <form method="GET">
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <input type="text" name="search" class="form-control shadow-sm"
                                placeholder="Search Patient by ID, Name or Phone" value="<?php echo $search; ?>">
                        </div>
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
                               <th>Patient ID</th>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Gender</th>
                                <th>Mobile</th>
                                <th>City</th>
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
                                            <?php echo $row['patient_code']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['full_name']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['dob']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['gender']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['mobile']; ?>
                                        </td>

                                        <td>
                                            <?php echo $row['city']; ?>
                                        </td>
                                        <td>

                                            <a class="btn btn-success btn-sm btn-rounded fw-bold me-2"
                                                href="view_patient.php?id=<?php echo $row['patient_code']; ?>">
                                                View
                                            </a>

                                            <a class="btn btn-success btn-sm btn-rounded fw-bold me-2"
                                                href="edit_patient.php?id=<?php echo $row['patient_code']; ?>">
                                                Edit
                                            </a>

                                            <a href="delete_patient.php?id=<?php echo $row['patient_code']?>"class="btn btn-danger btn-sm btn-rounded fw-bold" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal"
                                                onclick="setDeleteId('<?php echo $row['patient_code']; ?>')">
                                                Delete
                                            </a>

                                        </td>
                                    </tr>
                                    <?php
                                }
                            } else {

                                echo "<tr><td colspan='7'>No Patients Found</td></tr>";

                            }

                            ?>
                        </tbody>
                    </table>
                </div>
         </div>
        </div>
    </div>
    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
    <!-- DELETE MODAL -->

    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center">
                    <h5>Are you sure you want to delete this patient?</h5>
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
        function setDeleteId(patientId) {

            document.getElementById("deleteBtn").href =
                "delete_patient.php?id=" + patientId;
        }

    </script>
</body>
</html>