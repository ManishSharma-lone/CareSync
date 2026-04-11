<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Details</title>

    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/view_doctor.css">

</head>
<body>
    <div class="container py-5">
        <div class="header-section">
            <img src="../icons/doctor.png" width="45">
            <div>
                <h2>Doctor Profile</h2>
                <p>CareSync Medical Record</p>
            </div>
        </div>

        <?php

        require_once '../dbconnect.php';

        /* Check if id exists */

        if (!isset($_GET['id'])) {
            header('location:manage_doctor.php');
            exit();
        }

        /* Sanitize id */

          $id = $_GET['id'];

        /* Query */

        $qry = "SELECT * FROM doctors WHERE doctor_code = ?";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $data = $result->fetch_assoc();
            ?>

            <div class="doctor-card">
                <div class="doctor-top">

                    <div class="avatar">
                        <img src="../icons/medical-team.png">
                    </div>

                    <div class="doctor-name">
                        <h3>
                            <?php echo $data['full_name']; ?>
                        </h3>
                        <p>Doctor ID :
                            <?php echo $id; ?>
                        </p>
                    </div>

                </div>

                <div class="row mt-4">

                    <div class="col-md-6">

                        <div class="info">
                            <span>📧 Email</span>
                            <p>
                                <?php echo $data['email']; ?>
                            </p>
                        </div>

                        <div class="info">
                            <span>📱 Mobile</span>
                            <p>
                                <?php echo $data['contact']; ?>
                            </p>
                        </div>

                        <div class="info">
                            <span>🏥 Department</span>
                            <p>
                                <?php echo $data['department']; ?>
                            </p>
                        </div>

                    </div>

                    <div class="col-md-6">
                        <div class="info">
                            <span>🩺 Specialization</span>
                            <p>
                                <?php echo $data['specialization']; ?>
                            </p>
                        </div>
                        <div class="info">
                            <span>⭐ Experience</span>
                            <p>
                                <?php echo $data['experience']; ?> Years
                            </p>
                        </div>
                </div>

                </div>
                <div class="btn-area">
                    <a href="edit_doctor.php?id=<?php echo $id ?>" class="btn btn-warning">Edit</a>

                    <a href="delete_doctor.php?id=<?php echo $id ?>" class="btn btn-danger"
                        onclick="return confirm('Are you sure you want to delete this doctor?')">
                        Delete
                 </a>
                    <a href="manage_doctor.php" class="btn btn-primary">Back</a>
                </div>
           </div>
            <?php
        } else {

            echo "<h3 class='text-white text-center'>Invalid Doctor ID</h3>";

        }
        ?>
    </div>
    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>

</body>

</html>