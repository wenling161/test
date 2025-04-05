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
        <title>Staff List</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Css/event-admin.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    </head>

    <body>
         <h1>Staff List</h1>
        <?php
        include 'AdminNav.php';
        ?> 
        <form action="" method="post">    
            <?php
            require_once './config/helper.php';

            if (isset($_POST['delete'])) {
                $checked = $_POST['checked'];

                if (!empty($checked)) {
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    foreach ($checked as $value) {
                        $escaped[] = $con->real_escape_string($value);
                    }

                    $sql = "DELETE FROM staff WHERE staffID IN ('" .
                            implode("','", $escaped) . "')";

                    if ($con->query($sql)) {
                        printf('
                    <p class= "fontCenter">
                    <strong>%d</strong> record(s) has been deleted.
                    </p>
                    ', $con->affected_rows);
                    }

                    $con->close();
                }
            }
            ?>
        </div>
        <table class="staffList">
            <thead>
                <tr>
                    <th></th>
                    <th>Staff ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone number</th>
                    <th>Gender</th>
                    <th>Edit/Delete</th>
                </tr>
            </thead>
<?php
require_once './config/helper.php';

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT * FROM staff";

if ($result = $con->query($sql)) {
    while ($row = $result->fetch_object()) {
        printf('
                                <tbody>
                                <tr>
                                    <td>
                                    <input type="checkbox" name="checked[]" value="%s">
                                    </td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>%s</td>
                                    <td>
                                    <a href="edit-staff.php?id=%s">Edit</a> |
                                    <a href="delete-staff.php?id=%s">Delete</a>
                                    </td>
                                </tr>
                            </tbody>',
                $row->staffID,
                $row->staffID,
                $row->staffName,
                $row->staffEmail,
                $row->staffPH,
                $row->staffGender,
                $row->staffID,
                $row->staffID
        );
    }
}
$result->free();
$con->close();
?>
        </table>
        <input type="submit" name="delete" value="Delete Checked" class="dltstaffBtn"
                onclick="return confirm('This will delete all checked records.\nAre you sure?')">
        <button type="button" class="dltstaffBtnn" onclick="location.href='add-staff.php' ">Add Staff</button>
    </form>
</body>

</html>