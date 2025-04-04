<?php
require "../db.php";
session_start();
if(isset($_GET['id'])){
   $id = intval($_GET['id']);

   $stmt =$conn->prepare("DELETE FROM user_deatils WHERE id = ?");
   $stmt->bind_param("i", $id);
   

   if($stmt->execute()){
        $_SESSION['success'] = "The member has been deleted  successfully";
        $stmt->close();
        $conn->close();
        header("Location: http://localhost:8888/Access_control/member.php");
        exit();
   }else{
         $_SESSION['error'] = "Error deleting member";
        $stmt->close();
        $conn->close();
        header("Location: http://localhost:8888/Access_control/member.php");
        exit();
   }
   
}else{
        $_SESSION['error'] = "Member id not found ";
        header("Location: http://localhost:8888/Access_control/member.php");
        exit();
}


?>