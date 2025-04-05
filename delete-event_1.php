<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Delete Event</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Css/event-admin.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>
    <body>
        <?php
        include 'AdminNav.php';
        require_once './config/helper.php';
        ?>
        
        <h1>Delete Event</h1>
        
        <?php
        if($_SERVER["REQUEST_METHOD"]=="GET"){
            //get method, retreive record to display
            (isset($_GET["id"]))?
            $eventID= strtoupper(trim($_GET["id"])):
            $eventID="";
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            $sql = "SELECT *FROM event WHERE event_id = '$eventID'";
            $result = $con->query($sql);
            if($record = $result->fetch_object()){
                //record found
                $eventID=$record->event_id;
                $eventName=$record->event_name;
                $eventDesc=$record->event_description;
                $eventDate=$record->event_date;
                $eventTime=$record->event_time;
                $eventLocation=$record->location;
                $eventPrice=$record->event_price;
                $newFileName=$record->event_picture;
                printf("<p class= 'fontCenter'>Are you sure you want to delete the following event?</p>
                    <table class='eventList'>
                        <tr>
                        <td class='tableDesign'>Event ID : </td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td class='tableDesign'>Event name : </td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td class='tableDesign'>Picture : </td>
                        <td><img src='image/%s' alt='%s' width='100'></td>
                        </tr>
                        <tr>
                        <td class='tableDesign'>Description : </td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td class='tableDesign'>Date : </td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td class='tableDesign'>Time : </td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td class='tableDesign'>Location : </td>
                        <td>%s</td>
                        </tr>
                        <tr>
                        <td class='tableDesign'>Price : </td>
                        <td>%s</td>
                        </tr>
                    </table>
                    
                    <form action='' method='POST'>
                    <input type='hidden' name='txtEventID' value='%s'>
                    <input type='hidden' name='txtEventName' value='%s'>
                    <input type='hidden' name='txtEventDesc' value='%s'>
                    <input type='hidden' name='txtEventTime' value='%s'>
                    <input type='hidden' name='txtEventLocation' value='%s'>
                    <input type='hidden' name='txtEventPrice' value='%s'>
                    <input type='submit' value='Delete' name='btnDelete' class='dltEventBtn'/>
                    <input type='button' value='Cancel' name='btnCancel' class='dltEventBtnn' onclick ='location=\"event-admin.php\"' />
                    </form>
                ",$eventID,$eventName,$newFileName,$newFileName,$eventDesc,$eventDate,$eventTime,$eventLocation,$eventPrice,$eventID,$eventName,$eventDesc,$eventTime,$eventLocation,$eventPrice);
            }else{
                //record not found
                echo '<div class= "fontCenter">Unable to find the record <a href="event-admin.php">Back to event list</a></div>';
            }
        }else{
            //post method, delete record
            $eventID = strtoupper(trim($_POST["txtEventID"]));
            $eventName = strtoupper(trim($_POST["txtEventName"]));
            $eventDesc = trim($_POST["txtEventDesc"]);
            $eventTime = trim($_POST["txtEventTime"]);
            $eventLocation = trim($_POST["txtEventLocation"]);
            $eventPrice = trim($_POST["txtEventPrice"]);
            
            $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
            
            $sql = "DELETE FROM event WHERE event_id = ?";
            
            $stmt = $con->prepare($sql);
            
            $stmt ->bind_param('s', $eventID);
            
            if($stmt->execute()){
                //deleted
                printf("<div class= 'fontCenter'>%s has been deleted. <a href ='event-admin.php'>Back to event list</a></div>",$eventName);
            }else{
                //unable to delete
                echo '<div class= "fontCenter">Unable to delete. <a href ="event-admin.php">Back to event list</a></div>';
            }
            $con->close();
            $stmt->close();
        }
        ?>
    </body>
</html>
