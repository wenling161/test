<link href="../Css/event-admin.css" rel="stylesheet" type="text/css"/>
<?php

    define('DB_HOST', "localhost");
    define('DB_USER', "root");
    define('DB_PASS', "");
    define('DB_NAME', "liyi");
    
    
//event------------------------------------------------------------

function checkEventName($eventName) {
    if($eventName==null){
        return("<p class= 'fontCenter'>Please enter event name.</p>");
    } else if (preg_match('/\d/', $eventName)) {
        return "<p class= 'fontCenter'>Event name should not contain numbers.</p>";
    }else if(eventNameExist($eventName)){
        return "<p class= 'fontCenter'>Duplicated <b>Event name </b>detected!</p>"; 
    }
}

function checkEventDesc($eventDesc){
    if($eventDesc == null){
        return "<p class= 'fontCenter'>Please enter event description.</p>";
    }
}

function checkEventTime($eventTime){
    if($eventTime == null){
        return "<p class= 'fontCenter'>Please enter event time</p>";
    }
}

function checkEventDate($eventDate){
    if($eventDate == null){
        return "<p class= 'fontCenter'>Please select event date.</p>";
    }
}

function checkEventPrice($eventPrice){
    if($eventPrice == null){
        return "<p class= 'fontCenter'>Please enter event price.</p>";
    }else if(!is_numeric($eventPrice) && !preg_match("/^\d+(\.\d{1,2})?$/", $eventPrice)){
        return "<p class= 'fontCenter'>Event price should be a numeric or decimal value.</p>";
    }
}

function checkEventLocation($eventLocation){
    if($eventLocation == null){
        return "<p class= 'fontCenter'>Please enter location.</p>";
    }
}

function eventNameExist($event){
    $exist = false;
    
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    $event  = $con->real_escape_string($event);
    $sql = "SELECT * FROM event WHERE event_name = '$event'";
    
    if($result = $con->query($sql))
    {
        if($result->num_rows>0){
            $exist = true;
        }
    }
    
    $result->free();
    $con->close();
    
    return $exist;
}
function checkEventPicture($newFileName){
    if($newFileName == null){
        return "<p class= 'fontCenter'>Please select event picture.</p>";
    }
}

//staff---------------------------------------------------------------

function checkStaffID($staffID){
    if($staffID == null){
        return "<p class= 'fontCenter'>Please enter your <b>Staff ID</b>.</p>";
    }else if(studentIDExist($staffID)){
        return "<p class= 'fontCenter'>Duplicated <b>Staff ID</b> detected.</p>"; 
    }
}

function studentIDExist($staffID){
    $exist = false;
    
    //STEP 1: connect PHP app with DB
    $con = new mysqli(DB_HOST,DB_USER,DB_PASS,DB_NAME);
    
    //STEP 2: sql statement
    // wrong $sql = "SELECT * FROM Student WHERE Student ID = 22PMD12345";
    $sql = "SELECT * FROM staff WHERE StaffID = '$staffID'";
    
    //STEP 3: run sql statement
    if($result = $con->query($sql)){
        if($result->num_rows >0){
            //reocrd found!SAME PK
            $exist = true;
        }
    }
    
    //STEP 4: close connection, free $result
    $result->free();
    $con->close();
    return $exist;
}

function checkStaffName($staffName){
    if($staffName==null){
        return"<p class= 'fontCenter'>Please enter staff name.</p>";
    }else if(!preg_match("/^[A-Z a-z@,\"\-\.\/]+$/", $staffName)){
        return"<p class= 'fontCenter'>Invalid student name!</p>";
    }else if(strlen($staffName)>30){
        return"<p class= 'fontCenter'>You can type to maximum 30 characters. </p>";
    }
}

function checkPH($staffPH){
    if($staffPH == null){
        return "<p class= 'fontCenter'>Please enter your <b>phone number.</b>.</p>";
    } else if (!preg_match('/^[0-9\-]+$/', $staffPH)) {
        return "<p class= 'fontCenter'>Please enter a valid phone number.</p>";
    }
}

function checkEmail($staffEmail){
    if($staffEmail == null){
        return "<p class= 'fontCenter'>Please enter your <b>Email</b>.</p>";
    }
}

function checkGender($staffGender){
    if($staffGender==null){
        return"<p class= 'fontCenter'>Please select your gender.</p>";
    }
}
function checkPass($staffPass){
    if($staffPass==null){
        return"<p class= 'fontCenter'>Please enter your password.</p>";
    }
}
function getAllGender(){
    return array(
        "M" => "👦Male",
        "F" => "👧Female");
}
?>