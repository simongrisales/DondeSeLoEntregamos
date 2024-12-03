<?php
if (isset($_GET["userID"])) {
    require_once ('config.php');
    $userID = $_GET["userID"];

    $sql = "DELETE FROM users WHERE userID = $userID";
    if (mysqli_execute_query($link, $sql)) {
        header("location: superadmin.php?msg_title=¡Usuario eliminado!&msg_text=El usuario se eliminó correctamente");
        exit();
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}

mysqli_close($link);
?>