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
    <title>All Feedback</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="Css/custom-2.css">
    <style>
    .no-style {
        color: inherit;
        text-decoration: none;
        cursor: pointer;
        font-weight: bold;
    }
    </style>
</head>

<body>
    <!-- Fixed navbar -->
    <?php 
        include 'header-2.php';
        require_once './config/database.php';
        $studentid = $_SESSION['studentId'];
    
        $header = array(
                'ReviewID' => 'Review ID',
                'StudentID' => 'Student ID',
                'Name' =>'Name',
                'Event' =>'Event',
                'Categories' =>'Categories',
                'StarRate' =>'Star-rated',
            );
        //check $sort $order variable -> prevent sql error
            //which column to sort?
            global $sort, $order;
            if (isset($_GET['sort']) && isset($_GET['order'])){
            $sort = (array_key_exists($_GET['sort'], $header)?
                    $_GET['sort'] : 'StarRate');
            
            //how to arrange order sequence ASC / DESC
            $order = ($_GET['order'] == 'DESC')? 'DESC' : 'ASC';
            }else{
                $sort = "StarRate";
                $order = "ASC";
            }
            if (isset($_GET['star'])){
            $star = (array_key_exists($_GET["star"],
                            getAllStarRate())? $_GET["star"]: "%");
            }else{
                $star ="%";
            }
        ?>

    <div class="container mt-5">
        <div class="h1">Member Feedback</div>
        <?php
            if(isset($_POST['btnDelete'])){
                (isset($_POST['checked']))?
                $checked = $_POST['checked']:
                    $checked = "";
                if(!empty($checked)){
                    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
                    foreach($checked as $value){
                        $checkValue[] = $con->real_escape_string($value);
                    }
                    
                    //DELETE FROM Student WHERE StudentID IN
                    //('21PMD12345','21PMD45677')
                    $sql="DELETE FROM review WHERE StudentID IN ('". 
                            implode("','", $checkValue)."')";
                    
                    if($con ->query($sql)){
                        printf("<div class = 'info'>
                                %d record has been deleted!
                                </div>",$con->affected_rows);
                    }
                    $con->close();
                }
            }
            
        ?>
        <form method="POST">

            <div class='Hldesign2 mt-3'>Filter:
                <?php 
                printf("
                <nav aria-label='Page navigation example'>
                    <ul class='pagination'>
                ");
                printf("<li class='page-item'><a class='page-link' href='?sort=%s&order=%s'>ALL Programs</a></li>", $sort, $order);

                $allStarRate = getAllStarRate($star);//array
                
                foreach ($allStarRate as $key => $value) {
                    printf("
                                <li class='page-item'><a class='page-link' href='?sort=%s&order=%s&star=%s'>%s</a></li>
                            ",$sort,$order,$key,$value);
                }
                printf("
                            </ul>
                        </nav>
                ");
            ?>
            </div>
            <table class="mt-5 table table-striped table-bordered">
                <thead>
                <tr>
                    <?php
                        foreach ($header as $key => $value) {
                            if($key == $sort){
                                //YES, user clicked to perform sorting
                            printf('<th>
                                    <a class="no-style" href="?sort=%s&order=%s&star=%s">%s</a>
                                    %s
                                    </th>',
                                    $key,
                                    $order =='ASC'?'DESC' : 'ASC',
                                    $star, //to retain filter effect even after sorting toward record
                                    $value,
                                    $order == 'ASC' ? '⬇️️' : '️⬆️');
                            } else {
                                //NO, user never click anything, default
                                printf('<th>
                                        <a class="no-style" href="?sort=%s&order=ASC&star=%s">%s</a>
                                        </th>',
                                        $key,
                                        $star,//to retain filter effect even after sorting toward record
                                        $value);
                            }
                        } 
                    ?>
                </tr>
                </thead>
                <?php 
            
                    
                    //step 2: link php app with database
                    //object-oriented method 
                    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME); //assm will chg this thn we nid solve
                    
                    //step 3: sql statement LIKE is checking similarity
                    $sql ="SELECT * FROM review";
                    
                    //step 4: execute/ run sql
                    //$result(obj array) - contains ALL 5 records
                    if ($result = $con->query($sql)){
                        //record found
                        while($record = $result->fetch_object()){
                            printf("<tr>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                <td>%s</td>
                                </tr>"
                                ,$record->ReviewID
                                ,$record->StudentID
                                ,$record->Name
                                ,$record->Event
                                ,$record->Categories
                                ,$record->StarRate
                                ,$record->ReviewID
                                ,$record->ReviewID
                                );
                            
                        }
                        printf("<tr><td colspan='7'>%d record(s) returned.
                                [<a class='no-style' href='feedback-2.php'>Back</a>]
                                </td></tr>",$result->num_rows);
                        
                        $result->free();
                        $con->close();
                    }
                    
                ?>

            </table>
            <br />
        </form>

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