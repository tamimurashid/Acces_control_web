<?php 
session_start();
require "../db.php";


    $query = "SELECT COUNT(*) AS total_members  FROM user_deatils ";

    $result  = mysqli_query($conn, $result);








?>