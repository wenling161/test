<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<!--www.divinectorweb.com-->

<head>
    <meta charset="UTF-8">
    <title>Homepage</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="Css/custom-2.css">
    <style>
    * {
        font-family: 'Montserrat', sans-serif;

    }

    .carousel-item {
        height: 100vh;
        min-height: 300px;
    }

    .carousel-caption {
        bottom: 220px;
        z-index: 2;
    }

    .carousel-caption h5 {
        font-size: 45px;
        text-transform: uppercase;
        letter-spacing: 2px;
        margin-top: 25px;
    }

    .carousel-caption p {
        width: 60%;
        margin: auto;
        font-size: 18px;
        line-height: 1.9;
    }

    .carousel-caption a {
        text-transform: uppercase;
        text-decoration: none;
        background: crimson;
        padding: 5px 20px;
        display: inline-block;
        color: #fff;
        margin-top: 15px;
        border-radius: 5px;
    }

    .carousel-inner:before {
        content: '';
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: rgba(0, 0, 0, 0.6);
        z-index: 1;
    }

    .w-100 {
        height: 100vh;
    }

    @media only screen and (max-width: 767px) {

        .carousel-caption {
            bottom: 165px;
        }

        .carousel-caption h5 {
            font-size: 17px;
        }

        .carousel-caption a {
            padding: 10px 15px;
            font-size: 15px;
        }
    }

    /*image hover overlay*/
    .overlay {
        position: absolute;
        bottom: 100%;
        /*0%from bottom*/
        left: 0;
        right: 0;
        background-color: black;
        overflow: hidden;
        width: 100%;
        height: 0;
        transition: .8s ease;
        color:white;
    }

    .pic1:hover .overlay {
        bottom: 0;
        height: 100%;
        border-radius: 50px;
    }

    .pic2:hover .overlay {
        bottom: 0;
        height: 100%;
        border-radius: 50px;
    }

    .pic3:hover .overlay {
        bottom: 0;
        height: 100%;
        border-radius: 50px;
    }

    .pic4:hover .overlay {
        bottom: 0;
        height: 100%;
        border-radius: 50px;
    }

    .text {
        font-size: 20px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .pic1 {
        display: inline;
        float: left;
        margin-left: 50px;
        margin-bottom: 20px;
        position: relative;
        /*for down picture*/
    }

    .pic2 {
        display: inline;
        float: right;
        margin-right: 50px;
        margin-bottom: 20px;
        position: relative;
    }

    .pic3 {
        display: inline;
        float: left;
        margin-left: 50px;
        position: relative;
    }

    .pic4 {
        display: inline;
        float: right;
        margin-right: 50px;
        position: relative;
    }
    body{
        background: linear-gradient(to bottom, #28333E, #FBF2E3);
    }
    </style>
</head>

<body>
    <?php include 'header-2.php' ?>
    <div class="carousel slide" data-bs-ride="carousel" id="carouselExampleIndicatorss">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="picturefolder/homepage/homepage-bg.jpg" alt="" />
                <div class="carousel-caption">
                    <h5 class="animated fadeInDown" style="animation-delay: 1s">
                        Sports create miracles, hard work makes glory
                    </h5>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row row-cols-auto justify-content-center ms-md-5">
            <div class="col">
                <div class="h1"><span class="badge bg-secondary text-wrap text-uppercase">Join us for a fun-filled
                        experience and create lasting memories with friends</span></div>
            </div>
        </div>
        <div class="carousel slide" data-bs-ride="carousel" id="carouselExampleIndicators">
            <div class="carousel-indicators">
                <button aria-label="Slide 1" class="active" data-bs-slide-to="0"
                    data-bs-target="#carouselExampleIndicators" type="button"></button>
                <button aria-label="Slide 2" data-bs-slide-to="1" data-bs-target="#carouselExampleIndicators"
                    type="button"></button>
                <button aria-label="Slide 3" data-bs-slide-to="2" data-bs-target="#carouselExampleIndicators"
                    type="button"></button>
                <button aria-label="Slide 4" data-bs-slide-to="3" data-bs-target="#carouselExampleIndicators"
                    type="button"></button>
                <button aria-label="Slide 5" data-bs-slide-to="4" data-bs-target="#carouselExampleIndicators"
                    type="button"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img alt="..." class="d-block w-100" src="picturefolder/homepage/slider2.png">
                </div>
                <div class="carousel-item">
                    <img alt="..." class="d-block w-100" src="picturefolder/homepage/slider3.png">
                </div>
                <div class="carousel-item">
                    <img alt="..." class="d-block w-100" src="picturefolder/homepage/slider4.png">
                </div>
                <div class="carousel-item">
                    <img alt="..." class="d-block w-100" src="picturefolder/homepage/slider5.png">
                </div>
                <div class="carousel-item">
                    <img alt="..." class="d-block w-100" src="picturefolder/homepage/slider6.png">
                </div>
            </div>
            <!-- <button class="carousel-control-prev" data-bs-slide="prev" data-bs-target="#carouselExampleIndicators"
                type="button">
                <span aria-hidden="true" class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" data-bs-slide="next" data-bs-target="#carouselExampleIndicators"
                type="button">
                <span aria-hidden="true" class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button> -->
        </div>
    </div>
    <div class="container mt-3">
        <div class="row row-cols-auto justify-content-center ms-md-5">
            <div class="col">
                <div class="h1"><span class="badge bg-secondary text-wrap text-uppercase">🚩 POPULAR EVENT - Basketball
                        Event</span></div>
            </div>
        </div>
    </div>
    <div class="container mt-3">
        <div class="row">
            <div class="col-12">
                <video width="100%" autoplay muted loop>
                    <source src="video-mp4/The-Professor-SERIOUSLY-TESTED-5v5-vs-Abrasive-Pro-Hoopers.mp4.crdownload"
                        type="video/mp4">
                    Your browser does not support the video tag.
                </video>
            </div>

        </div>
    </div>
    <div class="container mt-3">
        <div class="row row-cols-auto justify-content-center ms-md-5">
            <div class="col">
                <div class="h1"><span class="badge bg-secondary text-wrap text-uppercase">🎉 Events 🎉</span></div>
            </div>
        </div>
        <div class="row">
            <div class="col-6">
                <div class="pic1">
                    <img src="picturefolder/event/event-basketball.png" alt="" style="width:500px;border-radius:50px" />
                    <div class="overlay">
                        <div class="text">
                            <h1>Basketball Event</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="pic1">
                    <img src="picturefolder/event/event-bowling.png" alt="" style="width:500px;border-radius:50px"  />
                    <div class="overlay">
                        <div class="text">
                            <h1>Bowling Event</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="pic1">
                    <img src="picturefolder/event/event-gym.png" alt="" style="width:500px;border-radius:50px" />
                    <div class="overlay">
                        <div class="text">
                            <h1>Gym Event</h1>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="pic1">
                    <img src="picturefolder/event/event-running.png" alt="" style="width:500px;border-radius:50px" />
                    <div class="overlay">
                        <div class="text">
                            <h1>Running Event</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
           

         <div class="col">
             <div class="eventLocation">
                <div class="h1"><span class="badge bg-secondary text-wrap text-uppercase">Event location</span></div>
            </div>
             </div>
        <div class="map">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3983.527554441081!2d101.72518887483514!3d3.21788049675727!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x31cc38684c1dc025%3A0x2474c99f796a583c!2sTARUMT%20Block%20R!5e0!3m2!1sen!2smy!4v1683437794555!5m2!1sen!2smy" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>        </div>

    <div class="mt-5">
        <?php include 'footer-2.php' ?>
    </div>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js">
    </script>
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
</body>

</html>