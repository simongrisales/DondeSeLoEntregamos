<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$userID = "";
$name = "";
$name_err = "";
$lastname = "";
$lastname_err = "";
$email = "";
$email_err = "";
$phone = "";
$phone_err = "";
$password = "";
$password_err = "";
$password_old = "";
$password_old_err = "";
$password_database = "";


// Processing form data when form is submitted
if (isset($_POST["userID"])) {
    if (!empty($_POST["userID"])) {
        // Get hidden input value
        $userID = $_POST["userID"];
        $password_database = $_POST["password_database"];

        // Validate name
        $input_name = trim($_POST["name"]);
        if (empty($input_name)) {
            $name_err = "Por favor ingrese un nombre.";
        } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/")))) {
            $name_err = "Por favor ingrese un nombre válido.";
        } else {
            $name = $input_name;
        }

        // Validate lastname
        $input_lastname = trim($_POST["lastname"]);
        if (empty($input_lastname)) {
            $lastname_err = "Por favor ingrese un apellido.";
        } elseif (!filter_var($input_lastname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/")))) {
            $lastname_err = "Por favor ingrese un apellido válido.";
        } else {
            $latname = $input_latname;
        }

        // Validate email
        $input_email = trim($_POST["email"]);
        if (empty($input_email)) {
            $email_err = "Por favor ingrese un correo electrónico.";
        } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Por favor ingrese un email válido.";
        } else {
            $email = $input_email;
        }

        // Validate phone
        $input_phone = trim($_POST["phone"]);
        if (empty($input_phone)) {
            $phone_err = "Por favor ingrese un teléfono.";
        } elseif (!filter_var($input_phone, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/")))) {
            $phone_err = "Por favor ingrese un teléfono válido.";
        } else {
            $phone = $input_phone;
        }

        // Validate password
        $input_password = trim($_POST["password"]);
        if (empty($input_password)) {
            $password_err = "Por favor ingrese una contraseña.";
        } else {
            $password = $input_password;
        }

        // Validate password old
        $input_password_old = trim($_POST["password_old"]);
        $input_password_old = hash('sha512', $input_password_old);
        if (empty($input_password_old) || $input_password_old != $password_database) {
            $password_old_err = "La contraseña anterior es incorrecta.";
        } else {
            $password_old = $input_password_old;
        }

        // Check input errors before inserting in database
        if (empty($name_err) && empty($lastname_err) && empty($email_err) && empty($phone_err) && empty($password_err) && empty($password_old_err)) {

            // Encrypt the password
            $password = hash('sha512', $password);

            // Prepare an update statement
            $sql = "UPDATE users SET name='$name', lastname='$lastname', email='$email', phone='$phone', password='$password' WHERE userID = $userID";

            if (mysqli_execute_query($link, $sql)) {
                // Records updated successfully. Redirect to landing page
                header("location: superadmin.php?msg_title=¡Usuario actualizado!&msg_text=Los datos se almacenaron correctamente");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
    }

    // Close connection
    mysqli_close($link);
} else {

    // Check existence of id parameter before processing further
    if (isset($_GET["userID"])) {
        if (!empty(trim($_GET["userID"]))) {
            // Get URL parameter
            $userID =  trim($_GET["userID"]);

            // Prepare a select statement
            $sql = "SELECT * FROM users WHERE userID = $userID";
            if ($result = mysqli_query($link, $sql)) {

                if (mysqli_num_rows($result) == 1) {
                    $users = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $userID = $users["userID"];
                    $name = $users["name"];
                    $lastname = $users["lastname"];
                    $email = $users["email"];
                    $phone = $users["phone"];
                    $password_database = $users["password"];
                } else {
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close connection
            mysqli_close($link);
        } else {
            // URL doesn't contain id parameter. Redirect to error page
            header("location: error.php");
            exit();
        }
    }
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
    <link rel="stylesheet" href="css/create.css">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <main>
        <md-elevation></md-elevation>
        <h1 class="md-typescale-display-small">Actualizar Empleado</h1>
        </div>
        <p class="md-typescale-body-medium">Para actualizar los datos del usuario debes confirmar la contraseña anterior</p>

        <form action="updateuser.php" method="post">

            <input type="hidden" name="userID" value="<?php echo $userID; ?>">
            <input type="hidden" name="password_database" value="<?php echo $password_database; ?>">

            <section>
                <md-icon>name</md-icon>
                <md-outlined-text-field label="Nombre"
                    type="text"
                    name="name"
                    value="<?php echo $name ?>"
                    <?php if ($name_err) echo 'error error-text="' . $name_err . '">' ?>>
                    <?php if ($name_err) echo '<md-icon slot="trailing-icon">error</md-icon>' ?>
                </md-outlined-text-field>
            </section>

            <section>
                <md-icon>lastname</md-icon>
                <md-outlined-text-field label="Apellido"
                    type="text"
                    name="lastname"
                    value="<?php echo $lastname ?>"
                    <?php if ($lastname_err) echo 'error error-text="' . $lastname_err . '">' ?>>
                    <?php if ($lastname_err) echo '<md-icon slot="trailing-icon">error</md-icon>' ?>
                </md-outlined-text-field>
            </section>

            <section>
                <md-icon>email</md-icon>
                <md-outlined-text-field label="E-mail"
                    type="email"
                    name="email"
                    value="<?php echo $email ?>"
                    <?php if ($email_err) echo 'error error-text="' . $email_err . '">' ?>>
                    <?php if ($email_err) echo '<md-icon slot="trailing-icon">error</md-icon>' ?>
                </md-outlined-text-field>
            </section>

            <section>
                <md-icon>phone</md-icon>
                <md-outlined-text-field label="Teléfono"
                    type="text"
                    name="phone"
                    value="<?php echo $phone ?>"
                    <?php if ($phone_err) echo 'error error-text="' . $phone_err . '">' ?>>
                    <?php if ($phone_err) echo '<md-icon slot="trailing-icon">error</md-icon>' ?>
                </md-outlined-text-field>
            </section>

            <section>
                <md-icon>vpn_key_alert</md-icon>
                <md-outlined-text-field label="Contraseña anterior"
                    type="password"
                    name="password_old"
                    value=""
                    <?php if ($password_old_err) echo 'error error-text="' . $password_old_err . '">' ?>>
                    <?php if ($password_old_err) echo '<md-icon slot="trailing-icon">error</md-icon>';
                    else { ?>
                        <md-icon-button toggle slot="trailing-icon" onclick="show_password('password_old');">
                            <md-icon>visibility_off</md-icon>
                            <md-icon slot="selected">visibility</md-icon>
                        </md-icon-button>
                    <?php } ?>
                </md-outlined-text-field>
            </section>

            <section>
                <md-icon>key</md-icon>
                <md-outlined-text-field label="Nueva contraseña"
                    type="password"
                    name="password"
                    value=""
                    <?php if ($password_err) echo 'error error-text="' . $password_err . '">' ?>>
                    <?php if ($password_err) echo '<md-icon slot="trailing-icon">error</md-icon>';
                    else { ?>
                        <md-icon-button toggle slot="trailing-icon" onclick="show_password('password');">
                            <md-icon>visibility_off</md-icon>
                            <md-icon slot="selected">visibility</md-icon>
                        </md-icon-button>
                    <?php } ?>
                </md-outlined-text-field>
            </section>

            <script>
                function show_password(input_name) {
                    event.preventDefault();
                    let input = document.getElementsByName(input_name)[0];
                    if (input.type === "password") input.type = "text";
                    else input.type = "password";
                }
            </script>

            <footer>
                <a href="superadmin.php" class="btn btn-default">
                    <md-elevated-button type="button">Cancelar</md-elevated-button>
                </a>
                <md-filled-button type="submit">
                    <md-elevation></md-elevation>
                    Aceptar
                </md-filled-button>
            </footer>

        </form>
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