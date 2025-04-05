<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
define('DB_HOST', "localhost");
define('DB_USER', "root");
define('DB_PASS', "");
define('DB_NAME', "liyi");

function checkStudentID($id){
    if($id == null){
        return "Please enter your <b>STUDENT ID</b>!";
    }else if(preg_match('/^[0-9]{2}[A-Z][3]\d{5}$/',$id)){
        return "Invalid <b>STUDENT ID</b>format!";
        
    }else if(studentIDExist($id)){
        return "Duplicated <b>STUDENT ID</b>detected!"; 
    }
}
function checkStudentName($name){
    if($name==null){
        return"Please enter your name!";
    }else if(!preg_match("/^[A-Z a-z@,\"\-\.\/]+$/", $name)){
        return"Invalid student name!";
    }else if(strlen($name)>30){
        return"You can type to maximum 30 characters";
    }
} 
function checkEvent($event){
    if($event==null){
        return("Please select your event!");
    }else if(!array_key_exists($event, getAllEvent($event))){
        return"Invalid Event detected!";
    }
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
function getAllEvent($event){
    return array(
        "🎳Bowling" => "🎳Bowling",
        "🏀Basketball" => "🏀Basketball",
        "🏃️Running" => "🏃️Running",
        "🤸Gym" => "️🤸Gym",
        );
}

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