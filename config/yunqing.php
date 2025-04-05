<?php

/*
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
 */

//4 parameters to connect php app with db
//1.hostname, 2.user name, 3.password, 4.db name

define('DB_HOST', "localhost");
define('DB_USER', "root");
define('DB_PASS', "");
define('DB_NAME', "liyi");

//validaiton function
function validationVolunteerForm() {
    if (isset($_POST['btnSubmit'])) {
        $studCourse = trim($_POST['sub']);
        $studEmail = trim($_POST['email']);
        $studPNumber = trim($_POST['phoneNumber']);
        $studGen = trim($_POST['gender']);
        $studID = trim($_POST['id']);
        $studName = trim($_POST['name']);
        
        $error = array();
    }
}

//check course
function checkCourse($course) {
    if ($course == null) {
        return "Please select your <b>Course</b>!";
    }else if(!array_key_exists($course, getAllCourse())){
        return "Invalid course detected";
    }
}

//check gender
function checkStudentGender($gender) {
    if ($gender == null) {
        return "Please select your <b>Gender</b>!";
    } else if (!array_key_exists($gender, getAllGender())) {
        return "Invalid Gender Identified!";
    }
}

//check student name
function checkStudentName($name) {
    if ($name == null) {
        return "Please enter your <b>NAME</b>!";
    } else if (!preg_match("/[a-zA-Z]+[a-zA-Z]+[a-zA-Z]$/", $name)) {
        return "Invalid Student Name!";
    } else if (strlen($name) > 30) {
        return "You name too long. Only 30 characters only";
    }
}

//check student ID
function checkStudentID($id) {
    if ($id == null) {
        return "Please enter your <b>Student ID</b>!";
    } else if (!preg_match('/^[0-9]{2}[A-Z]{3}\d{5}$/', $id)) {
        return "Invalid <b>STUDENT ID</b> format!";
    } else if (studentIDExist($id)) {
        return "Duplicated <b>STUDENT ID</b> detected!";
    }
}

//check student email
function checkStudentEmail($email) {
    if ($email == null) {
        return "Please enter your <b>Email</b>!";
    } else if (!preg_match('/[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$/', $email)) {
        return "Invalid <b>EMAIL</b> format!";
    }
}

//check student phone number
function checkStudentPNumber($pnumber) {
    if ($pnumber == null) {
        return "Please enter your <b>Phone Number</b>!";
    } else if (!preg_match('/^01[0-46-9]-*[0-9]{7,8}$/', $pnumber)) {   
        return "Invalid <b>PHONE NUMBER</b> format!";
    }
}

//check student join event
function checkStudentEvent($event){
    if ($event == null) {
        return "Please select your <b>Event</b>!";
    }else if(!array_key_exists($event, getAllEvent())){
        return "Invalid event detected";
    }
}

//check duplicated PK
function studentIDExist($id) {
    //step 1: connect php all with DB
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);

    //step 2: sql statement
    $sql = "SELECT * FROM Student WHERE StudentID = '$id'";

    //step 3: run sql  statement
    if ($result = $con->query($sql)) {
        if ($result->num_rows > 0) {
            //record found! same PK
            $exist = true;
        }
    }

    //step 4: close connection, free $result
    $result->free();
    $con->close();
//    return $exist;
}

function getAllGender() {
    return array(
        "M" => "👦Male",
        "F" => "👧Female");
}

function getAllCourse(){
    return array(
        "FT" => "Diploma in Information Technology",
        "CS" => "Diploma in Computer Science",
        "IS" => "Diploma in Information Systems",
        "IB" => "Diploma in International Business",
        "HR" => "Diploma in Human Recource Management",
        "AC" => "Diploma in Accounting"
    );
}

function getAllEvent(){
    return array(
      "BB" => "Basketball Event",
      "BL" => "Bowling Event",
      "GM" => "Gym Event",
      "RN" => "Running Event"
    );
}

function checkCategories($categories){
    if($categories==null){
        return("Please select your categories!");
    }else if(!array_key_exists($categories, getAllCategories($categories))){
        return"Invalid categories detected!";
    }
}
function checkStar($star){
    if($star==null){
        return"Please select your star rate!";
    }else if(!array_key_exists($star, getAllStarRate($star))){
        return"Invalid star rate identified!";
    }
}
//function getAllEvent($event){
//    return array(
//        "🎳Bowling" => "🎳Bowling",
//        "🏀Basketball" => "🏀Basketball",
//        "🏃️Running" => "🏃️Running",
//        "🤸Gym" => "️🤸Gym",
//        );
//}

function getAllCategories($categories){
    return array(
        "Worker Attitude(Customer Service)" => "Worker Attitude(Customer Service)",
        "Worker Responsive(Customer Service)" => "Worker Responsive(Customer Service)",
        "Problem Resolution(Customer Service)" => "Problem Resolution(Customer Service)",    
        "Availability(Customer Service)" => "Availability(Customer Service)",    
        "Registration Process(Organisation)" => "Registration Process(Organisation)",    
        "Communication(Organisation)" => "Communication(Organisation)",    
        "Scheduling(Organisation)" => "Scheduling(Organisation)",    
        "Value of Cost" => "Value of Cost",    
        "Overall Experience" => "Overall Experience",    
    );

}
function getAllStarRate(){
    return array(
        1 => 1,
        2 => 2,
        3 => 3,
        4 => 4,
        5 => 5,
        );
}