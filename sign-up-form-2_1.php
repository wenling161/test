<!DOCTYPE html>
<html lang="en">

    <head>
        <title>Login</title>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="Css/custom-2.css">
        <style>
            a {
                text-decoration: none;
            }

            .login-page {
                width: 100%;
                display: inline-block;
                display: flex;
                align-items: center;
            }

            .form-right i {
                font-size: 100px;
            }
        </style>

    </head>

    <body>

        <?php include 'header-2.php' ?>
        <div class="login-page bg-light">
            <div class="container mt-5">
                <?php
                include './ass_helper.php';

                global $stud_id;
                global $name;
                global $gender;
                global $email;
                global $contact;
                global $password;
                if (!empty($_POST)) {

                    $name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
                    $stud_id = isset($_POST["studentid"]) ? trim($_POST["studentid"]) : "";
                    $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";
                    $gender = isset($_POST["gender"]) ? trim($_POST["gender"]) : "";
                    $contact = isset($_POST["contact"]) ? trim($_POST["contact"]) : "";
                    $password = isset($_POST["password"]) ? trim($_POST["password"]) : "";

                    $error['name'] = validateStudentName($name);
                    $error['stud_id'] = validateStudentID($stud_id);
                    $error['gender'] = validateGender($gender);
                    $error['contact'] = validatePhoneNumber($contact);
                    $error['password'] = validatePassword($password);
                    $error = array_filter($error);

                    if (empty($error)) {
                        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                        $sql = '
                        INSERT INTO member(studentid, fullname, email, gender, phonenumber, password)
                        VALUES (?, ?, ?, ?, ?, ?)
                        ';

                        $smt = $con->prepare($sql);
                        // s - string, b - blob, i - integer, d - double
                        $smt->bind_param("ssssss", $stud_id, $name, $email, $gender, $contact, $password);
                        $smt->execute();

                        if ($smt->affected_rows > 0) {
                            echo '
                                    <div class="alert alert-success" role="alert">
                                        Student <strong>"' . $name . '"</strong> has been inserted. <a href="login-form-2.php" class="alert-link">Go to Login</a>
                                    </div>';

                            $stud_id = $name = $email = $gender = $contact = $password = null;
                        } else {
                            echo '
                                <div class="alert alert-danger" role="alert">
                                    Opps. Database issue. Record not inserted. <a href="homepage-2.php" class="alert-link">Back to Homepage</a>
                                </div>';
                        }

                        $smt->close();
                        $con->close();
                    } else {
                        foreach ($error as $value) {
                            echo "
                                <div class='alert alert-danger' role='alert'>
                                    $value
                                </div>
                            ";
                        }
                    }
                }
                ?>
                <div class="row">
                    <div class="col-lg-10 offset-lg-1">
                        <h3 class="mb-3">Sign Up Now</h3>
                        <div class="bg-white shadow rounded">
                            <div class="row">
                                <div class="col-md-7 pe-0">
                                    <div class="form-left h-100 py-5 px-5">
                                        <form action="sign-up-form-2.php" method="post" class="row g-4">
                                            <div class="col-12">
                                                <label>Full Name<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                                    <input type="text" class="form-control"
                                                           placeholder="Enter Full Name" name="name" value="<?php echo $name; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label>Student ID<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-person-badge-fill"></i>
                                                    </div>
                                                    <input type="text" class="form-control" 
                                                           pattern="\d{2}[A-Z]{3}\d{5}" placeholder="Enter ID" name="studentid" value="<?php echo $stud_id; ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <label>Email<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-envelope-fill"></i></div>
                                                    <input type="email" class="form-control" 
                                                           placeholder="Enter email" name="email" value="<?php echo $email; ?>">
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label>Gender<span class="text-danger">*</span></label>
<!--                                                <div class="input-group">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="gender"
                                                               id="exampleRadios1" value="M">
                                                        <label class="form-check-label" for="exampleRadios1">
                                                            Male
                                                        </label>
                                                    </div>
                                                    &nbsp;
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="gender"
                                                               id="exampleRadios2" value="F">
                                                        <label class="form-check-label" for="exampleRadios2">
                                                            Female
                                                        </label>
                                                    </div>

                                                </div>-->
                                                <div>
                                                    <?php
                                                    $allGender = getAllGender();
                                                    foreach ($allGender as $key => $value) {
                                                        printf("<input class='form-check-input' type='radio'
                                                                               name='gender'
                                                                               value='%s' %s />%s", $key,
                                                                ($gender == $key) ? 'checked' : "",
                                                                $value);
                                                    }
                                                    ?>
                                                </div>
                                            </div>

                                            <div class="col-12">
                                                <label>Phone Number<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-envelope-fill"></i></div>
                                                    <input type="text" class="form-control" 
                                                           placeholder="Exp 0121234567" name="contact" value="<?php echo $contact; ?>">
                                                </div> 
                                            </div>

                                            <div class="col-12">
                                                <label>Password<span class="text-danger">*</span></label>
                                                <div class="input-group">
                                                    <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                                    <input type="password" class="form-control" 
                                                           placeholder="10 character include upper character and number" name="password" value="<?php echo $password; ?>">
                                                </div>
                                            </div>

                                            <div class="col-sm-6">
                                                <a href="login-form-2.php" class="float-end text-primary">Already have
                                                    account?
                                                    Login Now</a>
                                            </div>
                                            <div class="col-12">
                                                <input type="submit" name="singup"
                                                       class="btn btn-primary px-4 float-end mt-4" value="Sign Up">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="col-md-5 ps-0 d-none d-md-block">
                                    <div class="form-right h-100 text-white text-center pt-5">
                                        <img class="logo mt-5" src="image/WeChat Image_20230331170145.png" alt="TARUC-LOGO"
                                             style="height:350px;width:350px" />
                                    </div>
                                </div>
                            </div>
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
            (function ($) {
                $(window).scroll(function () {
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
        </script>
    </body>

</html>