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
    </head>
    <body>
        <?php include 'header-2.php'; ?>
    <?php require_once './config/database.php';
    ?>
        
        <h1>Delete Member Feedback</h1>
        
        <?php
        if($_SERVER["REQUEST_METHOD"]== "GET"){
            //get method, retrieve record to display
            (isset($_GET["id"]))?
            $id = strtoupper(trim($_GET["id"])):
                $id = "";
            $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $sql = "SELECT * FROM review WHERE ReviewID = '$id'";
            $result = $con->query($sql);
            if($record = $result->fetch_object()){
                //record found
            $id = $record-> ReviewID;
            $studid = $record-> StudentID;
            $name = $record -> Name;
            $event = $record-> Event;
            $categories = $record -> Categories;
            $star = $record -> StarRate;
            printf("<p>Are you sure you want to delete the following review?</p>
                     <table>
                     <tr>
                     <td>Review ID: </td>
                     <td>%s</td>
                     </tr>
                     <tr>
                     <td>Student ID: </td>
                     <td>%s</td>
                     </tr>
                     <tr>
                     <td>Name: </td>
                     <td>%s</td>
                     </tr>
                     <tr>
                     <td>Event: </td>
                     <td>$event</td>
                     </tr>
                     <tr>
                     <td>Categories: </td>
                     <td>$categories</td>
                     </tr>
                     <tr>
                     <td>Star-rated: </td>
                     <td>$star</td>
                     </tr>
                     </table>
                     <form action='' method='POST'>
                     <input type='hidden' name='txtID' value='$id' />
                     <input type='hidden' name='txtName' value='$name' />
                     <input type='submit' value='Delete' name='btnDelete' />
                     <input type='button' value='Cancel' name='btnCancel' onclick ='location=\"feedback-2.php\"' />
                     
                    </form>
                    ",$id,$studid,$name, getAllEvent($event), getAllCategories($categories), getAllStarRate($star), $id, $name);
        }else{
            //record not found
            echo '<div class="error">Unable to delete
                        (<a href="feedback-2.php">Back to list</a>)</div>';
        }
        }
        else{
            //post method, delete record
            $id = strtoupper(trim($_POST["txtID"]));
            $name = trim($_POST["txtName"]);
            
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            
            $sql = "DELETE FROM review WHERE ReviewID = ?";
            
            $stmt = $con->prepare($sql);
            
            $stmt -> bind_param('s',$id);
            
            if($stmt->execute()){
                //deleted
                printf("<div class='info'>Student %s has been deleted.
                        <a href='feedback-2.php'>Back to list</a>
                            </div>", $name);
            }else{
                //unble to delete
                echo '<div class="error">Unable to delete!
                        (<a href="feedback-2.php">Back to list</a>)</div>';
            }
            $con->close();
            $stmt->close();    
        }
        ?>
        
        <?php 
        include 'footer-2.php';
        ?>
    </body>
</html>