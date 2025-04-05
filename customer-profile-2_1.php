<?php
    session_start();
    if (!isset($_SESSION['userLogin'])) {
        header("Location: login-form-2.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profile Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="Css/custom-2.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" />

</head>

<body>
    <?php include 'header-2.php' ?>
    <div class="container mt-5">
        <?php
            require_once './config/yunqing.php';
            if(isset($_POST['submitProfile'])){
                $studentId = $_POST['studentid'];
                $fullname = isset($_POST['fullname']) ? trim($_POST['fullname']) : "";
                $email = isset($_POST['email']) ? trim($_POST['email']) : "";
                $phone = isset($_POST['phone']) ? trim($_POST['phone']) : "";
                $gender = $_POST['gender'];

                $error['pnumber'] = checkStudentPNumber($phone);
                $error['email'] = checkStudentEmail($email);

                $error = array_filter($error);

                if (empty($error)) {
                    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    // Prepare and execute the update query
                    $stmt = $conn->prepare("UPDATE member SET fullname=?, email=?, phonenumber=?, gender=? WHERE studentid=?");
                    $stmt->bind_param("sssss", $fullname, $email, $phone, $gender, $studentId);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        // Update successful
                        echo '
                            <div class="alert alert-success" role="alert">
                                Profile Update SuccessFully !
                            </div>
                        ';
                    } else {
                        // No rows affected, profile update failed
                        echo '
                            <div class="alert alert-danger" role="alert">
                                Profile Update Failed !
                            </div>
                        ';
                    }
                }else{
                    foreach ($error as $errorValue) {
                        echo"
                            <div class='alert alert-danger' role='alert'>
                                $errorValue
                            </div>
                            ";
                    }
                }
            }else if(isset($_POST['resetPassword'])) {
                $studentid = $_SESSION['studentId'];
                $existingPassword = isset($_POST['existing_password']) ? trim($_POST['existing_password']) : "";
                $newPassword = isset($_POST['new_password']) ? trim($_POST['new_password']) : "";

                $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                // Retrieve the existing password from the database for the given student ID
                $stmt = $conn->prepare("SELECT password FROM member WHERE studentid = ?");
                $stmt->bind_param("s", $studentid);
                $stmt->execute();
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($storedPassword);
                    $stmt->fetch();
                    // Verify if the existing password matches the stored password (without hashing)
                    if ($existingPassword === $storedPassword) {
                        // Existing password matches, update the password in the database
                        $updateStmt = $conn->prepare("UPDATE member SET password = ? WHERE studentid = ?");
                        $updateStmt->bind_param("ss", $newPassword, $studentid);
                        $updateStmt->execute();

                        if ($updateStmt->affected_rows > 0) {
                            // Password update successful
                            echo "<div class='alert alert-success' role='alert'>Password updated successfully!</div>";
                        } else {
                            // No rows affected, password update failed
                            echo "<div class='alert alert-danger' role='alert'>Password updated failed!</div>";
                        }

                            $updateStmt->close();
                    } else {
                        // Existing password does not match, show alert message
                        echo "<div class='alert alert-danger' role='alert'>Existing password is incorrect!</div>";
                    }
                }
            }
        ?>
        <div class="row">
            <!-- Profile Picture Column -->
            <div class="col-lg-3 col-md-4 col-sm-6">
                <div class="card">
                    <img src="data:image/png;base64,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"
                        class="card-img-top" alt="Profile Picture">
                    <div class="card-body">
                        <?php
                            $conn = new mysqli("localhost", "root", "", "liyi");
                            $studentid = $_SESSION['studentId'];
                            $stmt = $conn->prepare("SELECT * FROM member WHERE studentid = ?");
                            $stmt->bind_param("s", $studentid);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if($result->num_rows > 0){
                                while($row = $result->fetch_assoc()) {
                                    echo '
                                        <h5 class="card-title">'.$row['fullname'].'</h5>
                                        <p class="card-text">Web Developer</p>
                                    ';
                                }
                            }
                        ?>

                    </div>
                </div>
                <!-- Contact Information Column -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Contact Information</h4>
                    </div>
                    <ul class="list-group list-group-flush">
                        <?php
                                $conn = new mysqli("localhost", "root", "", "liyi");
                                $studentid = $_SESSION['studentId'];
                                $stmt = $conn->prepare("SELECT * FROM member WHERE studentid = ?");
                                $stmt->bind_param("s", $studentid);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '
                                            <li class="list-group-item"><i class="fas fa-hashtag"></i> ' .$row['studentid'].'</li>
                                            <li class="list-group-item"><i class="fas fa-phone"></i> ' .$row['phonenumber'].'</li>
                                            <li class="list-group-item"><i class="fas fa-envelope"></i> ' .$row['email'].'</li>
                                        ';
                                    }
                                }
                        ?>
                    </ul>
                </div>
            </div>

            <!-- About Me Column -->
            <div class="col-lg-9 col-md-8 col-sm-6">
                <!-- User Input Form Column -->
                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Customer Profile</h4>
                    </div>
                    <div class="card-body">
                        <form action="customer-profile-2.php" method="post">
                            <?php
                                $conn = new mysqli("localhost", "root", "", "liyi");
                                $studentid = $_SESSION['studentId'];
                                $stmt = $conn->prepare("SELECT * FROM member WHERE studentid = ?");
                                $stmt->bind_param("s", $studentid);
                                $stmt->execute();
                                $result = $stmt->get_result();
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo '
                                            <div class="mb-3">
                                                <label for="name" class="form-label">Student Id:</label>
                                                <input type="text" class="form-control" value="'.$row['studentid'].'" disabled>
                                                <input type="hidden" class="form-control" name="studentid" value="'.$row['studentid'].'" >
                                            </div>
                                            <div class="mb-3">
                                                <label for="text" class="form-label">Full Name:</label>
                                                <input type="text" class="form-control" id="fullname" name="fullname" value="'.$row['fullname'].'" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="email" class="form-label">Email:</label>
                                                <input type="email" class="form-control" id="email" name="email" value="'.$row['email'].'" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="gender" class="form-label">Gender:</label>
                                                <select class="form-select" name="gender">
                                                    <option value="F" '.(($row["gender"] == "F") ? "selected" : "").'>Female</option>
                                                    <option value="M" '.(($row["gender"] == "M") ? "selected" : "").'>Male</option>
                                                </select>
                                            </div>
                                            <div class="mb-3">
                                                <label for="phone" class="form-label">Phone Number:</label>
                                                <input type="text" class="form-control" id="phone" name="phone" value="'.$row['phonenumber'].'" required>
                                            </div>
                                        ';
                                    }
                                }
                            ?>
                            <input type="submit" class="btn btn-primary" name="submitProfile" value="Submit" />
                        </form>
                    </div>
                </div>

                <div class="card mt-3">
                    <div class="card-header">
                        <h4>Reset Password</h4>
                    </div>
                    <div class="card-body">
                        <form method="post" onsubmit="return checkPasswords();">
                            <div class="mb-3">
                                <label for="password" class="form-label">Existing Password:</label>
                                <input type="password" class="form-control" id="existing_password"
                                    name="existing_password" required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password"
                                    required>
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Confirm New Password:</label>
                                <input type="password" class="form-control" id="confirm_password"
                                    name="confirm_password" required>
                            </div>
                            <input type="submit" class="btn btn-primary" name="resetPassword" value="Reset Password" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5">
        <?php include 'footer-2.php' ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    (function($) {
        $(window).scroll(function() {
            if ($(document).scrollTop() > 300) {
                // Navigation Bar
                $('.navbar').removeClass('fadeIn');
                $('.navbar').addClass('fixed-top animated fadeInDown');
            } else {
                $('.navbar').removeClass('fadeInDown');
                $('.navbar').removeClass('fixed-top');
                $('body').removeClass('shrink');
                $('.navbar').addClass('animated fadeIn');
            }
        });
    })(jQuery);

    function checkPasswords() {
        var newPassword = document.getElementById("new_password").value;
        var confirmPassword = document.getElementById("confirm_password").value;

        if (newPassword != confirmPassword) {
            alert("Passwords do not match. Please try again.");
            return false;
        }

        return true;
    }
    </script>
</body>

</html>