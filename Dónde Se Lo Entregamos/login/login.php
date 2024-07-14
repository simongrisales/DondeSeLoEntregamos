<?php
    include("conexion.php");

    $user=$_POST["usuario"];
    $pass=$_POST["contrasena"];

    $user=mysqli_query($conexion,"select * from empleados where cedula='$user' && contrasena='$pass' ");

    if(mysqli_num_rows($user)>0){
        header("Location: admin.php");
    }else{
        header("Location: login.html");
    }
?>