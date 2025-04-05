<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MK Sport</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Css/header.css" rel="stylesheet" type="text/css"/>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Add Bootstrap CSS for dropdown functionality -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<header>
    <nav class="topnav">
        <div class="logo-container">
            <a href="homepage.php"><img class="logo" src="image/WeChat Image_20230331170145.png" alt="TARUC-LOGO"/></a>
            <input id="search-bar" type="text" placeholder="Search events or sports..."/>
        </div>

        

        <ul>
            <li class="active"><a href="homepage-2.php"><i class="fas fa-home"></i> Home</a></li>
            <li><a href="event-details-2.php"><i class="fas fa-calendar-alt"></i> Events</a></li>
            
            <?php
                if (isset($_SESSION['userLogin'])) {
                    echo '
                        <li><a href="volunteer-form-2.php"><i class="fas fa-hands-helping"></i> Volunteer</a></li>
                        <li><a href="feedback-2.php"><i class="fas fa-comment"></i> Feedback</a></li>
                       <!-- <li class="dropdown">
                            <a class="dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fas fa-cog"></i> Settings
                            </a>
                            <ul class="dropdown-menu">--!>
                                <li><a class="dropdown-item" href="customer-profile-2.php"><i class="fas fa-user-circle"></i> Account</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout-2.php?role=customer"><i class="fas fa-sign-out-alt"></i> Logout</a></li>
                            <!--</ul>--!>
                        </li>
                        <li class="cart-badge">
                            <a href="cart-2.php"><i class="fas fa-shopping-cart"></i> Cart</a>
                        </li>
                    ';
                } else {
                    echo '
                        <li><a href="login-form-2.php"><i class="fas fa-sign-in-alt"></i> Login</a></li>
                    ';
                }
            ?>
        </ul>
    </nav>
</header>


</body>
</html>