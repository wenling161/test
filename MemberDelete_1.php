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
        <title>Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Css/admin.css" rel="stylesheet" type="text/css" />
        <link href="Css/memberlist.css" rel="stylesheet" type="text/css"/>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>
        <?php include 'AdminNav.php'; ?>
        <?php
        require_once './ass_helper.php';
        ?>
        <h1>Delete Member</h1>
        <div class="table">
            <table>
                <tr>
                    <th>Student Name</th>
                    <th>Student ID</th>
                    <th>Student Email</th>
                    <th>Gender</th>
                    <th>Phone Number</th>
                </tr>
                <?php
                require_once './ass_helper.php';

                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $sql = "SELECT * FROM member";

                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    //get method, retrieve record to display
                    (isset($_GET["id"])) ?
                                    $id = strtoupper(trim($_GET["id"])) :
                                    $id = "";
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $sql = "SELECT * FROM member WHERE studentid = '$id'";
                    $result = $con->query($sql);
                    if ($record = $result->fetch_object()) {
                        //record found
                        $name = $record->fullname;
                        $id = $record->studentid;
                        $email = $record->email;
                        $gender = $record->gender;
                        $contact = $record->phonenumber;
                        printf("<p>Are you sure you want to delete the following member?</p>
                     <tbody>
                     <tr>
                     <td>%s</td>
                     <td>%s</td>
                     <td>%s</td>
                     <td>%s</td>
                     <td>%s</td>
                     </tbody>
                     <form action='' method='POST'>
                     <input type='hidden' name='hdID' value='%s' />
                     <input type='hidden' name='hdName' value='%s' />
                     <input type='submit' value='Delete' name='btnDelete' />
                     <input type='button' value='Cancel' name='btnCancel' onclick ='location=\"MemberList.php\"' />
                    </form>
                    ", $name, $id, $email, getAllGender()[$gender], $contact, $id, $name);
                    } else {
                        //record not found
                        echo '<div class="error">Unable to insert
                        (<a href="MemberList.php">Back to list</a>)</div>';
                    }
                } else {
                    //post memthod, delete record
                    $id = strtoupper(trim($_POST["hdID"]));
                    $name = trim($_POST["hdName"]);

                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    $sql = "DELETE FROM member WHERE studentid = ?";

                    $stmt = $con->prepare($sql);

                    $stmt->bind_param('s', $id);

                    if ($stmt->execute()) {
                        //deleted
                        printf("<div class='info'>Member %s has been deleted.
                        <a href='MemberList.php'>Back to list</a>
                            </div>", $name);
                    } else {
                        //unble to delete
                        echo '<div class="error">Unable to delete!
                        (<a href="MemberList.php">Back to list</a>)</div>';
                    }
                    $con->close();
                    $stmt->close();
                }
                ?>
            </table>
        </div>
    </body>
</html>
