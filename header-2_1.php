<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand" href="homepage-2.php"><img class="logo"
                src="image/WeChat Image_20230331170145.png" alt="TARUC-LOGO" style="height:50px;width:50px" /></a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain"
            aria-controls="navbarMain" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="homepage-2.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="event-details-2.php">Event</a>
                </li>
                <?php
                    
                    if (isset($_SESSION['userLogin'])) {
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="volunteer-form-2.php">Volunteer</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="feedback-2.php">Feedback</a>
                            </li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    Setting
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <div class="dropdown-content">
                                    <li><a class="dropdown-item" href="customer-profile-2.php">Account</a></li>
                                    <li><a class="dropdown-item" href="logout-2.php?role=customer">Logout</a></li>
                                    </div>
                                </ul>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="cart-2.php">Cart</a>
                            </li>
                        ';
                    } else {
                        echo '
                            <li class="nav-item">
                                <a class="nav-link" href="login-form-2.php">Login</a>
                            </li>
                        ';
                    }
                ?>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
</nav>