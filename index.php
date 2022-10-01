
<?php
session_start();
//import config & connect db
require 'config.php';
require 'connectDB.php';
//import models

require 'model/Student.php';
require 'model/StudentRepository.php';
require 'model/Subject.php';
require 'model/SubjectRepository.php';

require 'model/Register.php';
require 'model/RegisterRepository.php';

//điều hướng đến controller cụ thể dựa vào tham số trên đường dẫn web
$c = $_GET['c'] ?? 'student';
$a = $_GET['a'] ?? 'index';
 $controller = ucfirst($c) . 'controller'; //StudentController
 // import controller vào hệ thống
 require "controller/$controller.php";//require "controller/StudentController.php"
 $controller = new $controller();//new StudentController();
 $controller->$a();//%controller->index();
?>