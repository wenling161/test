<?php
    session_start();
    if (!isset($_SESSION['userLogin'])) {
        header("Location: login-form-2.php");
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="Css/custom-2.css">
</head>

<body>
    <!-- Fixed navbar -->
    <?php include 'header-2.php' ?>
    <div class="container mt-5">
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <?php
                    if (isset($_POST["placeorder"])) {
                        if(isset($_POST["events"])){
                                        
                            $checked = $_POST['events'];
                            $quantities = $_POST['quantities'];
                            $prices = $_POST['prices'];
                            $orderIds =  $_POST['orderid'];

                            $name = isset($_POST["name"]) ? trim($_POST["name"]) : "";
                            $stud_id = isset($_POST["studentid"]) ? trim($_POST["studentid"]) : "";
                            $email = isset($_POST["email"]) ? trim($_POST["email"]) : "";

                            // Validate and process the student information here

                            $con = new mysqli("localhost", "root", "", "liyi");
                            $sql = 'INSERT INTO payment (paymentid, studentid, fullname, email, event, ticketquantity, ticketprice, totalamount) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';
                            $stmt = $con->prepare($sql);
                            // Insert the data into the database
                            for ($i = 0; $i < count($checked); $i++) {
                                $total_amount = 0;
                                $paymentId = uniqid();
                                $event_names = $checked[$i];
                                $quantityy = $quantities[$i];
                                $event_price = $prices[$i];
                                $total_amount = $event_price * $quantityy;
                                
                                            
                                $stmt->bind_param("sssssidd", $paymentId, $stud_id, $name, $email, $event_names, $quantityy, $event_price, $total_amount);
                                if($stmt->execute()){
                                    $order_id = $orderIds[$i];
                                    $deleteStmt = $con->prepare("DELETE FROM cart WHERE orderid = ?");
                                    $deleteStmt->bind_param("s", $order_id);
                                    $deleteStmt->execute();
                                }
                            }

                            if ($stmt->affected_rows > 0) {
                                echo '
                                <div class="alert alert-success" role="alert">
                                    Payment has been inserted. <a href="homepage-2.php" class="alert-link">Continue Shopping</a>
                                </div>';
                                // Clear the form data
                                $name = $stud_id = $email = null;
                                // Delete the orderid from the cart table
                                
                                $deleteStmt = $con->prepare("DELETE FROM cart WHERE orderid = ?");
                                $deleteStmt->bind_param("s", $orderIds);
                                $deleteStmt->execute();

                            } else {
                                echo '
                                    <div class="alert alert-danger" role="alert">
                                        Oops. Database issue. Record not inserted.
                                    </div>';
                            }

                            $stmt->close();
                            $con->close();
                            
                        }
                    }
                ?>
                <div class="mt-5 h1">Payment</div>
            </div>
            <div class="col-3"></div>
        </div>

        <div class="container">
            <div class="row justify-content-center mt-5">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Payment Details</h4>
                        </div>
                        <div class="card-body">
                            <form action="payment-2.php" method="POST">
                                <?php
                                    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['doPayment'])) {
                                        if (isset($_POST['checked']) && isset($_POST['quantity'])) {
                                            $checkedArr = $_POST['checked'];
                                            $eventPriceArr = $_POST['price'];
                                            $quantityArr = $_POST['quantity'];
                                            $orderIdArr = $_POST['orderid'];

                                            // Process the selected events and quantities
                                            for ($i = 0; $i < count($checkedArr); $i++) {
                                                $event_name = $checkedArr[$i];
                                                $quantity = $quantityArr[$event_name];
                                                $eventPrice = $eventPriceArr[$event_name];
                                                $newOrderId = $orderIdArr[$event_name];

                                                // Perform any necessary operations with the event details
                                                // For example, you can store them in variables, display them, or insert them into a database
                                                echo "Event: $event_name, Quantity: $quantity, Price: $eventPrice <br>";
                                                echo '<input type="hidden" name="events[]" value="' . $event_name . '">';
                                                echo '<input type="hidden" name="quantities[]" value="' . $quantity . '">';
                                                echo '<input type="hidden" name="prices[]" value="' . $eventPrice . '">';
                                                echo '<input type="hidden" name="orderid[]" value="' . $newOrderId . '">';
                                            }
                                            
                                        }
                                    }
                                ?>
                                <div class="form-group mb-3">
                                    <label for="name">Full Name</label>
                                    <input type="text" id="name" name="name" placeholder="Enter your full name"
                                        class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Student ID</label>
                                    <input type="text" class="form-control" placeholder="Enter your student id"
                                        pattern="\d{2}[A-Z]{3}\d{5}" name="studentid" id="studentid" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="name">Email</label>
                                    <input type="text" class="form-control" placeholder="Enter your email" name="email"
                                        id="email" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="card-number">Card Number</label>
                                    <input type="text" id="card-number" class="form-control" required
                                        placeholder="1111 2222 3333 4444">
                                </div>
                                <div class="form-group mb-3">
                                    <label for="expiry-date">Expiry Date</label>
                                    <input type="month" id="expiry-date" class="form-control" required>
                                </div>
                                <div class="form-group mb-3">
                                    <label for="cvv">CVV</label>
                                    <input type="text" id="cvv" class="form-control" required placeholder="CVV Code">
                                </div>
                                <div class="form-group mb-3">
                                    <input type="submit" class="btn btn-primary" name="placeorder"
                                        value="Submit Payment" />
                                    <a class="btn btn-warning" href="cart-2.php">Cancel</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- /container -->
    <div class="mt-5">
        <?php include 'footer-2.php' ?>
    </div>
</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
(function($) {
    $(window).scroll(function() {
        if ($(document).scrollTop() > 300) {
            // Navigation Bar
            $('.navbar').removeClass('fadeIn');
            $('.navbar').addClass('fixed-top animated fadeInDown');
        } else {
            $('.navbar').removeClass('fadeInDown');
            $('.navbar').removeClass('fixed-top');
            $('body').removeClass('shrink');
            $('.navbar').addClass('animated fadeIn');
        }
    });
})(jQuery);
</script>

</html>