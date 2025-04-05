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
        <title>Admin | Edit | Volunteer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Css/event-admin.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link href="Css/edit-volunteer.css" rel="stylesheet" type="text/css"/>

    </head>

    <body>
        <?php
        include 'AdminNav.php';
        require_once './config/yunqing.php';
        ?>
        <h1>Edit Volunteer</h1>
        <?php
        global $hideForm, $studName, $studCourse, $studID, $studGen, $studEmail, $studPNumber;
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            //get method
            //retrieve record and display data in the form
            //retrieve event name from URL
            (isset($_GET["id"])) ?
                            $studID = strtoupper(trim($_GET["id"])) :
                            $studID = "";
            
            //step 1 : connection
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            //step 2 : sql statement
            $sql = "SELECT * FROM student WHERE StudentID = '$studID'";
            //step 3 : run sql
            $result = $con->query($sql);

            if ($record = $result->fetch_object()) {
                //record found
                $studName = $record->Name;
                $studCourse = $record->Course;
                $studID = $record->StudentID;
                $studGen = $record->Gender;
                $studEmail = $record->Email;
                $studPNumber = $record->PhoneNumber;
                $joinEvent = $record->Event;
                
            } else {
                //record not found
                echo"<p class= 'fontCenter'>Unable to retrieve record.
            <a href='admin-volunteer.php'>Back to volunteer list</a></p>";
                $hideForm = true;
            }
            $result->free();
            $con->close();
        } else {
            //post method      
            $studID = strtoupper(trim($_POST["txtStudID"]));
            $studName = trim($_POST["txtStudName"]);
            $studCourse = trim($_POST["selectCou"]);
            $studEmail = trim($_POST["txtStudEmail"]);
            $studPNumber = trim($_POST["txtStudPH"]);
            $studGen = trim($_POST["rbGender"]);
            $joinEvent = trim($_POST["selectEve"]);

            $error = array();

            $error['name'] = checkStudentName($studName);
            $error['course'] = checkCourse($studCourse);
            $error['gender'] = checkStudentGender($studGen);
            $error['email'] = checkStudentEmail($studEmail);
            $error['pnumber'] = checkStudentPNumber($studPNumber);
            $error = array_filter($error);
            if (empty($error)) {
                //no error
                //step 1 : connect
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                //step 2 :
                $sql = "UPDATE student SET Name = ?, Course = ?, Email = ?,PhoneNumber = ?,Gender = ? WHERE StudentID = ?";
                $statement = $con->prepare($sql);
                $statement->bind_param("ssssss", $studName, $studCourse, $studEmail, $studPNumber, $studGen, $studID);
                if ($statement->execute()) {
                    //update
                    printf("<p class= 'fontCenter'>Successfully edit volunteer information.<a href='admin-volunteer.php'>Back to volunteer list</a></p>", $studName);
                } else {
                    //fail to update
                    echo"<p class= 'fontCenter'>Unable to edit.<a href='admin-volunteer.php'>Back to volunteer list</a></p>";
                }
            } else {
                //got error
                echo"<ul>";
                foreach ($error as $value) {
                    echo"<li>$value</li>";
                }
                echo"</ul>";
                //update record
            }
        }
        ?>

        <?php if ($hideForm == false) : ?>

            <form action="" method="POST">
                
                    <table class="table">

                        <tr>
                            <td class='tableDesign'>Student id : </td>
                            <td><?php echo $studID; ?>
                                <input type="hidden" 
                                       name="txtStudID"
                                       value="<?php echo $studID ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td class='tableDesign'>Name : </td>
                            <td><input type="text" 
                                       name="txtStudName"
                                       value="<?php echo $studName ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td class="tableDesign">Course: </td>
                            <td>
                                <select name="selectCou">
                                    <?php
                                    $course = getAllCourse();
                                    foreach ($course as $cour => $courValue) {
                                        printf("
                                        <option value='%s'%s>%s</option>"
                                                , $cour
                                                , (isset($studCourse) && $studCourse == $cour) ? 'selected' : ""
                                                , $courValue);
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class='tableDesign'>Email: </td>
                            <td><input type="email" 
                                       name="txtStudEmail" 
                                       value="<?php echo $studEmail ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td class='tableDesign'>Phone Number : </td>
                            <td><input type="text" 
                                       name="txtStudPH" 
                                       value="<?php echo $studPNumber ?>" /></td>
                        </tr>

                        <tr>
                            <td class='tableDesign'>Gender: </td>
                            <td>
                                <?php
                                $allGender = getAllGender();
                                foreach ($allGender as $key => $value) {
                                    printf("<input type='radio'
                                name='rbGender'
                                value='%s' %s />%s", $key,
                                            ($studGen == $key) ? 'checked' : "",
                                            $value);
                                }
                                ?>
                            </td>
                        </tr>
                        
                        <tr>
                            <td class="tableDesign">Event: </td>
                            <td>
                                <select name="selectEve">
                                    <?php
                                    $event = getAllEvent();
                                    foreach ($event as $eve => $eveValue) {
                                            printf("
                                                <option value='%s'%s>%s</option>"
                                                    , $eve
                                                    , (isset($joinEvent) && $joinEvent == $eve) ? 'selected' : ""
                                                    , $eveValue);
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>

                    </table>
                    <input type="submit" 
                           value="Update" 
                           name="btnUpdate"
                           class="edtStudBtn"/>
                    <input type="button" 
                           value="Cancel" 
                           name="btnCancel" 
                           onclick="location = 'admin-volunteer.php'"
                           class="edtStudBtnn"/>
            </form>
        <?php endif; ?>
    </body>
</html>