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
<html lang="en" dir="" ltr>

    <head>
        <meta charset="UTF-8">
        <title>Add Event</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Css/event-admin.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    </head>

    <body>
         <h1>Add Staff</h1>
        <?php
        include 'AdminNav.php';
        include './config/helper.php';
        ?>
        <?php
        
        global $staffID;
        global $staffName;
        global $staffEmail;
        global $staffPH;
        global $staffGender;
        global $staffPass;
        if (!empty($_POST)) {
            //user click add button,retrieve user input
            (isset($_POST["txtStaffID"])) ?
                            $staffID = trim($_POST["txtStaffID"]) :
                            $staffID = "";
            (isset($_POST["txtStaffName"])) ?
                            $staffName = trim($_POST["txtStaffName"]) :
                            $staffName = "";
            (isset($_POST["txtStaffEmail"])) ?
                            $staffEmail = trim($_POST["txtStaffEmail"]) :
                            $staffEmail = "";
            (isset($_POST["txtStaffPH"])) ?
                            $staffPH = trim($_POST["txtStaffPH"]) :
                            $staffPH = "";
            (isset($_POST["rbGender"])) ?
                            $staffGender = trim($_POST["rbGender"]) :
                            $staffGender = "";
            (isset($_POST["txtStaffPass"])) ?
                            $staffPass = trim($_POST["txtStaffPass"]) :
                            $staffPass = "";
            //check error
            $error["staffName"] = checkStaffName($staffName);
            $error["staffEmail"] = checkEmail($staffEmail);
            $error["staffPH"] = checkPH($staffPH);
            $error["staffGender"] = checkGender($staffGender);
            $error["txtStaffPass"] = checkPass($staffPass);
            $error = array_filter($error);

            if (empty($error)) {
                //no error, add event
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
                $sql1 = "SELECT MAX(staffID) FROM staff";
               $result = $con->query($sql1);
               $idrow = $result->fetch_row();
               $max_id = $idrow[0];
               $new_id = $max_id + 1;
                
                $sql = "INSERT INTO staff (staffID,staffName,staffEmail,staffPH,staffGender,staffPass) VALUES(?,?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssssss", $new_id, $staffName, $staffEmail, $staffPH, $staffGender,$staffPass);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    //INSERT Successful
                    printf("<p class= 'fontCenter'>
                               %s has been added.
                               <a href='AdminList.php'>
                               Back to staff list</a></p>", $staffID);
                } else {
                    echo'<p class= "fontCenter">Unable to insert!
                   [<a href="AdminList.php">
                               Back to staff list</a></p>]';
                }
            } else {
                //with error
                echo"<p class= 'fontCenter'>";
                foreach ($error as $value) {
                    echo"<p class= 'fontCenter'>$value</p>";
                }
                echo"<p class= 'fontCenter'>";
            }
        }
        ?>
        
        <form action = "" method = "POST">
            <table>

                <tr>
                    <td class='tableDesign'>Name: </td>
                    <td><input type="text" 
                               name="txtStaffName" 
                               value="<?php echo $staffName?>" /></td>
                </tr>

                <tr>
                    <td class='tableDesign'>Email: </td>
                    <td><input type="email" 
                               name="txtStaffEmail" 
                               value="<?php echo $staffEmail?>" /></td>
                </tr>

                <tr>
                    <td class='tableDesign'>Phone Number : </td>
                    <td><input type="text" 
                               name="txtStaffPH" 
                               value="<?php echo $staffPH?>" /></td>
                </tr>
                
                <tr>
                    <td class='tableDesign'>Gender: </td>
                    <td>
                        <?php
                                $allGender= getAllGender();
                                foreach($allGender as $key => $value){
                                    printf("<input type='radio'
                               name='rbGender'
                               value='%s' %s />%s",$key,
                                            ($staffGender==$key)?'checked':"",
                                            $value);
                                }
                        ?>
                    </td>
                </tr>
                
                <tr>
                    <td class='tableDesign'>Password : </td>
                    <td><input type="text" 
                               name="txtStaffPass" 
                               value="<?php echo $staffPass?>" /></td>
                </tr>
                
            </table>
            <div>
            <input type = "submit"value = "Insert"name = "btnInsert" class="addstaffBtn"/>
            <input type = "button"value = "Cancel"name = "btnCancel"onclick = "location = 'AdminList.php'"class="addstaffBtnn"/>
            </div>
        </form>


    </body>

</html>