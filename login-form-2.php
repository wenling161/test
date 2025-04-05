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
    .bg-white {
        background: linear-gradient(to top, #28333E, #FBF2E3);
    }
    .login-page{
        background: linear-gradient(to bottom, #515855, #EEF7F2);
    }
    </style>

</head>

<body>
<?php include 'header-2.php' ?>
    <?php
        session_start(); // start the <session></session>
        $conn = mysqli_connect('localhost', 'root', '', 'liyi');

        if (isset($_POST['login'])) {

            function validate($data){

                $data = trim($data);
        
                $data = stripslashes($data);
        
                $data = htmlspecialchars($data);
        
                return $data;
        
            }

            $uname = validate($_POST['id']);
            $pass = validate($_POST['password']);
            $role = $_POST['loginAs'];

            if($role == "staff"){
                $sql = "SELECT * FROM staff WHERE staffID='$uname' and staffPass='$pass'";
            }else{
                $sql = "SELECT * FROM member WHERE studentid='$uname' and password='$pass'";
            }
            $ret=mysqli_query($conn,$sql);
            $num=mysqli_fetch_array($ret);

            if($num>0)
            {   if($role == "staff"){
                    $extra="admin-report.php";
                    $_SESSION['adminPassword'] = $_POST['password'];
                    $_SESSION['adminid']=$num['staffID'];
                    $_SESSION['start'] = time();
                    $_SESSION['loggedin'] = true;
                    $_SESSION['expire'] = $_SESSION['start'] + (30*60);
                    echo '<script>alert("Welcome Back"); window.location.href="'.$extra.'"; </script>';
                    exit();

                }else{
                    $extra="homepage-2.php";
                    $_SESSION['studentId']=$num['studentid'];
                    $_SESSION['start'] = time();
                    $_SESSION['userLogin'] = true;
                    $_SESSION['expire'] = $_SESSION['start'] + (30*60);
                    echo '<script>alert("Welcome Back"); window.location.href="'.$extra.'"; </script>';
                }

            }
            else {
                echo '<script>alert("Invalid user credentials"); window.location.href="login-form-2.php"; </script>';
                exit();
            }

        }
    ?>

    <div class="login-page bg-light">
        <div class="containe mt-5">
            <div class="row">
                <div class="col-lg-10 offset-lg-1">
                    <h3 class="mb-3">Login Now</h3>
                    <div class="bg-white shadow rounded">
                        <div class="row">
                            <div class="col-md-7 pe-0">
                                <div class="form-left h-100 py-5 px-5">
                                    <form action="login-form-2.php" method="post" class="row g-4">
                                        <div class="col-12">
                                            <label>ID<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="bi bi-person-fill"></i></div>
                                                <input type="text" class="form-control" required name="id"
                                                    placeholder="Enter ID">
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <label>Password<span class="text-danger">*</span></label>
                                            <div class="input-group">
                                                <div class="input-group-text"><i class="bi bi-lock-fill"></i></div>
                                                <input type="password" class="form-control" required name="password"
                                                    placeholder="Enter Password">
                                            </div>
                                        </div>

                                        <div class="col-sm-6">
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="loginAs"
                                                    id="inlineFormCheck" value="staff" required>
                                                <label class="form-check-label" for="inlineFormCheck">Staff</label>
                                            </div>
                                            <div class="form-check">
                                                <input class="form-check-input" type="radio" name="loginAs"
                                                    id="inlineFormCheck" value="member">
                                                <label class="form-check-label" for="inlineFormCheck">Member</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <a href="sign-up-form-2.php" class="float-end text-primary">Don't have an account? Sign
                                                up</a>
                                        </div>
                                        <div class="col-12">
                                            <input type="submit" name="login"
                                                class="btn btn-primary px-4 float-end mt-4" value="Login">
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="col-md-5 ps-0 d-none d-md-block">
                                <div class="form-right h-100 text-white text-center pt-5">
                                    <img class="logo" src="image/WeChat Image_20230331170145.png" alt="TARUC-LOGO"
                                        style="height:350px;width:350px" />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>