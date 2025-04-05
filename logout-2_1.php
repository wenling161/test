<?php
session_start(); // start the session
$role = $_GET['role'];

if($role == "staff"){
    // unset the 'loggedin' and 'adminid' session variables
    unset($_SESSION['loggedin']);
    unset($_SESSION['adminid']);
    unset($_SESSION['adminPassword']);
    unset($_SESSION['adminUsername']);
}else{
    // unset the 'loggedin' and 'adminid' session variables
    unset($_SESSION['studentId']);
    unset($_SESSION['userLogin']);
}


// destroy the session if no other session variables are set
if (count($_SESSION) == 0) {
    session_destroy();
}

// Redirect to login page or homepage
header("Location: homepage-2.php");
exit();

?>