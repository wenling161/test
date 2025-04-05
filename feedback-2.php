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
    <title>Add Member Feedback</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="Css/custom-2.css">
     <style>
        .container{
    background: linear-gradient(to top, #515855, #EEF7F2);
}
    </style>
</head>

<body>
    <!-- Fixed navbar -->
    <?php 
        include 'header-2.php';
        //require_once './config/database.php';
        require_once './config/yunqing.php';
     ?>
    <?php 
                            global $studentid;
                            global $fullname;
                            $conn = new mysqli("localhost", "root", "", "liyi");
                            $studentid = $_SESSION['studentId'];
                            $stmt = $conn->prepare("SELECT * FROM member WHERE studentid = ?");
                            $stmt->bind_param("s", $studentid);
                            $stmt->execute();
                            $result = $stmt->get_result();
                            if($result->num_rows > 0){
                                if($row = $result->fetch_assoc()) {
                                   $fullname=$row['fullname'];
                                }
                            }
                        ?>

    <div class="container mt-5">
        
        <?php
            if (!empty($_POST)) {
                //check if the button clicked? or user input any data?

                //YES, user clicked the insert button
                //retrieve ALL user input
                $event = isset($_POST["ddlEvent"]) ? trim($_POST["ddlEvent"]) : "";
                $categories = isset($_POST["ddlCategories"]) ? trim($_POST["ddlCategories"]) : "";
                $star = isset($_POST["rbStar"]) ? trim($_POST["rbStar"]) : "";

    
                //check error/ validation
                $error["event"] = checkEvent($event);
                $error["categories"] = checkCategories($categories);
                $error["star"] = checkStar($star);
                
                $error = array_filter($error);
                $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                $sql = "SELECT MAX(ReviewID) FROM review";
                $result = $conn ->query($sql);
                $idrow = $result->fetch_row();
                $max_id= $idrow[0];
                $reviewid = $max_id +1;
                
               if (empty($error)) {
                     $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                     $sql = "INSERT INTO review (ReviewID,StudentID,Name,Event,Categories,StarRate)
                          VALUES (?,?,?,?,?,?)";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("sssssi",$reviewid,$studentid,$fullname,$event, $categories, $star);
                    $stmt->execute();
                    if ($stmt->affected_rows > 0) {
                        //INSERT Successful
                        printf("<div class='alert alert-success'>
                                   Review %s has been inserted.
                                   <a href='feedback-2.php'>
                                   Back to list</a></div>", $fullname);
                    } else {
                        echo'<div class="alert alert-danger">Unable to insert!
                       [<a href="feedback-2.php">Back to list</a>]</div>';
                    }
                } else {
                    //WITH ERROR, DISPLAY ERROR MSG
                    echo"<ul class='error'>";
                    foreach ($error as $value) {
                        echo"<li class='alert alert-danger'>$value</li>";
                    }
                    echo"</ul>";
                }
            }
        ?>
         <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="h1">Feedback</div>
                <h5>Please choose the EVENT you would like to rate</h5>
            </div>
            <div class="col-3"></div>
        </div>

        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card mt-5">
                    <div class="card-header h5">
                        Feedback Form
                    </div>
                    <div class="card-body">
                        <form action='feedback-form-2.php' method='POST'>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Student ID</label>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="studentid" value="<?php echo (isset($studentid))?$studentid:""?> " disabled>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Student Name</label>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="fullname" value="<?php echo (isset($fullname))?$fullname:""?> " disabled>
                                </div>
                            </div>


                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Event</label>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-sm-9">
                                    <select name="ddlEvent" class="form-select">
                                        <?php
                                        $allEvent = getAllEvent($event);
                                        foreach ($allEvent as $key => $value) {
                                            printf("<option value='%s' %s>%s</option>", 
                                                $key,
                                                ($event == $key) ? 'selected' : "",
                                                $value);
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Categories</label>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-sm-9">
                                    <select name="ddlCategories" class="form-select">
                                        <?php
                                        $allCategories = getAllCategories($categories);
                                        foreach ($allCategories as $key => $value) {
                                            printf("<option value='%s' %s>%s</option>", 
                                                $key,
                                                ($categories == $key) ? 'selected' : "",
                                                $value);
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Star-rated</label>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-sm-9">
                                    <?php
                                    $allStarRate = getAllStarRate();
                                    foreach ($allStarRate as $key => $value) {
                                        printf("<input type='radio' name='rbStar' value='%s' />%s", $key, $value);
                                    }
                                    ?>
                                </div>
                            </div>



                            <input class="btn btn-primary" type="submit" value="Submit" />
                        </form>
                    </div>
                </div>
            </div>
            <div class="col-3"></div>
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