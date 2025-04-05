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
        <h1>Delete Payment</h1>
        <div class="table">
            <table>
                <tr>
                    <th>Student ID</th>
                    <th>Payment ID</th>
                    <th>Event</th>
                    <th>Ticket Price</th>
                    <th>Total Amount</th>                
                </tr>
                <?php
                require_once './ass_helper.php';

                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $sql = "SELECT * FROM payment";

                if ($_SERVER["REQUEST_METHOD"] == "GET") {
                    //get method, retrieve record to display
                    (isset($_GET["id"])) ?
                                    $pyid = strtoupper(trim($_GET["id"])) :
                                    $pyid = "";
                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    $sql = "SELECT * FROM payment WHERE paymentid = '$pyid'";
                    $result = $con->query($sql);
                    if ($record = $result->fetch_object()) {
                        //record found
                        $event = $record->event;
                        $pyid = $record->paymentid;
                        $id = $record->studentid;
                        $ticketprice = $record->ticketprice;
                        $totalamount = $record->totalamount;
                        printf("<p>Are you sure you want to delete the order?</p>
                     <tbody>
                     <tr>
                     <td>%s</td>
                     <td>%s</td>
                     <td>%s</td>
                     <td>%.2lf</td>
                     <td>%.2lf</td>
                     </tbody>
                     <form action='' method='POST'>
                     <input type='hidden' name='hdID' value='%s' />
                     <input type='hidden' name='hdName' value='%s' />
                     <input type='submit' value='Delete' name='btnDelete' />
                     <input type='button' value='Cancel' name='btnCancel' onclick ='location=\"PaymentList.php\"' />
                    </form>
                    ", $id, $pyid, $event , $ticketprice, $totalamount, $pyid, $id);
                    } else {
                        //record not found
                        echo '<div class="error">Unable to insert
                        (<a href="PaymentList.php">Back to list</a>)</div>';
                    }
                } else {
                    //post memthod, delete record
                    $pyid = strtoupper(trim($_POST["hdID"]));
                    $name = trim($_POST["hdName"]);

                    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

                    $sql = "DELETE FROM payment WHERE paymentid = ?";

                    $stmt = $con->prepare($sql);

                    $stmt->bind_param('s', $pyid);

                    if ($stmt->execute()) {
                        //deleted
                        printf("<div class='info'>Order %s has been deleted.
                        <a href='PaymentList.php'>Back to list</a>
                            </div>", $name);
                    } else {
                        //unble to delete
                        echo '<div class="error">Unable to delete!
                        (<a href="PaymentList.php">Back to list</a>)</div>';
                    }
                    $con->close();
                    $stmt->close();
                }
                ?>
            </table>
        </div>
    </body>
</html>

