<?php
// Process delete operation after confirmation
if (isset($_GET["userID"])) {
    // Include config file
    require_once ('config.php');
    $userID = $_GET["userID"];

    // Prepare a delete statement
    $sql = "DELETE FROM users WHERE userID = $userID";
    if (mysqli_execute_query($link, $sql)) {
        // Records deleted successfully. Redirect to landing page
        header("location: superadmin.php?msg_title=¡Usuario eliminado!&msg_text=El usuario se eliminó correctamente");
        exit();
    } else {
        echo "Oops! Something went wrong. Please try again later.";
    }
}

// Close connection
mysqli_close($link);