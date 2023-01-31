<?php
require_once 'config/funciones.inc.php';
require_once 'config/ClaseDB.php';
require_once 'config/Anunciante.php';

if (isset($_POST['enviar'])) {
    $login = $_POST['usuario'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];
    $email = $_POST['email'];

    $error = "";
    //validación de campos
    if (empty($login) || empty($password) || empty($password2) || empty($email)) {
        $error = $error . "Debe de completar todos los campos.<br>";
    } else {
        //nuebo objeto claseDB
        $bd = new ClaseDB();

        //Comprobar si login existe en la base de datos
        if ($bd->existeAnunciante($login))
            $error .= "El login elegido ya existe en la BD.<br>";

        //Comprobar si el email es correcto y la contraseña
        if (comprueba_datos($password, $password2, $email) != "")
            $error .= comprueba_datos($password, $password2, $email);

        //Comprobar si el email existe en la base de datos
        if ($bd->existeMail($email))
            $error .= "El email ya existe en la base de datos.<br>";

        //Si los datos son correctos doy de alta al nuevo usuario
        if (strcmp($error, "") == 0) {
            $password = crypt($password, 'XC');
            $anunciante = new Anunciante($login, $password, 1, $email);

            //insertar anunciante
            if ($bd->insertarAnunciante($anunciante)) {
                $anuncio = "Usuario registrado correctamente";
            } else {
                $error = "Error al insertar el usuario";
            }
        }
    }
}

?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Foro DWES</title>
    <link href="css/registro.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id='registro'>
        <form action='registro.php' method='post'>
            <fieldset>
                <legend>Registro de nuevo usuario</legend>
                <div>
                    <?php
                    if (isset($error)) {
                        echo "<span class='error'>" . $error . "</span>";
                    }
                    if (isset($anuncio)) {
                        echo "<span class='anuncio'>" . $anuncio . "</span>";
                    }
                    ?>
                </div>
                <div class='campo'>
                    <label for='usuario'>Login:</label><br />
                    <input type='text' name='usuario' id='usuario' maxlength="50" value="<?php if (isset($_POST['usuario']) && !isset($anuncio)) echo $_POST['usuario']; ?>" /><br />
                </div>
                <div class='campo'>
                    <label for='password'>Contraseña:</label><br />
                    <input type='password' name='password' id='password' maxlength="8" /><br />
                </div>
                <div class='campo'>
                    <label for='password'>Repita la Contraseña:</label><br />
                    <input type='password' name='password2' id='password2' maxlength="8" /><br />
                </div>
                <div class='campo'>
                    <label for='email'>Email:</label><br />
                    <input type='text' name='email' id='email' maxlength="50" value="<?php if (isset($_POST['email']) && !isset($anuncio)) echo $_POST['email']; ?>" /><br />
                </div>
                <div class='campo'>
                    <input type='submit' name='enviar' value='Enviar' />
                </div>
                <div class='campo'>
                    <input type='button' name='volver' value='Volver' onClick="location.href='index.php'" />
                </div>

        </form>
        </fieldset>
    </div>
</body>

</html>