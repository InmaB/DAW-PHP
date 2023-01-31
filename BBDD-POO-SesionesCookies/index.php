<!-- ADMIN: dwes
CONTRASEÑA: dwes -->

<?php
require_once 'config/ClaseDB.php';
require_once 'config/Anunciante.php';

//Comprobamos si se ha enviado el formulario
if (isset($_POST['enviar'])) {
    $login = $_POST['usuario'];
    $password = $_POST['password'];

    //Comprobar si algún campo es vacio
    if (empty($login) || empty($password))
        $error = "Debes introducir un nombre de usuario y una contraseña";
    else {
        //creamos objeto claseBD
        $bd = new ClaseDB();

        //Obtenemos los datos del anunciante
        if ($bd->existeAnunciante($login)) {
            $anunciante = $bd->obtenerAnunciante($login);
            $password_bd = $anunciante->getPassword();

            if ($anunciante->getBloqueado())
                $error = "La cuenta esta bloqueada, hasta que un administrador te ayude";
            else {
                if (strlen($password) > 8) {
                    $error = "La contraseña es demasiado larga";
                }
                //Comprobamos las credenciales con la BD
                if (password_verify($password, $password_bd)) {
                    //Si el usuario no está bloqueado inicio la sesión
                    if (!$anunciante->getBloqueado()) {
                        session_start();
                        $_SESSION['usuario'] = $login;
                        $_SESSION['hora'] = date("H:i", time());
                        setcookie('login', null, -1);
                        setcookie('num_fallos', null, -1);
                        header("Location: usuario.php");
                    } else {
                        $error = "El usuario está bloqueado. Solo un administrador lo desbloquea";
                    }
                } else {
                    //utilizamos una cookie para controlar el usuario y fallos
                    if (!isset($_COOKIE['login']) || $_COOKIE['login'] != $login) {
                        $num_fallos = 1;
                        setcookie('login', $login, time() + 3600);
                        setcookie('num_fallos', $num_fallos, time() + 3600);
                        $error = "Contraseña incorrecta primer intento, al tercero se bloquea";
                    } elseif ($_COOKIE['num_fallos'] == 1) {
                        $num_fallos = $_COOKIE['num_fallos'] + 1;
                        setcookie('login', $login, time() + 3600);
                        setcookie('num_fallos', $num_fallos, time() + 3600);
                        $error = "Contraseña incorrecta segundo intento, al tercero se bloquea";
                    } else {
                        setcookie('login', null, -1);
                        setcookie('num_fallos', null, -1);
                        try {
                            $bd->query("UPDATE anunciantes SET bloqueado=1 WHERE login='$login'");
                            $error = "Tras el tercer intento se bloquea";
                        } catch (PDOException $e) {
                            $error = "Error al bloquear al usuario";
                        }
                    }
                }
            }
        } else {
            $error = "El usuario no existe";
        }
    }
    unset($con);
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8">
    <title>Empresa Okupa</title>
    <link href="css/login.css" rel="stylesheet" type="text/css">
</head>

<body>
    <div id='login'>
        <form action='index.php' method='post'>
            <fieldset>
                <legend>Login</legend>
                <div><span class='error'><?php if (isset($error)) echo $error; ?></span></div>
                <div class='campo'>
                    <label for='usuario'>Usuario:</label><br />
                    <input type='text' name='usuario' id='usuario' maxlength="50" /><br />
                </div>
                <div class='campo'>
                    <label for='password'>Contraseña:</label><br />
                    <input type='password' name='password' id='password' maxlength="8" /><br />
                </div>

                <div class='campo'>
                    <input type='submit' name='enviar' value='Enviar' />
                </div>
                <div class='enlace'>
                    <a href='registro.php'>Registrarse</a>
                </div>
                <div class='enlace'>
                    <a href='invitado.php'>Entrar como invitado</a>
                </div>

            </fieldset>
        </form>
    </div>
</body>

</html>