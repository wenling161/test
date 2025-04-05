<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
//4 parameters to connect php app with db
//1. hostname, 2. user name, 3. password 4. db name
define('DB_HOST', "localhost");
define('DB_USER', "root");
define('DB_PASS', "");
define('DB_NAME', "liyi");


//validation function here
//check gender
function validateGender($gender){
    if($gender == NULL){
        return"Please select a <b>Gender</b>!";
    }else if(!array_key_exists($gender, getAllGender())){
        return"Invalid Gender Selected!";
    }
}
//check student name
function validateStudentName($name){
    if($name == NULL){
        return"Please enter your <b>Name</b>!";
    }else if(!preg_match("/^[A-Z a-z@,\"\-\.\/]+$/", $name)){
        return "Invalid <b>Student Name</b>!";
    }else if(strlen($name)>30){
        return"Maximum <b>30</b> character only!";
    }
}
//check student ID........................................
function validateStudentID($stud_id){
    if($stud_id == NULL){
        return"Please enter your <b>Student ID</b>!";
    }else if(!preg_match('/^[0-9]{2}[A-Z]{3}\d{5}$/', $stud_id)){
        return"Invalid <b>Student ID</b> format!";
    }else if(studentIDExist($stud_id)){
        return"Duplicated <b>STUDENT ID</b> detected!";
    }
}
//check student ID........................................
function validateEditStudentID($stud_id){
    if($stud_id == NULL){
        return"Please enter your <b>Student ID</b>!";
    }else if(!preg_match('/^[0-9]{2}[A-Z]{3}\d{5}$/', $stud_id)){
        return"Invalid <b>Student ID</b> format!";
    }
}

function validateStudentIDPay($stud_id){
    if($stud_id == NULL){
        return"Please enter your <b>Student ID</b>!";
    }else if(!preg_match('/^[0-9]{2}[A-Z]{3}\d{5}$/', $stud_id)){
        return"Invalid <b>Student ID</b> format!";
    }
}

//check student Phone Number........................................
function validatePhoneNumber($contact){
    if($contact == NULL){
        return"Please enter your <b>Phone Number</b>!";
    }else if(!preg_match('/^[0-9]{9,14}$/', $contact)){
        return"Invalid <b>Phone Number</b> format, minimum 9 numbers and maximum 14 numbers!";
    }else if(phoneNumExist($contact)){
        return"Duplicated <b>Phone Number</b> detected!";
    }
}
//check student Edit Phone Number........................................
function validateEditPhoneNumber($contact){
    if($contact == NULL){
        return"Please enter your <b>Phone Number</b>!";
    }else if(!preg_match('/^[0-9]{9,14}$/', $contact)){
        return"Invalid <b>Phone Number</b> format!";
    }
}
//check student ID........................................
function validatePassword($password){
    if($password == NULL){
        return"Please enter your <b>Password</b>!";
    }else if(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{10,}$/', $password)){
        return"Invalid <b>Password</b> format, must more than 10 characters and include upperchase and lowerchase character and also numbers!";
    }
}


//check duplicated PK
function studentIDExist($id){
    $exist = false;
    //STEP 1 : connect PHP app with DB
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    //STEP 2: sql statement
    //$sql = "SELECT * From Student WHERE StudentID = 22PMD12345";
    $sql = "SELECT * From Member WHERE studentid = '$id'";
    
    //STEP 3: run sql statement
    if($result = $con->query($sql)){
        if($result->num_rows > 0){
            //record found! SAME PK
            $exist = true;
        }
    }
        //STEP 4: close connection, free $result
    $result->free();
    $con->close();
    return $exist;
}

function studentIDPay($id){
    $exist = false;
    //STEP 1 : connect PHP app with DB
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    //STEP 2: sql statement
    //$sql = "SELECT * From Student WHERE StudentID = 22PMD12345";
    $sql = "SELECT * From Payment WHERE studentid = '$id'";
    
    //STEP 3: run sql statement
    if($result = $con->query($sql)){
        if($result->num_rows > 0){
            //record found! SAME PK
            $exist = true;
        }
    }
        //STEP 4: close connection, free $result
    $result->free();
    $con->close();
    return $exist;
}

 function phoneNumExist($phonenum){
    $exist = false;
    //STEP 1 : connect PHP app with DB
    $con = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    //STEP 2: sql statement
    //$sql = "SELECT * From Student WHERE StudentID = 22PMD12345";
    $sql = "SELECT * From Member WHERE phonenumber = '$phonenum'";
    
    //STEP 3: run sql statement
    if($result = $con->query($sql)){
        if($result->num_rows > 0){
            //record found! SAME PK
            $exist = true;
        }
    }
    
    //STEP 4: close connection, free $result
    $result->free();
    $con->close();
    return $exist;
}

function generatePaymentId() {
    $prefix = 'P';
    $random = mt_rand(100000, 999999);
    return $prefix . $random;
  }


function getAllGender(){
    return array(
        "M" => "Male",
        "F" => "Female");
}

function getAllProgram(){
    return array(
        "FT" => "Diploma in Information Technology",
        "CS" => "Diploma in Computer Science",
        "IS" => "Diploma in Information Systems");
}
