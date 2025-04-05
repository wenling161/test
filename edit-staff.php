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
        <title>Admin Adit Event</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Css/event-admin.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    </head>

    <body>
        <?php include 'AdminNav.php';
        require_once './config/helper.php';
        ?>
        <h1>Edit Staff</h1>
        <?php
        global $hideForm;
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            //get method
            //retrieve record and display data in the form
            //retrieve event name from URL
            (isset($_GET["id"])) ?
                            $staffID = strtoupper(trim($_GET["id"])) :
                            $staffID = "";
            //step 1 : connection
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            //step 2 : sql statement
            $sql = "SELECT * FROM staff WHERE staffID = '$staffID'";
            //step 3 : run sql
            $result = $con->query($sql);

            if ($record = $result->fetch_object()) {
                //record found
                $staffID = $record->staffID;
                $staffName = $record->staffName;
                $staffEmail = $record->staffEmail;
                $staffPH = $record->staffPH;
                $staffGender = $record->staffGender;
            } else {
                //record not found
                echo"<p class= 'fontCenter'>Unable to retrieve record.
            <a href='AdminList.php'>Back to staff list</a></p>";
                $hideForm = true;
            }
            $result->free();
            $con->close();
        } else {
            //post method
            $staffID = strtoupper(trim($_POST["txtStaffID"]));
            $staffName = trim($_POST["txtStaffName"]);
            $staffEmail = trim($_POST["txtStaffEmail"]);
            $staffPH = trim($_POST["txtStaffPH"]);
            $staffGender = trim($_POST["rbGender"]);

           
            $error["staffName"] = checkStaffName($staffName);
            $error["staffEmail"] = checkEmail($staffEmail);
            $error["staffPH"] = checkPH($staffPH);
            $error["staffGender"] = checkGender($staffGender);
            $error = array_filter($error);
            if (empty($error)) {
                //no error
                //step 1 : connect
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                //step 2 :
                $sql = "UPDATE staff SET staffName = ?,staffEmail = ?,staffPH = ?,staffGender = ? WHERE staffID = ?";
                $statement = $con->prepare($sql);
                $statement->bind_param("sssss", $staffName, $staffEmail, $staffPH, $staffGender,$staffID);
                if ($statement->execute()) {
                    //update
                    printf("<p class= 'fontCenter'>Successfully edit staff information.<a href='AdminList.php'>Back to staff list</a></p>", $staffName);
                } else {
                    //fail to update
                    echo"<p class= 'fontCenter'>Unable to edit.<a href='AdminList.php'>Back to staff list</a></p>";
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
                <div class="table"> 
                    <table>

                        <tr>
                            <td class='tableDesign'>Staff id : </td>
                            <td><?php echo $staffID; ?>
                                <input type="hidden" 
                                       name="txtStaffID"
                                       value="<?php echo $staffID ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td class='tableDesign'>Name : </td>
                            <td><input type="text" 
                                       name="txtStaffName"
                                       value="<?php echo $staffName ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td class='tableDesign'>Email: </td>
                            <td><input type="email" 
                                       name="txtStaffEmail" 
                                       value="<?php echo $staffEmail ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td class='tableDesign'>Phone Number : </td>
                            <td><input type="text" 
                                       name="txtStaffPH" 
                                       value="<?php echo $staffPH ?>" /></td>
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
                        
                    </table>
                    <input type="submit" 
                           value="Update" 
                           name="btnUpdate"
                           class="edtStaffBtn"/>
                    <input type="button" 
                           value="Cancel" 
                           name="btnCancel" 
                           onclick="location = 'AdminList.php'"
                           class="edtStaffBtnn"/>
            </form>
<?php endif; ?>
    </body>
</html>