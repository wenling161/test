<?php

$uniq_id = "O" . substr(uniqid(), -7);

$event_id = $_GET['event_id']; // Replace with actual item ID
$studentID = $_GET['studentID'];
$addQuantity = $_GET['quantity'];
// connect to the database
$conn = mysqli_connect('localhost', 'root', '', 'liyi');

// check if the item is already in the cart for the current user
$cart_query = "SELECT * FROM cart WHERE event_id = '$event_id' AND studentid = '$studentID'";
$cart_result = mysqli_query($conn, $cart_query);

if (mysqli_num_rows($cart_result) > 0) {
   $cart_row = mysqli_fetch_assoc($cart_result);
   $quantity = $addQuantity;
   $update_query = "UPDATE cart SET quantity = $quantity WHERE event_id = ".$event_id." AND studentid = '".$studentID."'";
   mysqli_query($conn, $update_query);
} else {
   // if the item is not in the cart, insert a new row
   $price = $_GET['price'];
   $insert_query = "INSERT INTO cart (orderid, event_id, studentid, quantity, price) VALUES ('$uniq_id', '$event_id', '$studentID', 1, '$price')";
   $result = mysqli_query($conn, $insert_query);

    if (!$result) {
        echo "Error inserting data: " . mysqli_error($conn);
    }
}

header('Location: event-details-2.php');
exit;
?>