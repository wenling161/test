<?php
session_start(); // start the session

// check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
  // if not, redirect them to the login page
  header('Location: login-form-2.php');
  exit();
}
?>
<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html lang="en" dir="" ltr>

<head>
    <meta charset="UTF-8">
    <title>Admin Adit Event</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="Css/event-admin.css" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>

<body>
    <?php include 'AdminNav.php';
    require_once './config/helper.php';?>
    <h1>Edit Event</h1>
    <?php
    global $hideForm;
    global $eventID;
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        //get method
        //retrieve record and display data in the form
        //retrieve event name from URL
        (isset($_GET["id"]))?
        $eventID = strtoupper(trim($_GET["id"])):
        $eventID ="";
        //step 1 : connection
        $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
        //step 2 : sql statement
        $sql = "SELECT * FROM event WHERE event_id = '$eventID'";
        //step 3 : run sql
        $result = $con->query($sql);
        
        if($record = $result->fetch_object()){
            //record found
            $eventID = $record->event_id;
            $eventName = $record->event_name;
            $eventDesc = $record->event_description;
            $eventPrice = $record->event_price;
            $eventLocation = $record->location;
            $eventDate = $record->event_date;
            $eventTime = $record->event_time;
        }else{
            //record not found
            echo"<p class= 'fontCenter'>Unable to retrieve record.
            <a href='event-admin.php'>Back to event list</a></p>";
            $hideForm = true;
        }
        $result->free();
        $con->close();
    }else{
        //post method
        $eventID = strtoupper(trim($_POST["txtEventID"]));
        $eventName = trim($_POST["txtEventName"]);
        $eventDesc = trim($_POST["txtEventDesc"]);
        $eventTime = trim($_POST["txtEventTime"]);
        $eventDate = trim($_POST["txtEventDate"]);
        $eventPrice = trim($_POST["txtEventPrice"]);
        $eventLocation = trim($_POST["txtEventLocation"]);
        
        $error["eventDesc"] = checkEventDesc($eventDesc);
        $error["eventTime"] = checkEventTime($eventTime);
        $error["eventDate"] = checkEventDate($eventDate);
        $error["eventPrice"] = checkEventPrice($eventPrice);
        $error["eventLocation"] = checkEventLocation($eventLocation);
        $error = array_filter($error);
        if(empty($error)){
            //no error
            //step 1 : connect
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            //step 2 :
            $sql = "UPDATE event SET event_name = ?,event_description = ?,event_time = ?,event_date = ?,event_price = ?,location = ? WHERE event_id = ?";
            $statement = $con->prepare($sql);
            $statement->bind_param("sssssss", $eventName,$eventDesc,$eventTime,$eventDate,$eventPrice,$eventLocation,$eventID);
            if($statement->execute()){
                //update
                printf("<p class= 'fontCenter'>Successfully edit event information.<a href='event-admin.php'>Back to event list</a></p>",$eventName);
            }else{
                //fail to update
                echo"<p class= 'fontCenter'>Unable to edit.<a href='event-admin.php'>Back to event list</a></p>";
            }
        }else{
            //got error
            echo"<ul>";
            foreach ($error as $value){
                echo"<li>$value</li>";
            }
            echo"</ul>";
            //update record
        }
    }
    ?>
    
    <?php if($hideForm == false) : ?>
    
    <form action="" method="POST">
        <div class="table"> 
            <table>
                <tr>
                    <td class='tableDesign'>Event ID : </td>
                    <td><?php echo $eventID;?>
                        <input type="hidden" name="txtEventID"
                               value="<?php echo $eventID?>"/>
                    </td>
                </tr>
                <tr>
                    <td class='tableDesign'>Event Name : </td>
                    <td>
                        <input type="text" name="txtEventName"
                               value="<?php echo $eventName?>"/>
                    </td>
                </tr>
                
                <tr>
                    <td class='tableDesign'>Description : </td>
                    <td><input type="text" name="txtEventDesc" value="<?php echo $eventDesc?>"/></td>
                </tr>
                
                <tr>
                    <td class='tableDesign'>Date : </td>
                    <td><input type = "date" name = "txtEventDate" value = "<?php echo $eventDate?>" /></td>
                </tr>
                
                <tr>
                    <td class='tableDesign'>Time : </td>
                    <td><input type="text" name="txtEventTime" value = "<?php echo $eventTime?>"/></td>
                </tr>
                
                <tr>
                    <td class='tableDesign'>Price : </td>
                    <td><input type = "text" name = "txtEventPrice" value = "<?php echo $eventPrice?>" /></td>
                </tr>
                
                <tr>
                    <td class='tableDesign'>Location : </td>
                    <td><input type = "text" name = "txtEventLocation" value = "<?php echo $eventLocation?>" /></td>
                </tr>
            </table>
            <input type="submit" 
                   value="Update" 
                   name="btnUpdate"
                   class="edtEventBtn"/>
            <input type="button" 
                   value="Cancel" 
                   name="btnCancel" 
                   onclick="location = 'event-admin.php'"
                   class="edtEventBtnn"/>
    </form>
    <?php endif;?>
</body>
</html>