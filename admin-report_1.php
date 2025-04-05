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
        <?php include 'AdminNav.php'; ?>
        <meta charset="UTF-8">
        <title>Admin Home Page</title>
        <link href="Css/admin-report.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="title">
            <h1>Sports Society Report Overview 💭</h1>
        </div>

        <div class="boxes">
            <div class="row">
                <div class="column">
                    <div class="card1">
                        <?php
                        //connect to sql
                        $con = new mysqli("localhost", "root", "", "liyi");

                        //perform query
                        $sql = "SELECT SUM(Quantity) AS TotalQuantity FROM `order` WHERE Event = 'Basketball'";
                        $result = $con->query($sql);

                        echo '<h1>️🏀</h1>';
                        echo '<h3>Total of Basketball Event Order: ' . $result->fetch_assoc()['TotalQuantity'] . '</h3>';
                        ?>                                                                     
                    </div>
                </div>

                <div class="column">
                    <div class="card2">
                        <?php
                        //connect to sql
                        $con = new mysqli("localhost", "root", "", "liyi");

                        //perform query
                        $sql = "SELECT SUM(Quantity) AS TotalQuantity FROM `order` WHERE Event = 'Bowling'";
                        $result = $con->query($sql);

                        echo '<h1>️🎳</h1>';
                        echo '<h3>Total of Bowling Event Order: ' . $result->fetch_assoc()['TotalQuantity'] . '</h3>';
                        ?>                                                                     
                    </div>
                </div>

                <div class="column">
                    <div class="card3">
                        <?php
                        //connect to sql
                        $con = new mysqli("localhost", "root", "", "liyi");

                        //perform query
                        $sql = "SELECT SUM(Quantity) AS TotalQuantity FROM `order` WHERE Event = 'Gym'";
                        $result = $con->query($sql);

                        echo '<h1>️🏋️</h1>';
                        echo '<h3>Total of Gym Event Order: ' . $result->fetch_assoc()['TotalQuantity'] . '</h3>';
                        ?>                                                                     
                    </div>
                </div>

            </div>
            <div class="column">
                <div class="card4">
                    <?php
                    //connect to sql
                    $con = new mysqli("localhost", "root", "", "liyi");

                    //perform query
                    $sql = "SELECT SUM(Quantity) AS TotalQuantity FROM `order` WHERE Event = 'Running'";
                    $result = $con->query($sql);

                    echo '<h1>️‍‍👟️</h1>';
                    echo '<h3>Total of Running Event Order: ' . $result->fetch_assoc()['TotalQuantity'] . '</h3>';
                    ?>                                                                     
                </div>
            </div>

        </div>
    </div>

</body>
</html>
