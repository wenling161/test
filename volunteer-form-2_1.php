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
        <?php
            require_once './config/yunqing.php';
            if(!empty($_POST)){

                $studName = isset($_POST['txtName']) ? trim($_POST['txtName']) : "";
                $studCourse = isset($_POST['course1']) ? trim($_POST['course1']) : "";
                $studID = isset($_POST['txtID']) ? trim($_POST['txtID']) : "";
                $studGen = isset($_POST['rbGender']) ? trim($_POST['rbGender']) : "";
                $studEmail = isset($_POST['txtEmail']) ? trim($_POST['txtEmail']) : "";
                $studPNumber = isset($_POST['txtPNumber']) ? trim($_POST['txtPNumber']) : "";
                $joinEvent = isset($_POST['event1']) ? trim($_POST['event1']) : "";
                
            
                //Validation to check student ID, name, gender, email and phone number            
                $error['name'] = checkStudentName($studName);
                $error['course'] = checkCourse($studCourse);
                $error['id'] = checkStudentID($studID);
                $error['gender'] = checkStudentGender($studGen);
                $error['email'] = checkStudentEmail($studEmail);
                $error['pnumber'] = checkStudentPNumber($studPNumber);
                $error['event'] = checkStudentEvent($joinEvent);
                $error = array_filter($error); // overwrite the error value. Then the other error line can show
            
                if (empty($error)) {
                    //GOOD, INSERT RECORD LATER
                    //connect to database
                    $connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                    //SQL Statement to insert new record to database
                    $sql = "INSERT INTO student (Name, Course, StudentID, Gender, Email, PhoneNumber, Event) VALUES (?,?,?,?,?,?,?)";
                    $statement = $connection->prepare($sql);
                    $statement->bind_param('sssssss', $studName, $studCourse, $studID, $studGen, $studEmail, $studPNumber, $joinEvent);
                    //'ssssss' =  4 data type of field in student table (NAME, Course, ID, , Gender, Email, Phone Number, Event)
                    //BECAUSE USE printf, so varchar = string, char also print as string data type
                    $statement->execute();
                    if ($statement->affected_rows > 0) {
                        //> 0, insert record successfully!!!
                        echo"<div class='alert alert-success'>Student $studName is inserted.</div>";
                    } else {
                        //Unable to insert records!
                        echo "Please insert again!";
                    }
                    //close the connection to the database
                    $connection->close();
                    $statement->close();
                } else {
                    //NOT GOOD, display error
                    echo"<ul class='error'>";
                    foreach ($error as $errorValue) {
                        echo"<li class='alert alert-danger' role='alert'>
                            $errorValue
                            </li>";
                    }
                    echo"</ul>";
                }
            }
        ?>
        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="h1">Volunteer</div>
            </div>
            <div class="col-3"></div>
        </div>

        <div class="row">
            <div class="col-3"></div>
            <div class="col-6">
                <div class="card mt-5">
                    <div class="card-header h5">
                        Volunteer Form
                    </div>
                    <div class="card-body">
                        <form action='volunteer-form-2.php' method='POST'>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Name</label>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="txtName" placeholder="Name">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Course</label>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-sm-9">
                                    <select name="course1" class="form-select">
                                        <?php
                                        $course = getAllCourse();
                                        foreach ($course as $cour => $courValue) {
                                            printf("
                                                <option value='%s'%s>%s</option>"
                                                    , $cour
                                                    , (isset($studCourse) && $studCourse == $cour) ? 'selected' : ""
                                                    , $courValue);
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Student Id</label>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="" name="txtID" placeholder="Student ID">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Gender</label>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-sm-9">
                                    <select name="rbGender" class="form-select">
                                        <?php
                                        $allGender = getAllGender();
                                        foreach ($allGender as $sex => $sexValue) {
                                            printf("
                                                <option value='%s' %s>%s</option>"
                                                , $sex
                                                , (isset($studGen) && $studGen == $sex) ? 'selected' : ""
                                                , $sexValue);
                                        }
                                    ?>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Email</label>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" id="" name="txtEmail" placeholder="Email">
                                </div>
                            </div>

                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Phone Number</label>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-sm-9">
                                    <input type="text" class="form-control" name="txtPNumber"
                                        placeholder="Phone Number">
                                </div>
                            </div>
                            <div class="form-group row">
                                <div class="col-sm-3">
                                    <label for="" class="col-form-label">Event</label>
                                    <span class="text-danger"> *</span>
                                </div>
                                <div class="col-sm-9">
                                    <select name="event1" class="form-select">
                                        <?php
                                        $event = getAllEvent();
                                        foreach ($event as $eve => $eveValue) {
                                            printf("
                                                <option value='%s'%s>%s</option>"
                                                    , $eve
                                                    , (isset($joinEvent) && $joinEvent == $eve) ? 'selected' : ""
                                                    , $eveValue);
                                        }
                                    ?>
                                    </select>
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