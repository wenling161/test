<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html lang="en" dir="" ltr>

    <head>
        <meta charset="UTF-8">
        <title>Admin Add Event</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="Css/event-admin.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    </head>

    <body>
         <h1>Add Event</h1>
        <?php
        //check if user select any file?
        if (isset($_FILES['fsImage'])) {
            //YES, user selected a file
            //store the image
            $file = $_FILES['fsImage'];
            //check if there is any upload error?
            if ($file['error'] > 0) {
                //WITH ERROR, handle to display error msg
                switch ($file['error']) {
                    case UPLOAD_ERR_NO_FILE:
                        $err = "<p class= 'fontCenter'>No file was selected!</p>";
                        break;
                    case UPLOAD_ERR_FORM_SIZE:
                        $err = "<p class= 'fontCenter'>File uploaded is too large. Maximum 1MB allowed!</p>";
                        break;
                    default://other error
                        $err = "<p class= 'fontCenter'>There was an error when uploading the file!</p>";
                        break;
                }
            } else if ($file['size'] > 1048576) {
                //Validate specifically, file size
                //1MB = 1024 x 1024
                $err = "<p class= 'fontCenter'>File uploaded is too large. Max 1MB allowed!</p>";
            } else {
                //extract file extension, eg: png, jpg, gif
                $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

                //check file extension
                if ($ext != 'jpg' && $ext != 'jpeg' && $ext != 'gif' && $ext != 'png') {
                    $err = "<p class= 'fontCenter'>Only PJG, JPEG, GIF and PNG images are allowed</p>";
                } else {
                    //everything okey, save the file
                    //create a unique id and use it as file name
                    //eg: asfvb2345.png
                    //2 methods:
                    //1. store image into db using BLOB
                    //2. store img URL (STRING) in DB, file remian in the server
                    $newFileName = uniqid() . '.' . $ext;

                    //save the file
                    move_uploaded_file($file['tmp_name'], 'image/' . $newFileName);
                }
            }
            if (isset($err)) {
                echo "<p class= 'fontCenter'>$err</p>";
            }
        }
        ?>
        
        <?php
        include 'AdminNav.php';
        ?>
         
        <?php
        include './config/helper.php';
        global $eventID;
        global $eventName;
        global $eventDesc;
        global $eventTime;
        global $eventDate;
        global $eventPrice;
        global $eventLocation;
        global $newFileName;
        if (!empty($_POST)) {
            //user click add button,retrieve user input
            (isset($_POST["txtEventID"])) ?
                            $eventID = trim($_POST["txtEventID"]) :
                            $eventID = "";
            (isset($_POST["txtEventName"])) ?
                            $eventName = trim($_POST["txtEventName"]) :
                            $eventName = "";
            (isset($_POST["txtEventDesc"])) ?
                            $eventDesc = trim($_POST["txtEventDesc"]) :
                            $eventDesc = "";
            (isset($_POST["txtEventTime"])) ?
                            $eventTime = trim($_POST["txtEventTime"]) :
                            $eventTime = "";
            (isset($_POST["txtEventDate"])) ?
                            $eventDate = trim($_POST["txtEventDate"]) :
                            $eventDate = "";
            (isset($_POST["txtEventPrice"])) ?
                            $eventPrice = trim($_POST["txtEventPrice"]) :
                            $eventPrice = "";
            (isset($_POST["txtEventLocation"])) ?
                            $eventLocation = trim($_POST["txtEventLocation"]) :
                            $eventLocation = "";

            //check error
            
            $error["eventName"] = checkEventName($eventName);
            $error["eventDesc"] = checkEventDesc($eventDesc);
            $error["eventTime"] = checkEventTime($eventTime);
            $error["eventDate"] = checkEventDate($eventDate);
            $error["eventPrice"] = checkEventPrice($eventPrice);
            $error["eventLocation"] = checkEventLocation($eventLocation);
            $error["eventPicture"] = checkEventPicture($newFileName);
            $error = array_filter($error);

            if (empty($error)) {
                //no error, add event
                $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
                
               $sql1 = "SELECT MAX(event_id) FROM event";
               $result = $con->query($sql1);
               $idrow = $result->fetch_row();
               $max_id = $idrow[0];
               $new_id = $max_id + 1;
                
                $sql = "INSERT INTO event (event_id,event_name,event_description,event_price,location,event_date,event_time,event_picture) VALUES(?,?,?,?,?,?,?,?)";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssssssss", $new_id,$eventName, $eventDesc, $eventPrice, $eventLocation, $eventDate, $eventTime,$newFileName);
                $stmt->execute();
                if ($stmt->affected_rows > 0) {
                    //INSERT Successful
                    printf("<p class= 'fontCenter'>
                               %s has been added.
                               <a href='event-admin.php'>
                               Back to list</a></p>", $eventName);
                } else {
                    echo'<p class= "fontCenter">Unable to insert!
                   [<a href="event-admin.php">Back to list</a></p>]';
                }
            } else {
                //with error
                echo"<p class= 'fontCenter'>";
                foreach ($error as $value) {
                    echo"<p class= 'fontCenter'>$value</p>";
                }
                echo"<p class= 'fontCenter'>";
            }
        }
        ?>
        
        <form action = "" method = "POST" enctype="multipart/form-data">
            <table>
                <tr>
                    <th>Event name: </th>
                    <td><input type = "text"
                               name = "txtEventName"
                               value = "<?php echo $eventName; ?>" /></td>
                </tr>

                <tr>
                    <th>Event description : </th>
                    <td><input type = "text"
                               name = "txtEventDesc"
                               value = "<?php echo $eventDesc ?>" /></td>
                </tr>

                <tr>
                    <th>Event price : </th>
                    <td><input type = "text"
                               name = "txtEventPrice"
                               value = "<?php echo $eventPrice ?>" /></td>
                </tr>

                <tr>
                    <th>Event location : </th>
                    <td><input type = "text"
                               name = "txtEventLocation"
                               value = "<?php echo $eventLocation ?>" /></td>
                </tr>

                <tr>
                    <th>Event date : </th>
                    <td><input type = "date"
                               name = "txtEventDate"
                               value = "<?php echo $eventDate ?>" /></td>
                </tr>

                <tr>
                    <th>Event time : </th>
                    <td><input type = "text"
                               name = "txtEventTime"
                               value = "<?php echo $eventTime ?>" /></td>
                </tr>
                
                <tr>
                <th>Event picture</th>
                <td><input type="file" name="fsImage" />
                <input type="hidden" name="MAX_FILE_SIZE" value="1048576" />
                </td>
                </tr>
            </table>
            <div>
            <input type = "submit"value = "Insert"name = "btnInsert" class="addEvtBtn"/>
            <input type = "button"value = "Cancel"name = "btnCancel"onclick = "location = 'event-admin.php'"class="addEvtBtnn"/>
            </div>
        </form>


    </body>

</html>