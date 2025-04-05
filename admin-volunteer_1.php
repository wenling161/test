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
        <title>Admin | Volunteer</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Css/event-admin.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>        
        <?php
        include 'AdminNav.php';
        //retrieve 4 parameters from yunqing.php
        require_once './config/yunqing.php';

        $header = array(
            'StudentName' => 'Student Name',
            'Course' => 'Course',
            'StudentID' => 'Student ID',
            'Gender' => 'Gender',
            'StudentEmail' => 'Student Email',
            'PhoneNumber' => 'Phone Number',
            'Event' => 'Event'
        );
        ?>
        <div class="list-student">
            <h1>Volunteer List</h1>

            <?php
            // Check if the delete button is clicked
            if (isset($_POST['delete'])) {
                $delete = $_POST['del'];
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                // Prepare the SQL statement
                $sql = "DELETE FROM student WHERE StudentID=?";
                $stmt = $con->prepare($sql);

                // Bind the parameter
                $stmt->bind_param("s", $delete);

                // Execute the statement
                $stmt->execute();

                // Close the statement
                $stmt->close();
                $con->close();
            }

            // Connect to the database
            $con = new mysqli("localhost", "root", "", "liyi");

            // Perform the query
            $sql = "SELECT * FROM student";
            $result = $con->query($sql);

            // Loop through the result set and display the data in a table
            echo '<div class="table1">
                  <table class="table">';
            echo '<tr>
                    <th>Student Name</th>
                    <th>Course</th>
                    <th>Student ID</th>
                    <th>Gender</th>
                    <th>Student Email</th>
                    <th>Phone Number</th>
                    <th>Event</th>
                    <th>Delete</th>
                    <th>Edit</th>
                  </tr>';
            while ($record = $result->fetch_object()) {
                $id = $record->StudentID;
                $studName = $record->Name;
                $studCourse = $record->Course;
                $studGen = $record->Gender;
                $studEmail = $record->Email;
                $studPNumber = $record->PhoneNumber;
                $joinEvent = $record->Event;

                printf("<tr>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>%s</td>
                            <td>
                                <form method='POST'>
                                    <input type='hidden' name='del' value='$id'>
                                    <input type='submit' class='btnDelete' name='delete' value='Delete'/>
                                </form>
                            </td>
                       
                            <td>
                            <form method='POST'>
                            <a href='edit-volunteer.php?id=%s'>Edit</a>
                            </form>
                            </td>
                        </tr>
                        ", $studName, $studCourse, $id, $studGen, $studEmail, $studPNumber, $joinEvent, $id, $id);
            }

            echo '</table></div>';
            // Check if the update button is clicked
            if (isset($_POST['edit'])) {
                // Retrieve the updated student data from the form
                $studentName = $_POST['studentName'];
                $course = $_POST['course'];
                $studentID = $_POST['studentID'];
                $gender = $_POST['gender'];
                $studentEmail = $_POST['studentEmail'];
                $phoneNumber = $_POST['phoneNumber'];
                $joinEvent = $_POST['joinEvent'];

                // Connect to the database
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                // Prepare the SQL statement
                $sql = "UPDATE student SET Name=?, Course=?, Gender=?, Email=?, PhoneNumber=?, Event=? WHERE StudentID=?";
                $stmt = $con->prepare($sql);

                // Bind the parameters
                $stmt->bind_param("sssssss", $studentName, $course, $gender, $studentEmail, $phoneNumber, $studentID, $joinEvent);

                // Execute the statement
                $stmt->execute();

                // Close the connection and statement
                $stmt->close();
                $con->close();
            }

            // Close the connection
            $con->close();
            ?>

        </div> <!-- close the div for list-student -->

        <script>
            let btn = document.querySelector("#btn");
            let sidebar = document.querySelector(".sidebar");
            let searchBtn = document.querySelector(".bx-search");

            btn.onclick = function () {
                sidebar.classList.toggle("active");
            }
            searchBtn.onclick = function () {
                sidebar.classList.toggle("active");
            }

        </script>
    </body>

</html>