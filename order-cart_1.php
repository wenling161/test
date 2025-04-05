<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Ordering Cart</title>
        <link href="Css/order-cart.css" 
              rel="stylesheet" 
              type="text/css"/>
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <?php include 'Header.php';?>
    </head>
    <body>
        <div class="title">
            <b>Ordering Cart</b>
            <table class="table">                
                <tr>
                    <td><label>Remove</label></td>
                    <td><label>Ticket</label></td>
                    <td><label>Price</label></td>
                    <td><label>Quantity</label></td>
                    <td><label>Total</label></td>
                </tr>                              
                <tr>
                    <td class="icon"><a href="#"><i class='bx bx-trash'></i></a></td>
                    <td><label>Basketball Event</label></td>
                    <td><label>RM10</label></td>
                    <td><div class="btn-container">
                            <button class="cart-qty-plus" 
                                    type="btn" 
                                    value="+">+</button>
                            <input type="text" name="qty" 
                                   min="1" class="qty-form-control" 
                                   value="1">
                            <button class="cart-qty-minus" 
                                    type="btn" 
                                    value="-">-</button>
                        </div></td>
                    <td><label>RM10</label></td>
                </tr>
                <tr>
                    <td class="icon"><a href="#"><i class='bx bx-trash'></i></a></td>
                    <td><label>Gym Event</label></td>
                    <td><label>RM5</label></td>
                    <td><div class="btn-container">
                            <button class="cart-qty-plus" 
                                    type="btn" 
                                    value="+">+</button>
                            <input type="text" name="qty" 
                                   min="1" class="qty-form-control" 
                                   value="1">
                            <button class="cart-qty-minus" 
                                    type="btn" 
                                    value="-">-</button>
                        </div></td>
                    <td><label>RM5</label></td>
                </tr>
                <tr>
                    <td class="icon"><a href="#"><i class='bx bx-trash'></i></a></td>
                    <td><label>Bowling Event</label></td>
                    <td><label>RM10</label></td>
                    <td><div class="btn-container">
                            <button class="cart-qty-plus" 
                                    type="btn" 
                                    value="+">+</button>
                            <input type="text" name="qty" 
                                   min="1" class="qty-form-control" 
                                   value="1">
                            <button class="cart-qty-minus" 
                                    type="btn" 
                                    value="-">-</button>
                        </div></td>
                    <td><label>RM10</label></td>
                </tr>
                <tr>
                    <td colspan="4"></td>
                    <td align="right">
                        <strong><label>TOTAL = RM <span id="total" class="total">25</label></span></strong>
                    </td>
                </tr>      

            </table>
            <button class="payBtn"><a href="Payment.php">Pay now</a></button> 
        </div>                   
    </body>
</html>
