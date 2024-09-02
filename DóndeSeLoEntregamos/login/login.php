<?php
    include("../config.php");
    session_start();

    $userID=$_POST["userID"];
    $password=$_POST["password"];

    $password=hash('sha512',$password);
    //Comparamos la contraseña ingresada
    //Con la de la base de datos

    $result=mysqli_query($link,"select name, lastname from users where userID='$userID' && password='$password'");

    $userRecord = mysqli_fetch_array($result);

    if(mysqli_num_rows($result)>0){
        $_SESSION['role'] = ["client"];
        $_SESSION['fullname'] = $userRecord["name"] . " " . $userRecord["lastname"];
        header("Location: locker.php");
    }else{
        header("Location: login.html");
    }
?>
