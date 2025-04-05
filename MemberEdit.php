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
        require_once './ass_helper.php';
        ?>
        <h1>Edit Member</h1>
        <?php
        global $hideForm;
        if ($_SERVER["REQUEST_METHOD"] == "GET") {
            //get method
            //retrieve record and display data in the form
            //retrieve event name from URL
            (isset($_GET["id"])) ?
                            $id = strtoupper(trim($_GET["id"])) :
                            $id = "";
            //step 1 : connection
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            //step 2 : sql statement
            $sql = "SELECT * FROM member WHERE studentid = '$id'";
            //step 3 : run sql
            $result = $con->query($sql);

            if ($record = $result->fetch_object()) {
                //record found
                $id = $record->studentid;
                $name = $record->fullname;
                $gender = $record->gender;
                $email = $record->email;
                $contact = $record->phonenumber;
            } else {
                //record not found
                echo"<p class= 'fontCenter'>Unable to retrieve record.
            <a href='MemberList.php'>Back to Member list</a></p>";
                $hideForm = true;
            }
            $result->free();
            $con->close();
        } else {
            //post method
            $id = trim($_POST["studentid"]);
            $name = trim($_POST["name"]);
            $gender = trim($_POST["gender"]);
            $contact = trim($_POST["phonenumber"]);
            $email = trim($_POST["email"]);
            //check if there are any message in $error[]
            $error["name"] = validateStudentName($name);
            $error["gender"] = validateGender($gender);
            $error["phonenumber"] = validateEditPhoneNumber($contact);
            $error = array_filter($error);
            if (empty($error)) {
                //no error
                //step 1 : connect
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                //step 2 :
                $sql = "UPDATE member SET fullname = ?,gender = ?,phonenumber = ?,email = ? WHERE studentid = ?";
                $statement = $con->prepare($sql);
                $statement->bind_param("sssss", $name, $gender, $contact, $email, $id);
                if ($statement->execute()) {
                    //update
                    printf("<p class= 'fontCenter'>Successfully edit member information.<a href='MemberList.php'>Back to member list</a></p>", $name);
                } else {
                    //fail to update
                    echo"<p class= 'fontCenter'>Unable to edit.<a href='MemberList.php'>Back to member list</a></p>";
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
                            <td class='tableDesign'>Student ID : </td>
                            <td><?php echo $id; ?>
                                <input type="hidden" 
                                       name="studentid"
                                       value="<?php echo $id ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td class='tableDesign'>Name : </td>
                            <td><input type="text" 
                                       name="name"
                                       value="<?php echo $name ?>"/>
                            </td>
                        </tr>

                        <tr>
                            <td class='tableDesign'>Email: </td>
                            <td><input type="email" 
                                       name="email" 
                                       value="<?php echo $email ?>" />
                            </td>
                        </tr>

                        <tr>
                            <td class='tableDesign'>Phone Number : </td>
                            <td><input type="text" 
                                       name="phonenumber" 
                                       value="<?php echo $contact ?>" /></td>
                        </tr>
                        
                        <tr>
                            <td class='tableDesign'>Gender: </td>
                            <td>
                                <?php
                                $allGender= getAllGender();
                                foreach($allGender as $key => $value){
                                    printf("<input type='radio'
                                name='gender'
                                value='%s' %s />%s",$key,
                                            ($gender==$key)?'checked':"",
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
                           onclick="location = 'MemberList.php'"
                           class="edtStaffBtnn"/>
            </form>
<?php endif; ?>
    </body>
</html>