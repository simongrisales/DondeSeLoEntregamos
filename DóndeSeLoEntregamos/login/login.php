<?php
    include("conexion.php");

    $user=$_POST["usuarioID"];
    $pass=$_POST["password"];

    $user=mysqli_query($conexion,"select * from usuarios where usuarioID='$user' && password='$password' ");

    if(mysqli_num_rows($user)>0){
        header("Location: admin.php");
    }else{
        header("Location: login.html");
    }
?>