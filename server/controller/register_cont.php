<?php
require  "../db.php";
// require "../../Api/index.php";

session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
$userpatterns = '/^[A-Za-z]+(?:\s[A-Za-z]+)*$/';
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['submit'])){
        $firstname = isset($_POST['firstname']) ? mysqli_real_escape_string($conn, $_POST['firstname']) : null; 
        $secondname = isset($_POST['secondname']) ? mysqli_real_escape_string($conn, $_POST['secondname']): null;
        $lastname = isset($_POST['lastname']) ? mysqli_real_escape_string($conn, $_POST['lastname']): null;
        $age = isset($_POST['age']) ? mysqli_real_escape_string($conn, $_POST['age']):null;
        $phone = isset($_POST['phone']) ? mysqli_real_escape_string($conn, $_POST['phone']):null ;
        $email = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']): null ;
        $position = isset($_POST['position']) ? mysqli_real_escape_string($conn, $_POST['position']):null;

        $cardId = isset($_POST['cardId']) ? mysqli_real_escape_string($conn, $_POST['cardId']):null;

        //validation 

        if($firstname && !preg_match($userpatterns, trim($firstname))){
            $_SESSION['error'] = "first name should contain only letters.";
            header("Location: ../register.php");
            exit();
        } else if($secondname &&  !preg_match($userpatterns, trim($secondname))){
            $_SESSION['error'] = "Second  name  should contain only letters.";
            header("Location: ../register.php");
            exit();
        }

        else if($lastname &&  !preg_match($userpatterns, trim($lastname))){
            $_SESSION['error'] = "Last name  should contain only letters.";
            header("Location: ../register.php");
            exit();
        }

        if(!isset($_SESSION['error'])){
            $query = "INSERT INTO user_deatils (firstname, secondname, lastname, phone, email, age, position, card_id) VALUES ('$firstname', '$secondname', '$lastname', '$phone', '$email', '$age', '$position', '$cardId')";

            $run  = mysqli_query($conn, $query);
            if($run){
               $_SESSION['success'] = "Data inserted successfully ";
               header("Location: .././register.php");
               exit(); 
            }else{
                echo "data was unable to be inseterd .";

            }
        }





    }
}