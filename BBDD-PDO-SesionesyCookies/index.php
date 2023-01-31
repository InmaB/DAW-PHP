<?php
include 'funciones.inc.php';
//Comprobamos si ya se enviado el formulario

session_start();

if (isset($_POST['form_login'])) {
    $login = $_POST['usuario'];
    $password = $_POST['clave'];

    //Comprobar si hay alguno vacio
    if (empty($login) || empty($password))
        $error = "Debes introducir un nombre de usuario y una clave";
    else {
        //Conexion a la BD
        $con = conexion_bd("conta2");

        //Obtenemos la clave almacenado en la BD
        $password_bd = obtener_password($login, $con);

        //Comprobamo las credenciales con la BD
        //password_verify encripta el primer parametro y compara
        if (password_verify($password, $password_bd)) {
            $_SESSION['usuario'] = $login;
            header("Location:cuenta/index.php");
        } else {
            //utilizamos una cookie para controlar el usuario y fallos
            if (!isset($_COOKIE['login'])) {
                $num_fallos = 1;
                setcookie('login', $login, time() + 3600);
                setcookie('num_fallos', $num_fallos, time() + 3600);
                $error = "Contraseña incorrecta primer intento, al tercero se bloquea";
            } else if ($_COOKIE['num_fallos'] == 1 && $_COOKIE['login'] == $login) {
                $num_fallos = 2;
                setcookie('login', $login, time() + 3600);
                setcookie('num_fallos', $num_fallos, time() + 3600);
                $error = "Contraseña incorrecta segundo intento, al tercero se bloquea";
            } else if ($_COOKIE['num_fallos'] == 1 && $_COOKIE['login'] != $login) {
                $num_fallos = 1;
                setcookie('login', $login, time() + 3600);
                setcookie('num_fallos', $num_fallos, time() + 3600);
                $error = "Contraseña incorrecta primer intento, al tercero se bloquea";
            } else if ($_COOKIE['num_fallos'] == 2 && $_COOKIE['login'] == $login) {
                setcookie('login', null, -1);
                setcookie('num_fallos', null, -1);
                $error = "Tras el tercer intento se bloquea";
                header("Location: errorLogin.php");
            } else if ($_COOKIE['num_fallos'] == 2 && $_COOKIE['login'] != $login) {
                $num_fallos = 1;
                setcookie('login', $login, time() + 3600);
                setcookie('num_fallos', $num_fallos, time() + 3600);
                $error = "Contraseña incorrecta primer intento, al tercero se bloquea";
            }
        }
    }
    unset($con);
}
if (isset($_POST['form_admin_login'])) {
    $login = $_POST['usuario'];
    $password = $_POST['clave'];
    if ($login == "daw" && $password == "daw") {
        $_SESSION['admin'] = $login;
        header("Location: admin/index.php");
    } else {
        $error = "Usuario o contraseña incorrectos";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Contabilidad Personal</title>
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>

<body id="pagina-login">
    <header>
        <h1>Gastos Personales</h1>
    </header>
    <nav>Contabilidad personal</nav>
    <main>
        <fieldset class="mini-formulario">
            <legend>Iniciar Sesión</legend>
            <?php
            if (isset($error)) {
                echo "<div class='error'>$error</div>";
            }
            ?>
            <form method="post">
                <div class="input-labeled">
                    <label>Usuario:</label>
                    <input type="text" name="usuario" required maxlength="10">
                </div>


                <div class="input-labeled">
                    <label>Clave:</label>
                    <input type="password" name="clave" required maxlength="20">
                </div>
                <input type="submit" name="form_login" value="Gestionar mi cuenta">
                <hr>
                <input type="submit" name="form_admin_login" value="Gestionar Usuarios">
            </form>
        </fieldset>
    </main>
</body>

</html>