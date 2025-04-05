
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
        <title>Admin</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Css/admin.css" rel="stylesheet" type="text/css" />
        <link href="Css/memberlist.css" rel="stylesheet" type="text/css"/>
        <script src="https://kit.fontawesome.com/a076d05399.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    </head>

    <body>
        <?php 
        include 'AdminNav.php';
        ?>
        <form action="" method="post">
        <?php
        require_once './ass_helper.php';
        if (isset($_POST['delete'])) {
            $checked = $_POST['checked'];

            if (!empty($checked)) {
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                foreach ($checked as $value) {
                    $escaped[] = $con->real_escape_string($value);
                }

                $sql = "DELETE FROM payment WHERE paymentid IN ('" .
                        implode("','", $escaped) . "')";

                if ($con->query($sql)) {
                    printf('
                    <div class="info">
                    <strong>%d</strong> record(s) has been deleted.
                    </div>
                    ', $con->affected_rows);
                }

                $con->close();
            }
        }
        ?>
    <!--dashboard end-->
    <h1>Payment List</h1>
        <div class="table">
            <table>
                <tr>
                    <th>MultiDelete</th>
                    <th>Student ID</th>
                    <th>Payment ID</th>
                    <th>Event</th>
                    <th>Ticket Price</th>
                    <th>Ticket Quantity</th>
                    <th>Total Amount</th>
                    <th>Delete</th>
                </tr>
                <?php
                require_once './ass_helper.php';

$con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$sql = "SELECT * FROM payment";

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
                                    <td>%.2lf</td>
                                    <td>%d</td>
                                    <td>%.2lf</td>
                                    <td><a href="PaymentDelete.php?id=%s">Delete</a></td>
                                </tr>
                            </tbody>',
                $row->paymentid,
                $row->studentid,
                $row->paymentid,
                $row->event,
                $row->ticketprice,
                $row->ticketquantity,
                $row->totalamount,
                $row->paymentid
        );
    }
}
$result->free();
$con->close();
?>
            </table>
        </div>
    <input type="submit" name="delete" value="Delete Checked" class="designlo"
                onclick="return confirm('This will delete all checked records.\nAre you sure?')">
        </form>
    </body>

</html>