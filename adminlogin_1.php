<?php
session_start(); // start the <session></session>
require_once('config/database.php');
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

if (isset($_POST['username']) && isset($_POST['password'])) {

    function validate($data){

        $data = trim($data);
 
        $data = stripslashes($data);
 
        $data = htmlspecialchars($data);
 
        return $data;
 
     }

     $uname = validate($_POST['username']);
     $pass = validate($_POST['password']);

     $ret=mysqli_query($conn,"SELECT * FROM staff WHERE staffID='$uname' and staffPass='$pass'");
     $num=mysqli_fetch_array($ret);

     if($num>0)
     {   
         $extra="admin-report.php";
         $_SESSION['adminUsername']=$_POST['username'];
         $_SESSION['adminPassword'] = $_POST['password'];
         $_SESSION['adminid']=$num['staffID'];
         $_SESSION['start'] = time();
         $_SESSION['loggedin'] = true;
         $_SESSION['expire'] = $_SESSION['start'] + (30*60);
         echo '<script>alert("Welcome Back"); window.location.href="'.$extra.'"; </script>';
         exit();
     }
     else {
        echo '<script>alert("Invalid user credentials"); window.location.href="adminlogin.php"; </script>';
         exit();
     }

}
?>

<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>

<head>
    <meta charset="UTF-8">
    <title>Staff Login Page</title>
    <link href="Css/adminlogin.css" rel="stylesheet" type="text/css" />
    <?php include 'Header.php'; ?>
</head>

<body>

    <form action="adminlogin.php" method="post">
        <h1>Please Log in to your Account</h1>
        <img src="image/adminlogin.png" alt="" />
        <br><br>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person"
                viewBox="0 0 16 16">
                <path
                    d="M8 8a3 3 0 1 0 0-6 3 3 0 0 0 0 6Zm2-3a2 2 0 1 1-4 0 2 2 0 0 1 4 0Zm4 8c0 1-1 1-1 1H3s-1 0-1-1 1-4 6-4 6 3 6 4Zm-1-.004c-.001-.246-.154-.986-.832-1.664C11.516 10.68 10.289 10 8 10c-2.29 0-3.516.68-4.168 1.332-.678.678-.83 1.418-.832 1.664h10Z" />
            </svg>
            <input type="text" name="username" id="username" placeholder="Username" required>
        </div>
        <br>
        <div>
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock"
                viewBox="0 0 16 16">
                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 
                      0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 
                      0-2-2zM5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 
                      1 0 0 1 1-1z" />
            </svg>

            <input type="password" name="password" id="password" placeholder="Password" required>
            <span class="showpass" onclick="showPass()">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye"
                    viewBox="0 0 16 16">
                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 
                          8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 
                          5.88 3.5 8 3.5c2.12 0 3.879 
                          1.168 5.168 2.457A13.133 3.133 0 0 1 14.828 
                          8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 
                          11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 
                          13.134 0 0 1 1.172 8z" />
                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 
                          3.5 3.5 0 0 1-7 0z" />
                </svg>
            </span>
            <script>
            function showPass() {
                var passwordField = document.getElementById("password");
                var passwordToggle = document.querySelector(".showpass svg");
                if (passwordField.type === "password") {
                    passwordField.type = "text";
                    passwordToggle.classList.remove("bi bi-eye");
                } else {
                    passwordField.type = "password";
                    passwordToggle.classList.add("bi bi-eye");
                }
            }
            </script>


        </div>
        <br>
        <div class="bottom">
            <div class="left">
                <input type="checkbox" name="rmbMe" id="rmbMe" />
                <label for="rmbMe">Remember Me</label>
            </div>
        </div>
        <br>
        <div>
            <input type="submit" value="Log in" name="btnLogin" id="btnLogin" />
        </div>
        <div>
            <input type="reset" value="Reset" name="btnReset" id="btnReset" />
        </div>
    </form>

</body>
<?php include 'Footer.php'; ?>

</html>