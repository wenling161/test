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
        <?php include 'header-2.php'; 
    require_once './config/database.php';
    ?>
        
        <h1>Edit Member Feedback</h1>
        
        <?php
        global $hideForm;
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            //get method
            //retrieve record and display data in the form
            //retrieve name from URL
            (isset($_GET["id"]))?
            $id = strtoupper(trim($_GET["id"])):
            $id ="";
            //Step 1: connection
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        
        //step 2 : sql statement
        $sql ="SELECT * FROM review WHERE ReviewID = '$id'";
        
        //step 3 : run sql
        $result = $con->query($sql);
        
        if($record = $result->fetch_object()){
            //record found
            $id = $record -> ReviewID;
            $studid = $record -> StudentID;
            $name = $record -> Name;
            $event = $record -> Event;
            $categories = $record -> Categories;
            $star = $record -> StarRate;
            
        }else{
            //record not found
            echo"<div class ='error'>Unable to retrieve record!
            <a href ='feedback-2.php'>Back to list</a>
            </div>";
            $hideForm = true;
        }
        
        $result-> free();
        $con -> close();
        }else{
            //post method
            $id = strtoupper(trim($_POST["txtID"]));
            $studid = strtoupper(trim($_POST["txtStudID"]));
            $name = trim($_POST["txtName"]);
            $event = trim($_POST["ddlEvent"]);
            $categories = trim($_POST["ddlCategories"]);
            $star = trim($_POST["rbStar"]);
            
            $error["name"] = checkName($name);
            $error["event"] = checkEvent($event);
            $error["categories"] = checkCategories($categories);
            $error["star"] = checkStar($star);
            $error = array_filter($error);
            if(empty($error)){
                //no error
                //Step 1 : connect
                $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);  
                //Step 2 :
                $sql = "UPDATE review SET StudentID = ?, Name = ?,
                        Event =?, Categories = ?, StarRate = ? WHERE ReviewID = ?";
                $statement = $con->prepare($sql);
                $statement-> bind_param("ssssis",$studid,$name,$event,$categories,$star,$id);
                if($statement-> execute()){
                    printf("<div class='info'>Successfully edit!
                   [<a href='feedback-2.php'>Back to list</a>]</div>",$name);
                    // updated
                }else{
                    //Fail to update
                    echo"<div class='error'>Unable to edit!
                   [<a href='feedback-2.php'>Back to list</a>]</div>";
                }
                    
                
            }else{
            //got error
            echo"<ul class='error'>";
                foreach($error as $value){
                    echo"<li>$value</li>";
                }
                echo"</ul>";
            //update record
            
        }
        }
        ?>
        
        <?php if ($hideForm == false) : ?>
        <form action="" method="POST">
            <table>
                <tr>
                    <td>Review ID: </td>
                    <td><?php echo $id;?>
                        <input type="hidden" name="txtID" 
                               value="<?php echo $id?>" />
                    </td>
                </tr>
                 <tr>
                    <td>Student ID: </td>
                    <td><?php echo $studid;?>
                        <input type="hidden" name="txtStudID" 
                               value="<?php echo $studid?>" />
                    </td>
                </tr>
                
                <tr>
                    <td>Name: </td>
                    <td><?php echo $name;?>
                        <input type="hidden" name="txtName" 
                               value="<?php echo $name?>"/>
                    </td>
                </tr>
                
                <tr>
                    <td>Event: </td>
                    <td><select name="ddlEvent">
                            <?php
                            $allEvent = getAllEvent($event);
                            foreach ($allEvent as $key => $value) {
                                printf("<option value='%s' %s>
                                        %s</option>",$key,
                                        ($event==$key)?'selected':"",
                                        $value);
                            }
                            ?>
                            
                        </select></td>
                </tr>
                
                <tr>
                    <td>Categories: </td>
                    <td><select name="ddlCategories">
                            <?php
                            $allCategories = getAllCategories($categories);
                            foreach ($allCategories as $key => $value) {
                                printf("<option value='%s' %s>
                                        %s</option>",$key,
                                        ($categories==$key)?'selected':"",
                                        $value);
                            }
                            ?>
                            
                        </select></td>
                </tr>
                
                <tr>
                    <td>Star-rated: </td>
                    <td>
                        <?php
                                $allStarRate= getAllStarRate($star);
                                foreach($allStarRate as $key => $value){
                                    printf("<input type='radio'
                               name='rbStar'
                               value='%s' %s />%s",$key,
                                            ($star==$key)?'checked':"",
                                            $value);
                                }
                        ?>
                    </td>
                </tr>
                
            </table>
            
            
        
        <div class='hldesign'>
        <input type="submit" 
                   value="Update" 
                   name="btnUpdate" />
            <input type="button" 
                   value="Cancel" 
                   name="btnCancel" 
                   onclick="location = 'feedback-2.php'"/></div>
            </form>
        <?php
        include 'footer-2.php';
        ?>
        <?php endif;?>
    </body>
</html>