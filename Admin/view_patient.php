<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>

    <link rel="stylesheet" href="../Bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="../styles/view_patient.css">

</head>

<body>

    <div class="container py-5">

        <div class="header-section">
            <img src="../icons/crowd.png" width="45">
            <div>
                <h2>Patient Profile</h2>
                <p>CareSync Medical Record</p>
            </div>
        </div>

        <?php

        require_once '../dbconnect.php';

        if (!isset($_GET['id'])) {
            header('location:view_patient.php');
            exit();
        }

        $id = $_GET['id'];

        $qry = "SELECT * FROM patients WHERE patient_code=?";
        $stmt = $conn->prepare($qry);
        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {

            $data = $result->fetch_assoc();

            ?>

            <div class="patient-card">

                <div class="patient-top">

                    <div class="avatar">
                        <img src="../icons/crowd.png">
                    </div>

                    <div class="patient-name">
                        <h3>
                            <?php echo $data['full_name']; ?>
                        </h3>
                        <p>Patient ID :
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
                                <?php echo $data['mobile']; ?>
                            </p>
                        </div>

                        <div class="info">
                            <span>🎂 Date of Birth</span>
                            <p>
                                <?php echo $data['dob']; ?>
                            </p>
                        </div>

                        <div class="info">
                            <span>🩸 Blood Group</span>
                            <p>
                                <?php echo $data['blood_group']; ?>
                            </p>
                        </div>

                    </div>

                    <div class="col-md-6">

                        <div class="info">
                            <span>🆔 Aadhar Number</span>
                            <p>
                                <?php echo $data['aadhar']; ?>
                            </p>
                        </div>

                        <div class="info">
                            <span>🏙 City</span>
                            <p>
                                <?php echo $data['city']; ?>
                            </p>
                        </div>

                        <div class="info">
                            <span>🏠 Address</span>
                            <p>
                                <?php echo $data['address']; ?>
                            </p>
                        </div>

                    </div>

                </div>

                <div class="btn-area">

                    <a href="edit_patient.php?id=<?php echo $id ?>" class="btn btn-warning">Edit</a>

                    <a href="delete_patient.php?id=<?php echo $id ?>" class="btn btn-danger">Delete</a>

                    <a href="manage_patient.php" class="btn btn-primary">Back</a>

                </div>

            </div>

            <?php

        } else {

            echo "<h3 class='text-white text-center'>Invalid Patient ID</h3>";

        }

        ?>
    </div>
    <script src="../Bootstrap/bootstrap.bundle.min.js"></script>
</body>

</html>