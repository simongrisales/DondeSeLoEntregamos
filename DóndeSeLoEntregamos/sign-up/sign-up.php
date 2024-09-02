<?php
    include('../config.php');

    $userID=$_POST["userID"];
    $name=$_POST["name"];
    $lastname=$_POST["lastname"];
    $email=$_POST["email"];
    $phone=$_POST["phone"];
    $password=$_POST["password"];
    $roleID=["client"];

    $password=hash('sha512',$password);
    //Contraseña encriptada

    mysqli_query($link,"INSERT INTO users (userID,name,lastname,email,phone,password,roleID) values($userID,'$name','$lastname','$email','$phone',$password,'$roleID')")or die("Problemas al insertar".mysqli_error($link));

    echo "<script>alert('Se guardaron los datos correctamente')</script>";

    header("Location: ../login/login.html");
?>