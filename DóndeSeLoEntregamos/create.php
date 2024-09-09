<?php
// Include config file
require_once "config.php";

// Define variables and initialize with empty values
$userID = "";
$userID_err = "";
$name = "";
$name_err = "";
$lastname = "";
$lastname_err = "";
$email = "";
$email_err = "";
$phone = "";
$phone_err = "";
$role = "";
$role_err = "";
$password = "";
$pass_err = "";

// Processing form data when form is submitted
if (isset($_SERVER["REQUEST_METHOD"])) {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        // Validate userID
        $input_userID = trim($_POST["userID"]);
        if (empty($input_userID)) {
            $userID_err = "Por favor ingrese un documento.";
        } else {
            $userID = $input_userID;
        }

        // Validate name
        $input_name = trim($_POST["name"]);
        if (empty($input_name)) {
            $name_err = "Por favor ingrese el nombre del usuario.";
        } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/")))) {
            $name_err = "Por favor ingrese un nombre válido.";
        } else {
            $name = $input_name;
        }

        // Validate lastname
        $input_lastname = trim($_POST["lastname"]);
        if (empty($input_lastname)) {
            $lastname_err = "Por favor ingrese el apellido del usuario.";
        } elseif (!filter_var($input_lastname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/")))) {
            $lastname_err = "Por favor ingrese un apellido válido.";
        } else {
            $lastname = $input_lastname;
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
            $phone_err = "Por favor ingrese el teléfono del usuario.";
        } elseif (!filter_var($input_phone, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/")))) {
            $phone_err = "Por favor ingrese un teléfono válido.";
        } else {
            $phone = $input_phone;
        }

        // Validate role
        $input_role = trim($_POST["role"]);
        if (empty($input_role)) {
            $phone_err = "Por favor ingrese el rol.";
        } elseif (!filter_var($input_role, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/")))) {
            $role_err = "Por favor ingrese un rol válido.";
        } else {
            $role = $input_role;
        }

        // Validate password
        $input_password = trim($_POST["password"]);
        if (empty($input_password)) {
            $password_err = "Por favor ingrese una contraseña.";
        } else {
            $password = $input_password;
        }

        // Check input errors before inserting in database
        if (empty($userID_err) && empty($name_err) && empty($lastname_err) && empty($email_err) && empty($phone_err) && empty($role_err) && empty($password_err)) {

            // Encrypt the password
            $password = password_hash($password, PASSWORD_BCRYPT);

            // Prepare an insert statement
            $sql = "INSERT INTO users (userID,name,lastname,email,phone,role,password) values($userID,'$name','$lastname','$email','$phone','$role','$password')";

            if (mysqli_execute_query($link, $sql)) {

                // Records created successfully. Redirect to landing page
                header("location: superadmin.php?msg_title=¡Nuevo usuario creado!&msg_text=Los datos se almacenaron correctamente");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }

        // Close connection
        mysqli_close($link);
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
</head>

<body>
    <main>
        <md-elevation></md-elevation>
        <h1 class="md-typescale-display-small">
            Agregar Empleado
        </h1>
        </div>
        <p class="md-typescale-body-medium">Por favor ingresa la información del nuevo usuario</p>

        <form action="create.php" method="post">

            <section>
                <md-icon>id_card</md-icon>
                <md-outlined-text-field label="Documento"
                    type="number"
                    name="userID"
                    value="<?php echo $userID ?>"
                    <?php if ($userID_err) echo 'error error-text="' . $userID_err . '">' ?>>
                    <?php if ($userID_err) echo '<md-icon slot="trailing-icon">error</md-icon>' ?>
                </md-outlined-text-field>
            </section>

            <section>
                <md-icon>person</md-icon>
                <md-outlined-text-field label="Nombre"
                    type="text"
                    name="name"
                    value="<?php echo $name ?>"
                    <?php if ($name_err) echo 'error error-text="' . $name_err . '">' ?>>
                    <?php if ($name_err) echo '<md-icon slot="trailing-icon">error</md-icon>' ?>
                </md-outlined-text-field>
            </section>

            <section>
                <md-icon>person_edit</md-icon>
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
                    type="varchar(20)"
                    name="phone"
                    value="<?php echo $phone ?>"
                    <?php if ($phone_err) echo 'error error-text="' . $phone_err . '">' ?>>
                    <?php if ($phone_err) echo '<md-icon slot="trailing-icon">error</md-icon>' ?>
                </md-outlined-text-field>
            </section>

            <section>
                <md-icon>badge</md-icon>
                <md-outlined-text-field label="Role"
                    type="enum('admin', 'client')"
                    name="role"
                    value="<?php echo $role ?>"
                    <?php if ($role_err) echo 'error error-text="' . $role_err . '">' ?>>
                    <?php if ($role_err) echo '<md-icon slot="trailing-icon">error</md-icon>' ?>
                </md-outlined-text-field>
            </section>

            <section>
                <md-icon>key</md-icon>
                <md-outlined-text-field label="Contraseña"
                    type="password"
                    name="password"
                    value="<?php echo $password ?>"
                    <?php if ($password_err) echo 'error error-text="' . $password_err . '">' ?>>
                    <?php if ($password_err) echo '<md-icon slot="trailing-icon">error</md-icon>';
                    else { ?>
                        <md-icon-button toggle slot="trailing-icon" onclick="show_pass('password');">
                            <md-icon>visibility_off</md-icon>
                            <md-icon slot="selected">visibility</md-icon>
                        </md-icon-button>
                    <?php } ?>
                </md-outlined-text-field>
            </section>

            <script>
                function show_pass(input_name) {
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