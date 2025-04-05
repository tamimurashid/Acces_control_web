<?php
require "../db.php";
session_start();
if(isset($_GET['id'])){
   $id = intval($_GET['id']);

   $stmt =$conn->prepare("DELETE FROM user_deatils WHERE id = ?");
   $stmt->bind_param("i", $id);
   

   if($stmt->execute()){
        $_SESSION['success'] = "New member has been registered, to return the system to authentication mode click here  ";
        header("Location: http://localhost:8888/Access_control/register.php");
        exit();
   }


}



?>