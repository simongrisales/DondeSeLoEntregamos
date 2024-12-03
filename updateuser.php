<?php
require_once "config.php";

$userID = "";
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
$password_err = "";
$password_old = "";
$password_old_err = "";
$password_database = "";

if (isset($_POST["userID"])) {
    if (!empty($_POST["userID"])) {
        $userID = $_POST["userID"];
        $password_database = $_POST["password_database"];

        $input_name = trim($_POST["name"]);
        if (empty($input_name)) {
            $name_err = "Por favor ingrese un nombre.";
        } elseif (!filter_var($input_name, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/")))) {
            $name_err = "Por favor ingrese un nombre válido.";
        } else {
            $name = $input_name;
        }

        $input_lastname = trim($_POST["lastname"]);
        if (empty($input_lastname)) {
            $lastname_err = "Por favor ingrese un apellido.";
        } elseif (!filter_var($input_lastname, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/")))) {
            $lastname_err = "Por favor ingrese un apellido válido.";
        } else {
            $lastname = $input_lastname;
        }

        $input_email = trim($_POST["email"]);
        if (empty($input_email)) {
            $email_err = "Por favor ingrese un correo electrónico.";
        } elseif (!filter_var($input_email, FILTER_VALIDATE_EMAIL)) {
            $email_err = "Por favor ingrese un email válido.";
        } else {
            $email = $input_email;
        }

        $input_phone = trim($_POST["phone"]);
        if (empty($input_phone)) {
            $phone_err = "Por favor ingrese un teléfono.";
        } elseif (!preg_match("/^[0-9]+$/", $input_phone)) {
            $phone_err = "Por favor ingrese un teléfono válido.";
        } else {
            $phone = $input_phone;
        }

        $input_role = trim($_POST["role"]);
        if (empty($input_role)) {
            $role_err = "Por favor ingrese un rol.";
        } elseif (!filter_var($input_role, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => "/^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/")))) {
            $role_err = "Por favor ingrese un rol válido.";
        } else {
            $role = $input_role;
        }

        $input_password = trim($_POST["password"]);
        if (empty($input_password)) {
            $password_err = "Por favor ingrese una contraseña.";
        } else {
            $password = $input_password;
        }

        $input_password_old = trim($_POST["password_old"]);
        if (empty($input_password_old) || !password_verify($input_password_old, $password_database)) {
            $password_old_err = "La contraseña anterior es incorrecta.";
        } else {
            $password_old = $input_password_old;
        }

        if (empty($name_err) && empty($lastname_err) && empty($email_err) && empty($phone_err) && empty($role_err) && empty($password_err) && empty($password_old_err)) {

            // Encriptar la contraseña
            $password = password_hash($password, PASSWORD_BCRYPT);

            $sql = "UPDATE users SET name='$name', lastname='$lastname', email='$email', phone='$phone', role='$role', password='$password' WHERE userID = $userID";

            if (mysqli_execute_query($link, $sql)) {
                header("location: superadmin.php?msg_title=¡Usuario actualizado!&msg_text=Los datos se almacenaron correctamente");
                exit();
            } else {
                echo "Something went wrong. Please try again later.";
            }
        }
    }

    mysqli_close($link);
} else {

    if (isset($_GET["userID"])) {
        if (!empty(trim($_GET["userID"]))) {
            $userID =  trim($_GET["userID"]);

            $sql = "SELECT * FROM users WHERE userID = $userID";
            if ($result = mysqli_query($link, $sql)) {

                if (mysqli_num_rows($result) == 1) {
                    $users = mysqli_fetch_array($result, MYSQLI_ASSOC);

                    $userID = $users["userID"];
                    $name = $users["name"];
                    $lastname = $users["lastname"];
                    $email = $users["email"];
                    $phone = $users["phone"];
                    $role = $users["role"];
                    $password_database = $users["password"];
                } else {
                    header("location: error.php");
                    exit();
                }
            } else {
                echo "Oops! Something went wrong. Please try again later.";
            }
            mysqli_close($link);
        } else {
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
</head>

<body>
    
    <md-filled-button variant="primary" onclick="toggleTheme()">
        Cambiar tema
        <md-icon slot="icon">dark_mode</md-icon>
    </md-filled-button>

    <main>
        <md-elevation></md-elevation>
        <h1 class="md-typescale-display-small">Actualizar Empleado</h1>
        </div>
        <p class="md-typescale-body-medium">Para actualizar los datos del usuario debes confirmar la contraseña anterior</p>

        <form action="updateuser.php" method="post">

            <input type="hidden" name="userID" value="<?php echo $userID; ?>">
            <input type="hidden" name="password_database" value="<?php echo $password_database; ?>">

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
        function setTheme(themeName) {
            localStorage.setItem('theme', themeName);
            document.documentElement.className = themeName;
        }
        function toggleTheme() {
            if (localStorage.getItem('theme') === 'dark') {
                setTheme('light');
            } else {
                setTheme('dark');
            }
        }
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