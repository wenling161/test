<?php
    session_start();
    if (!isset($_SESSION['userLogin'])) {
        header("Location: login-form-2.php");
    }
    // Connect to database
    $conn = new mysqli("localhost","root","","liyi");
    
    
    if(isset($_POST['action'])){
        $orderId = $_POST['id'];
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
          }
        $deleteCartSql = "DELETE FROM cart WHERE orderid = ?";
        $stmt = $conn->prepare($deleteCartSql);
        $stmt ->bind_param('s', $orderId);
        $stmt->execute();
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Cart Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="Css/custom-2.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
</head>

<body>
    <?php include 'header-2.php' ?>
    <div class="container mt-5">
        <div class="container-fluid mt-5">
            <h2>Shopping Cart</h2>
            <form action='payment-2.php' method='POST'>
                <table class="table table-bordered table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Student Id</th>
                            <th>Event Name</th>
                            <th>Price (RM)</th>
                            <th>Quantity</th>
                            <th>Total (RM)</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                    
                        // Retrieve cart items from database
                        $sql = "select c.orderid, c.studentid, e.event_name, c.event_id, c.price, c.quantity from cart c left join event e on c.event_id = e.event_id WHERE c.studentid = '".$_SESSION['studentId']."'";
                        $result = mysqli_query($conn, $sql);
                        $total_price = 0;
                        $success = true;
                        // Display cart items
                        if(mysqli_num_rows($result) > 0) {
                            while($row = mysqli_fetch_assoc($result)) {
                                $orderid  = $row['orderid'];
                                $studentid = $row['studentid'];
                                $event_name = $row['event_name'];
                                $event_id = $row['event_id'];
                                $price = $row['price'];
                                $quantity = $row['quantity'];
                                $total = $price * $quantity;
                                $total_price += $total;
                        
                                echo "<tr>";
                                echo "<td>" . $studentid . "</td>";
                                echo "<td>" . $event_name . "</td>";
                                echo "<td>" . number_format($price, 2) . "</td>";
                                echo "<td><input type='number' class='form-control' min='1' value='" . $quantity . "' onchange='updateQuantity(" . $event_id . ", this.value, \"" . $_SESSION['studentId'] . "\")'></td>";
                                echo "<td>" . number_format($total, 2) . "</td>";
                                echo "<td><button class='btn btn-danger' onclick='deleteItem(\"" . $orderid .  "\")'>Delete</button></td>";
                                echo "</tr>";
                                printf('
                                    <input type="hidden" name="checked[]" value="%s">
                                    <input type="hidden" name="price[%s]" value=%s>
                                    <input type="hidden" name="quantity[%s]" value=%s>
                                    <input type="hidden" name="orderid[%s]" value=%s>
                                ', $event_name, $event_name, $price, $event_name, $quantity, $event_name, $orderid);
                            }
                        } else {
                            echo "<tr><td colspan='6' class='text-center'>No record found</td></tr>";
                            $success = false;
                        }
                        
                        // Close database connection
                        mysqli_close($conn);
                    ?>

                    </tbody>
                </table>

                <div class="text-right">
                    <h4>Total Price: RM <?php echo number_format($total_price, 2) ?></h4>
                    <?php
                        if($success){
                            printf('<input type="submit" name="doPayment" value="Checkout" class="btn btn-success">');
                        }else{
                            printf('<input type="submit" disabled value="Checkout" class="btn btn-success">');
                        }
                    ?>
                </div>
            </form>
        </div>
    </div>
    <div class="mt-5">
        <?php include 'footer-2.php' ?>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    // Function to update item quantity in cart
    function updateQuantity(id, quantity, studentId) {
        $.ajax({
            url: "add-to-cart-2.php",
            method: "GET",
            data: {
                event_id: id,
                quantity: quantity,
                studentID: studentId
            },
            success: function(response) {
                location.reload();
            }
        });
    }

    // Function to delete item from cart
    function deleteItem(id) {
        if (confirm("Are you sure you want to delete this item?")) {
            $.ajax({
                url: "cart-2.php",
                method: "POST",
                data: {
                    id: id,
                    action: "delete",
                },
                success: function(response) {
                    location.reload();
                }
            });
        }
    }

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

</body>

</html>