<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="Css/custom-2.css">
    <style>
    .card {
        max-width: 70em;
        flex-direction: row;
        background-color: #696969;
        border: 0;
        box-shadow: 0 7px 7px rgba(0, 0, 0, 0.18);
        margin: 3em auto;
    }

    .card.dark {
        color: #fff;
    }

    .card.card.bg-light-subtle .card-title {
        color: dimgrey;
    }

    .card img {
        max-width: 30%;
        margin: auto;
        padding: 0.5em;
        border-radius: 0.7em;
        height: 20em;
    }

    .card-body {
        display: flex;
        justify-content: space-between;
    }

    .text-section {
        max-width: 60%;
    }

    .cta-section {
        max-width: 40%;
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        justify-content: space-between;
    }

    .cta-section .btn {
        padding: 0.3em 0.5em;
        /* color: #696969; */
    }

    .card.bg-light-subtle .cta-section .btn {
        background-color: #898989;
        border-color: #898989;
    }
    body{
        background: linear-gradient(to bottom, #28333E, #FBF2E3);
    }

    @media screen and (max-width: 475px) {
        .card {
            font-size: 0.9em;
        }
    }
    </style>
</head>

<body>
    <!-- Fixed navbar -->
    <?php include 'header-2.php' ?>
    <div class="container">
        <?php 
            require_once './config/helper.php';
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT * FROM event";

            if($result = $con->query($sql)){
                while ($row = $result->fetch_object()){
                    printf('
                    <div class="card bg-secondary mt-4">
                        <img src="image/%s" class="card-img-top" alt="%s">
                        <div class="card-body">
                            <div class="text-section">
                                <h1 class="card-title fw-bold text-white font-weight-bold">%s</h1>
                                <p class="card-text text-white"><b>Description</b> : %s</p>
                                <p class="card-text text-white"><b>Date</b> : %s</p>
                                <p class="card-text text-white"><b>Time</b> : %s</p>
                                <p class="card-text text-white"><b>Location</b> : %s</p>
                            </div>
                            <div class="cta-section">
                                <div class="text-white">Price : RM%s</div>
                                <div>', $row->event_picture, $row->event_name, $row->event_name, $row->event_description, $row->event_date, $row->event_time, $row->location, number_format($row->event_price, 2));
                                if (isset($_SESSION['userLogin'])) {
                                    printf('<a href="add-to-cart-2.php?event_id=%s&studentID=%s&quantity=1&price=%s" class="btn btn-light">Add to cart</a>', $row->event_id, $_SESSION['studentId'], $row->event_price);
                                    echo '<span style="margin: 0 5px;"></span>'; // Add spacing here                                    
                                }else{
                                    printf('<a href="login-form-2.php" class="btn btn-light" title="Required to login first" style="cursor: no-drop;">Login</a>');
                                    echo '<span style="margin: 0 5px;"></span>'; // Add spacing here                   
                                }
                    printf('
                                </div>
                            </div>
                        </div>
                    </div>
                    ');
                }
            }
        ?>
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