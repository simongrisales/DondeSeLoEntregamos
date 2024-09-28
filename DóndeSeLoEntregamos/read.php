<?php
// Check existence of id parameter before processing further
if (isset($_GET["userID"])) {
    if (!empty(trim($_GET["userID"]))) {
        // Include config file
        require_once "config.php";

        $userID =  $_GET["userID"];

        // Prepare a select statement
        $sql = "SELECT * FROM users WHERE userID = $userID";

        if ($result = mysqli_execute_query($link, $sql)) {
            if (mysqli_num_rows($result) == 1) {
                $users = mysqli_fetch_array($result, MYSQLI_ASSOC);

                // Retrieve individual field value
                $name = $users["name"];
                $lastname = $users["lastname"];
                $email = $users["email"];
                $phone = $users["phone"];
                $role = $users["role"];
            } else {
                // URL doesn't contain valid id parameter. Redirect to error page
                header("location: error.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
            mysqli_close($link);
        }
    }
} else {
    // URL doesn't contain id parameter. Redirect to error page
    header("location: error.php");
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <meta charset="UTF-8">
    <title>Agregar usuario</title>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Rubik:ital,wght@0,300..900;1,300..900&display=swap"
        rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Outlined" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Sharp" rel="stylesheet">
    <link rel="stylesheet" href="css/dark.css">
    <link rel="stylesheet" href="css/light.css">
    <link rel="stylesheet" href="css/read.css">

</head>

<body>
    <main>

        <article>
            <md-elevation></md-elevation>
            <h1 class="md-typescale-headline-large">Información del usuario</h1>
            <section>
                <md-icon>id_card</md-icon>
                <h3 class="md-typescale-body-large"><?php echo $userID ?></h3>
            </section>
            <section>
                <md-icon>person</md-icon>
                <h3 class="md-typescale-body-large"><?php echo $name ." ".$lastname ?></h3>
            </section>
            <section>
                <md-icon>email</md-icon>
                <h3 class="md-typescale-body-large"><?php echo $email ?></h3>
            </section>
            <section>
                <md-icon>phone</md-icon>
                <h3 class="md-typescale-body-large"><?php echo $phone ?></h3>
            </section>
            <section>
                <md-icon>badge</md-icon>
                <h3 class="md-typescale-body-large"><?php echo $role ?></h3>
            </section>
            <footer>
                <a href="superadmin.php">
                    <md-filled-button type="button">
                        <md-elevation></md-elevation>
                        Regresar
                    </md-filled-button>
                </a>
            </footer>
        </article>

    </main>

    <script type="importmap">
        {
        "imports": {
          "@material/web/": "https://esm.run/@material/web/"
        }
      }
    </script>
    <script type="module">
        import '@material/web/all.js';
        import {
            styles as typescaleStyles
        } from '@material/web/typography/md-typescale-styles.js';

        document.adoptedStyleSheets.push(typescaleStyles.styleSheet);
    </script>

    <script>
        // function to set a given theme/color-scheme
        function setTheme(themeName) {
            localStorage.setItem('theme', themeName);
            document.documentElement.className = themeName;
        }
        // function to toggle between light and dark theme
        function toggleTheme() {
            if (localStorage.getItem('theme') === 'dark') {
                setTheme('light');
            } else {
                setTheme('dark');
            }
        }
        // Immediately invoked function to set the theme on initial load
        (function() {
            if (localStorage.getItem('theme') === 'dark') {
                setTheme('dark');
            } else {
                setTheme('light');
            }
        })();
    </script>

</body>

</html>