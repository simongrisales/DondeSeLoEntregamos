<?php
    include('conexion.php');
    $nombre_img=$_FILES['foto']['name'];
    $tipo_img=$_FILES['foto']['type'];
    $tam_img=$_FILES['foto']['size'];

    if ($tam_img<=1000000) {
        if ($tipo_img=="image/jpg" || $tipo_img=="image/jpeg" || $tipo_img=="image/png" || $tipo_img=="image/gif") {
            $carpeta=$_SERVER['DOCUMENT_ROOT'].'/Dónde se lo entregamos/imagenes/';

            move_uploaded_file($_FILES['foto']['tmp_name'], $carpeta.$nombre_img);
            //echo "Se guardo la foto";
            mysqli_query($conexion,"insert into "nombreBD"(usuarioID,nombre,apellido,correo,telefono,foto) values('$_POST[usuarioID]','$_POST[nombre]','$_POST[apellido]','$_POST[correo]','$_POST[telefono]','$nombre_img')")
            or die("Problemas en el select".mysqli_error($conexion));
            header("location:mostrar.php");
        }else {
            echo "Tipo de imagen incorrecto";
        }
    }else {
        echo "El tamaño excede el limite de 1 MB";
    }
?>
