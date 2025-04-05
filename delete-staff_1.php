<?php
session_start(); // start the session

// check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // if not, redirect them to the login page
  header('Location: login-form-2.php');
  exit();
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
        <title>Delete Staff</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Css/event-admin.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>
        <?php
        include 'AdminNav.php';
        require_once './config/helper.php';
        ?>
        
        <h1>Delete Staff</h1>
        
        <?php
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            //get method, retreive record to display
            (isset($_GET["id"]))?
            $staffID= strtoupper(trim($_GET["id"])):
            $staffID="";
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            $sql = "SELECT *FROM staff WHERE staffID = '$staffID'";
            $result = $con->query($sql);
            if($record = $result->fetch_object()){
                //record found
                $staffID = $record->staffID;
                $staffName = $record->staffName;
                $staffEmail = $record->staffEmail;
                $staffPH = $record->staffPH;
                $staffGender = $record->staffGender;
                printf("<p class= 'fontCenter'>Are you sure you want to delete the following staff?</p>
                    <table class='staffList'>
                     <tr>
                     <td class='tableDesign'>Student ID: </td>
                     <td>%s</td>
                     </tr>
                     <tr>
                     <td class='tableDesign'>Name: </td>
                     <td>%s</td>
                     </tr>
                     <tr>
                     <td class='tableDesign'>Gender: </td>
                     <td>%s</td>
                     </tr>
                     </table>
                    
                    <form action='' method='POST'>
                    <input type='hidden' name='txtStaffID' value='%s'>
                    <input type='hidden' name='txtStaffName' value='%s'>
                    <input type='hidden' name='rbGender' value='%s'>
                    <input type='submit' value='Delete' name='btnDelete' class='dltstaffpBtn'/>
                    <input type='button' value='Cancel' name='btnCancel' class='dltstaffpBtnn' onclick ='location=\"AdminList.php\"' />
                    </form>
                ",$staffID,$staffName,$staffGender,$staffID,$staffName,$staffGender);
            }else{
                //record not found
                echo '<div class= "fontCenter">Unable to find the record <a href="AdminList.php">Back to staff list</a></div>';
            }
        }else{
            //post method, delete record
            $staffID = strtoupper(trim($_POST["txtStaffID"]));
            $staffName = trim($_POST["txtStaffName"]);
            $staffGender = trim($_POST["rbGender"]);
            
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            
            $sql = "DELETE FROM staff WHERE staffID = ?";
            
            $stmt = $con->prepare($sql);
            
            $stmt ->bind_param('s', $staffID);
            
            if($stmt->execute()){
                //deleted
                printf("<div class= 'fontCenter'>%s has been deleted. <a href ='AdminList.php'>Back to staff list</a></div>",$staffID);
            }else{
                //unable to delete
                echo '<div class= "fontCenter">Unable to delete. <a href ="AdminList.php">Back to staff list</a></div>';
            }
            $con->close();
            $stmt->close();
        }
        ?>
    </body>
</html>
